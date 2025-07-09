<?php

namespace App\Livewire\FrontEnd\SalaryCalculatorPage;

use Illuminate\Support\Carbon;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Visit;
use Stevebauman\Location\Facades\Location;
use App\Models\Visits;
use App\Services\Payslip\GeneratePdf;

class NormalCalculatorSalaryPage extends Component
{
    public $salaire_brut, $mois_brut;
    public $cnss_ouvriere_brut = 3.6;
    public $cnss_patronale_brut = 16.4;
    public $vps_brut = 4;
    public $coutTotalEmployeur = 0;
    public $resultats = [];
    public $showModal = false;
    // public GeneratePdf $generatepdf;

    // public function boot(GeneratePdf $generatepdf)
    // {
    //     $this->generatepdf = $generatepdf;
    // }

    public $periode_paie,  $nom_employe, $date_embauche, $entreprise,
        $type_contrat, $num_cnss_employe, $num_cnss_employeur, $poste_employe, $adresse_entreprise,
        $ifu_employe, $ifu_employeur, $signature_employeur;

    public function mount()
    {
        Carbon::setLocale('fr');
        $this->mois_brut = ucfirst(Carbon::now()->isoFormat('MMMM'));
        $this->periode_paie = ucfirst(Carbon::now()->translatedFormat('F Y'));
    }
    /*enregistrement des visiteurs*/
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
    /*calcul de l'impôt*/
    public function getTaxRate(int $income): float
    {
        $income = (int)$income;
        if ($income <= 60000) return 0;
        if ($income <= 150000) return ($income - 60000) * 0.1;
        if ($income <= 250000) return ($income - 150000) * 0.15 + 9000;
        if ($income <= 500000) return ($income - 250000) * 0.19 + 24000;
        return ($income - 500000) * 0.3 + 71500;
    }

     /*Taxes spécifiques*/
    public function getSpecificTax(string $month): array
    {
        $m = strtolower($month);
        $currentYear = date('Y');

        if ($m === 'mars' && $currentYear == date('Y')) {
            return ['montant' => 1000, 'label' => 'Taxe Radiophonique'];
        }
        if ($m === 'juin' && $currentYear == date('Y')) {
            return ['montant' => 3000, 'label' => 'Taxe Télévisuelle'];
        }
        return ['montant' => 0, 'label' => 'Aucune taxe spécifique'];
    }


    public function calculateNetFromBrut(float $gross, string $month, float $cnssOuvriereRate): float
    {
        $taxeSpecifique = $this->getSpecificTax($month)['montant'];
        $impots = $this->getTaxRate((int)$gross);
        $cnssOuvriere = $gross * $cnssOuvriereRate;
        return $gross - $cnssOuvriere - $impots - $taxeSpecifique;
    }


    public function findGrossSalaryFinal(float $targetNet, string $month, float $cnssOuvriereRate): int
    {
        $low = 0;
        $high = 5000000;
        $tolerance = 0.01;
        $estimatedGross = 0;

        for ($i = 0; $i < 200; $i++) {
            $estimatedGross = $low + ($high - $low) / 2;
            $calculatedNet = $this->calculateNetFromBrut($estimatedGross, $month, $cnssOuvriereRate);
            $diff = $calculatedNet - $targetNet;

            if (abs($diff) < $tolerance) {
                return (int) round($estimatedGross);
            }

            if ($diff < 0) {
                $low = $estimatedGross;
            } else {
                $high = $estimatedGross;
            }
        }
        return (int) round($estimatedGross);
    }
    /*Pour le calcule à partir du salaire brut*/
    public function calculer()
    {

        $this->enregistrerVisits('brut');

        if (!$this->salaire_brut || $this->salaire_brut <= 0) {
            $this->addError('salaire_brut', 'Salaire brut invalide.');
            return;
        }

        $this->periode_paie = ucfirst($this->mois_brut) . ' ' . date('Y');
        $cnssOuvriereRate = $this->cnss_ouvriere_brut / 100;
        $cnssPatronaleRate = $this->cnss_patronale_brut / 100;
        $vpsRate = $this->vps_brut / 100;

        $cnssOuvriere = $this->salaire_brut * $cnssOuvriereRate;
        $cnssPatronale = $this->salaire_brut * $cnssPatronaleRate;
        $vps = $this->salaire_brut * $vpsRate;
        $impots = $this->getTaxRate((int)$this->salaire_brut);
        $taxeSpecifique = $this->getSpecificTax($this->mois_brut);
        $net = $this->salaire_brut - $cnssOuvriere - $impots - $taxeSpecifique['montant'];

        $coutTotalEmployeur = $this->salaire_brut + $cnssPatronale + $vps;
        $this->coutTotalEmployeur = $coutTotalEmployeur;

        $this->resultats = [
            ['label' => 'Salaire Brut', 'val' => number_format($this->salaire_brut, 0, ',', ' ')],
            ['label' => 'CNSS Ouvrière', 'val' => number_format($cnssOuvriere, 0, ',', ' ')],
            ['label' => 'Impôt sur salaire', 'val' => number_format($impots, 0, ',', ' ')],
            ['label' => $taxeSpecifique['label'], 'val' => number_format($taxeSpecifique['montant'], 0, ',', ' ')],
            ['label' => 'Salaire Net à payer', 'val' => number_format($net, 0, ',', ' ')],
            ['label' => 'CNSS Patronale', 'val' => number_format($cnssPatronale, 0, ',', ' ')],
            ['label' => 'VPS', 'val' => number_format($vps, 0, ',', ' ')],
        ];
    }

    public function messages()
    {
        return [
            'salaire_brut.required' => 'Entrer un salaire brut est obligatoire.',
            'salaire_brut.numeric'  => 'Le salaire brut doit être un nombre.',
            'salaire_brut.min'      => 'Le salaire brut ne peut pas être négatif.',
        ];
    }
    public function incrementerPDF($type)
    {
        $ip = request()->ip();
        $visits = Visits::where('ip', $ip)->where('type_calcul', $type)->first();

        if ($visits) {
            $visits->increment('pdf_count');
        }
    }
    /*Génération du PDF*/
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
        return view('livewire.front-end.salary-calculator-page.normal-calculator-salary-page');
    }
}
