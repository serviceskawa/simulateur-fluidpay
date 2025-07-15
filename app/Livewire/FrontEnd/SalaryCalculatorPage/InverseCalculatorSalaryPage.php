<?php

namespace App\Livewire\FrontEnd\SalaryCalculatorPage;


use Livewire\Component;
use Carbon\Carbon;
use App\Models\Visits;
use App\Services\Payslip\GeneratePdf ;
use Barryvdh\DomPDF\Facade\Pdf;

class InverseCalculatorSalaryPage extends Component
{
    public $salaire_brut;
    public $salaire_net;
    public $mois_brut;
    public $mois_inverse;
    public $cnss_ouvriere = 3.6;
    public $cnss_patronale = 16.4;
    public $vps = 4;
    public $resultats = [];
    public $coutTotalEmployeur = 0;
    public $coutTotalEmployeurFormatted;
    public $periode_paie;
    public $showModal = false;


    // Infos employé/entreprise (pour PDF)
    public $nom_employe, $date_embauche, $entreprise, $type_contrat,
           $num_cnss_employe, $num_cnss_employeur, $poste_employe,
           $adresse_entreprise, $date_fin_contrat, $ifu_employe,
           $ifu_employeur, $signature_employeur;

    public function mount()
    {
        Carbon::setLocale('fr');
        $this->mois_inverse = ucfirst(strtolower(Carbon::now()->isoFormat('MMMM')));
    }

    /* --- Fonction pour enregistrer les visites --- */
    public function enregistrerVisits($type)
    {
        $ip = request()->ip();

        $visits = Visits::where('ip', $ip)->where('type_calcul', $type)->first();

        if ($visits) {
            $visits->increment('calcul_count');
        } else {
            Visits::create([
                'ip' => $ip,
                'type_calcul' => $type,
                'calcul_count' => 1,
                'pdf_count' => 0,
            ]);
        }
    }

    /* --- Calcul des impôts progressifs --- */
    public function getTaxRate(int $income): float
    {
        if ($income <= 60000) return 0;
        if ($income <= 150000) return ($income - 60000) * 0.1;
        if ($income <= 250000) return ($income - 150000) * 0.15 + 9000;
        if ($income <= 500000) return ($income - 250000) * 0.19 + 24000;
        return ($income - 500000) * 0.3 + 71500;
    }

    public function getTaxBracket(int $income): string
    {
        if ($income <= 60000) return '0%';
        if ($income <= 150000) return '10%';
        if ($income <= 250000) return '15%';
        if ($income <= 500000) return '19%';
        return '30%';
    }

    /* --- Taxe spécifique selon le mois et le salaire brut --- */
  public function getSpecificTax(string $month, float $salaireNet = 0): array
{
    $m = strtolower($month);

    // Taxes spécifiques
    $taxes = [
        'mars' => ['montant' => 1000, 'label' => 'Taxe Radiophonique'],
    ];

    // Taxe spécifique pour juin uniquement si le salaire est ≥ 60000
    if ($m === 'juin' && $salaireNet >= 60000) {
        return ['montant' => 3000, 'label' => 'Taxe Télévisuelle'];
    }

    return $taxes[$m] ?? ['montant' => 0, 'label' => 'Aucune taxe spécifique'];
}

    /* --- Calcul CNSS/VPS --- */
    public function calcCNSS(float $montant, float $taux): float
    {
        return $montant * $taux;
    }

    /* --- Calcul du salaire net à partir du salaire brut --- */
    public function calculerNet()
    {
        $this->resetErrorBag();

        if (!is_numeric($this->salaire_brut) || $this->salaire_brut <= 0) {
            $this->addError('salaire_brut', 'Veuillez saisir un salaire brut valide.');
            return;
        }
        if (empty($this->mois_brut)) {
            $this->addError('mois_brut', 'Veuillez choisir un mois.');
            return;
        }

        $this->periode_paie = ucfirst($this->mois_brut) . ' ' . date('Y');

        $SB = (float)$this->salaire_brut;
        $cnssOuvriereRate = $this->cnss_ouvriere / 100;
        $cnssPatronaleRate = $this->cnss_patronale / 100;
        $vpsRate = $this->vps / 100;

        $cnssOuvriere = $this->calcCNSS($SB, $cnssOuvriereRate);
        $cnssPatronale = $this->calcCNSS($SB, $cnssPatronaleRate);
        $vps = $this->calcCNSS($SB, $vpsRate);
        $impots = $this->getTaxRate((int)$SB);
        $taxeSpecifique = $this->getSpecificTax($this->mois_brut, $SB);

        $net = $SB - $cnssOuvriere - $impots - $taxeSpecifique['montant'];

        $this->resultats = [
            ['label' => 'Salaire Brut', 'val' => number_format($SB, 0, ',', ' ')],
            ['label' => 'CNSS Ouvrière', 'val' => number_format($cnssOuvriere, 0, ',', ' ')],
            ['label' => 'Impôt sur salaire (' . $this->getTaxBracket((int)$SB) . ')', 'val' => number_format($impots, 0, ',', ' ')],
            ['label' => $taxeSpecifique['label'], 'val' => number_format($taxeSpecifique['montant'], 0, ',', ' ')],
            ['label' => 'Salaire Net à payer', 'val' => number_format($net, 0, ',', ' ')],
            ['label' => 'CNSS Patronale', 'val' => number_format($cnssPatronale, 0, ',', ' ')],
            ['label' => 'VPS', 'val' => number_format($vps, 0, ',', ' ')],
        ];
    }

    /* --- Formattage FCFA --- */
    public function formaterFcfa($montant)
    {
        return number_format($montant, 0, ',', ' ') . ' FCFA';
    }

    /* --- Calcul du net depuis un brut donné (utilisé pour la recherche binaire inverse) --- */
    public function calculateNetFromBrut(float $gross, string $month, float $cnssOuvriereRate): float
    {
        $impots = $this->getTaxRate((int)$gross);
        $taxeSpecifique = $this->getSpecificTax($month, $gross);
        $cnssOuvriere = $gross * $cnssOuvriereRate;

        return $gross - $cnssOuvriere - $impots - $taxeSpecifique['montant'];
    }

    /* --- Trouver le salaire brut à partir d'un net cible (recherche binaire) --- */
    public function findGrossSalaryFinal(float $targetNet, string $month, float $cnssOuvriereRate): float
    {
        $low = 0;
        $high = 5000000;
        $tolerance = 0.01;
        $maxIterations = 200;
        $mid = 0;

        for ($i = 0; $i < $maxIterations; $i++) {
            $mid = ($low + $high) / 2;
            $calculatedNet = $this->calculateNetFromBrut($mid, $month, $cnssOuvriereRate);
            $diff = $calculatedNet - $targetNet;

            if (abs($diff) < $tolerance) {
                return round($mid, 2);
            }

            if ($diff < 0) {
                $low = $mid;
            } else {
                $high = $mid;
            }
        }

        return round($mid, 2);
    }

    /* --- Calcul inverse : net -> brut --- */
    public function calculerInverse()
    {
        $this->enregistrerVisits('net');
        $this->resetErrorBag();

        if (!is_numeric($this->salaire_net) || $this->salaire_net <= 0) {
            $this->addError('salaire_net', 'Veuillez saisir un salaire net valide.');
            return;
        }

        if (empty($this->mois_inverse)) {
            $this->addError('mois_inverse', 'Veuillez choisir un mois.');
            return;
        }

        $this->periode_paie = ucfirst($this->mois_inverse) . ' ' . date('Y');
        $cnssOuvriereRate = $this->cnss_ouvriere / 100;

        $gross = $this->findGrossSalaryFinal(floatval($this->salaire_net), $this->mois_inverse, $cnssOuvriereRate);

        $cnssOuvriere = $gross * $cnssOuvriereRate;
        $cnssPatronale = $gross * ($this->cnss_patronale / 100);
        $vps = $gross * ($this->vps / 100);
        $impots = $this->getTaxRate((int)$gross);
        $taxeSpecifique = $this->getSpecificTax($this->mois_inverse, $gross);

        $coutTotalEmployeur = $gross + $cnssPatronale + $vps;
        $this->coutTotalEmployeur = $coutTotalEmployeur;
        $this->coutTotalEmployeurFormatted = $this->formaterFcfa($coutTotalEmployeur);

        $this->resultats = [
            ['label' => 'Salaire brut estimé', 'val' => number_format($gross, 0, ',', ' ')],
            ['label' => 'CNSS Ouvrière', 'val' => number_format($cnssOuvriere, 0, ',', ' ')],
            ['label' => 'Impôt sur salaire (' . $this->getTaxBracket((int)$gross) . ')', 'val' => number_format($impots, 0, ',', ' ')],
            ['label' => $taxeSpecifique['label'], 'val' => number_format($taxeSpecifique['montant'], 0, ',', ' ')],
            ['label' => 'Salaire net à payer', 'val' => number_format($this->salaire_net, 0, ',', ' ')],
            ['label' => 'CNSS Patronale', 'val' => number_format($cnssPatronale, 0, ',', ' ')],
            ['label' => 'VPS', 'val' => number_format($vps, 0, ',', ' ')],
        ];
    }

    /* --- Incrément PDF --- */
    public function incrementerPDF($type)
    {
        $ip = request()->ip();

        $visits = Visits::where('ip', $ip)->where('type_calcul', $type)->first();

        if ($visits) {
            $visits->increment('pdf_count');
        }
    }

    /* --- Génération PDF --- */
   public function generatePayslipPdf(GeneratePdf $generatepdf)
    {
        $typeCalcul = $this->type_calcul ?? 'brut';
        // Incrémente pdf_count dans la base
        $this->incrementerPDF($typeCalcul);

        $data = [
            'periode_paie' => $this->periode_paie,
            'nom_employe' => $this->nom_employe,
            'date_embauche' => $this->date_embauche,
            'type_contrat' => $this->type_contrat,
            'num_cnss_employe' => $this->num_cnss_employe,
            'num_cnss_employeur' => $this->num_cnss_employeur,
            'poste_employe' => $this->poste_employe,
            'ifu_employe' => $this->ifu_employe,
            'ifu_employeur' => $this->ifu_employeur,
            'entreprise' => $this->entreprise,
            'adresse_entreprise' => $this->adresse_entreprise,
            'coutTotalEmployeur' => $this->coutTotalEmployeur,
            'resultats' => $this->resultats,
        ];

        try {
            $pdf = $generatepdf->generate($data);

            if (!$pdf) {
                $this->addError('pdf', 'Erreur lors de la génération du PDF.');
                return;
            }

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'fiche-de-paie.pdf');
        } catch (\Exception $e) {
            dd($e->getMessage());
            $this->addError('pdf', 'Une erreur est survenue lors de la génération du PDF.');
        }

        $pdf = PDF::loadView('pdf.payslip', [
            'periode_paie' => $this->periode_paie,
            'nom_employe' => $this->nom_employe,
            'date_embauche' => $this->date_embauche,
            'type_contrat' => $this->type_contrat,
            'num_cnss_employe' => $this->num_cnss_employe,
            'num_cnss_employeur' => $this->num_cnss_employeur,
            'poste_employe' => $this->poste_employe,
            'ifu_employe' => $this->ifu_employe,
            'ifu_employeur' => $this->ifu_employeur,
            'coutTotalEmployeur' => $this->coutTotalEmployeur,
            'entreprise' => $this->entreprise,
            'resultats' => $this->resultats,
        ]);

        return $pdf->download('fiche-de-paie.pdf');
    }

    public function render()
    {
        return view('livewire.front-end.salary-calculator-page.inverse-calculator-salary-page');
    }
}
