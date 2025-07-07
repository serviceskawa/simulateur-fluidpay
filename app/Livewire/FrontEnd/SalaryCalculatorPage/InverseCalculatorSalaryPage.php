<?php

namespace App\Livewire\FrontEnd\SalaryCalculatorPage;

use App\Services\GeneratePdf as ServicesGeneratePdf;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\Livewire;
use App\Services\PayslipService;
use WithFileUploads;
use App\Services\Payslip\GeneratePdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Container\Attributes\Log;

class InverseCalculatorSalaryPage extends Component
{
    public $salaire_brut;
    public $coutTotalEmployeur = 0;
    public $coutTotalEmployeurFormatted;
    public $salaire_net;
    public $email = '';
    public $mois_brut;
    public $mois_inverse;
    public $showShareModal = false;
    public $cnss_ouvriere = 3.6;
    public $cnss_patronale = 16.4;
    public $vps = 4;
    public $resultats = [];
    public $type_calcul = null;
    public $showModal = false;
    public $periode_paie,  $nom_employe, $date_embauche,$entreprise,
        $type_contrat, $num_cnss_employe, $num_cnss_employeur, $poste_employe, $adresse_entreprise,
        $date_fin_contrat, $ifu_employe,   $ifu_employeur, $signature_employeur;

    public function mount()
    {
        Carbon::setLocale('fr');
        $this->mois_inverse = ucfirst(strtolower(Carbon::now()->isoFormat('MMMM')));
    }

    public $fichier;

    public function updatedFichier()
    {
        $this->validate([
            'fichier' => 'required|file|max:2048|mimes:pdf,jpg,png,jpeg',
        ]);
    }

    public function uploadFichier()
    {
        $this->validate([
            'fichier' => 'required|file|max:2048|mimes:pdf,jpg,png,jpeg',
        ]);

        $path = $this->fichier->store('uploads', 'public');

        session()->flash('message', 'Fichier uploadé avec succès : ' . $path);
    }

    public function getTaxRate(int $income): float
    {
        $income= floor($income / 1000) * 1000;
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

    public function getSpecificTax(string $month): array
    {
        $m = strtolower($month);
        $currentYear = date('Y');
        if ($m === 'mars') return ['montant' => 1000, 'label' => 'Taxe Radiophonique'];
        if ($m === 'juin') return ['montant' => 3000, 'label' => 'Taxe Télévisuelle'];
        return ['montant' => 0, 'label' => 'Aucune taxe spécifique'];
    }

    public function calcCNSS(float $montant, float $taux): float
    {
        return $montant * $taux;
    }

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
        $taxeSpecifique = $this->getSpecificTax($this->mois_brut);

        $net = $SB - $cnssOuvriere - $impots - $taxeSpecifique['montant'];
        $this->resultats = [
            ['label' => 'Salaire Brut', 'val' => number_format($SB, 0, ',', ' ') ],
            ['label' => 'CNSS Ouvrière', 'val' => number_format($cnssOuvriere, 0, ',', ' ') ],
            ['label' => 'Impôt sur salaire (' . $this->getTaxBracket((int)$SB) . ')', 'val' => number_format($impots, 0, ',', ' ') ],
            ['label' => $taxeSpecifique['label'], 'val' => number_format($taxeSpecifique['montant'], 0, ',', ' ')],
            ['label' => 'Salaire Net à payer', 'val' => number_format($net, 0, ',', ' ') ],
            ['label' => 'CNSS Patronale', 'val' => number_format($cnssPatronale, 0, ',', ' ') ],
            ['label' => 'VPS', 'val' => number_format($vps, 0, ',', ' ') ],
        ];


    }

    public function formaterFcfa($montant)
    {
        return number_format($montant, 0, ',', ' ') . ' FCFA';
    }

    public function calculateNetFromBrut(float $gross, string $month, float $cnssOuvriereRate): float
    {
        $impots = $this->getTaxRate((int)$gross);
        $taxeSpecifique = $this->getSpecificTax($month);
        $cnssOuvriere = $gross * $cnssOuvriereRate;

        return $gross - $cnssOuvriere - $impots - $taxeSpecifique['montant'];
    }

    public function findGrossSalaryFinal(float $targetNet, string $month, float $cnssOuvriereRate): float
    {
        $low = 0;
        $high = 5_000_000;
        $tolerance = 1;
        $maxIterations = 200;
        $mid = 0;
        for ($i = 0; $i < $maxIterations; $i++) {
            $mid = ($low + $high) / 2;
            $calculatedNet = $this->calculateNetFromBrut($mid, $month, $cnssOuvriereRate);
            $diff = $calculatedNet - $targetNet;

             if (abs($diff) < $tolerance) {
                return round($mid);
            }
            if ($diff < 0) {
                $low = $mid;
            } else {
                $high = $mid;
            }
        }

        return round($mid);
    }

    public function calculerInverse()
    {
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
        $gross = $this->findGrossSalaryFinal((float)$this->salaire_net, $this->mois_inverse, $cnssOuvriereRate);
        $cnssOuvriere = $gross * $cnssOuvriereRate;
        $cnssPatronale = $gross * ($this->cnss_patronale / 100);
        $vps = $gross * ($this->vps / 100);
        $impots = $this->getTaxRate((int)$gross);
        $taxeSpecifique = $this->getSpecificTax($this->mois_inverse);
        $coutTotalEmployeur = $gross + $cnssPatronale + $vps;
        $texte = $this->formaterFcfa($coutTotalEmployeur);
        $this->coutTotalEmployeur = $coutTotalEmployeur;
        $this->coutTotalEmployeurFormatted = $texte;
        $this->resultats = [
            ['label' => 'Salaire brut estimé', 'val' => number_format($gross, 0, ',', ' ') ],
            ['label' => 'CNSS Ouvrière', 'val' => number_format($cnssOuvriere, 0, ',', ' ') ],
            ['label' => 'Impôt sur salaire (' . $this->getTaxBracket((int)$gross) . ')', 'val' => number_format($impots, 0, ',', ' ') ],
            ['label' => $taxeSpecifique['label'], 'val' => number_format($taxeSpecifique['montant'], 0, ',', ' ') ],
            ['label' => 'Salaire net à payer', 'val' => number_format($this->salaire_net, 0, ',', ' ') ],
            ['label' => 'CNSS Patronale', 'val' => number_format($cnssPatronale, 0, ',', ' ') ],
            ['label' => 'VPS', 'val' => number_format($vps, 0, ',', ' ')],
        ];


    }

    public function generatePayslipPdf()
    {
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
            'entreprise'=>$this ->entreprise,
            'adresse_entreprise'=>$this->adresse_entreprise,
             'coutTotalEmployeur' => $this->coutTotalEmployeur,
            'resultats' => $this->resultats,
        ];

        try {
            $generatepdf = new \App\Services\Payslip\GeneratePdf();
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
            'entreprise'=>$this ->entreprise,
            'resultats' => $this->resultats,
        ]);

        return $pdf->download('fiche-de-paie.pdf');
    }

    public function render()
    {
        return view('livewire.front-end.salary-calculator-page.inverse-calculator-salary-page');
    }
}
