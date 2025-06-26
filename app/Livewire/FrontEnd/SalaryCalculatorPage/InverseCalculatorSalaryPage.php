<?php

namespace App\Livewire\FrontEnd\SalaryCalculatorPage;

use Livewire\Component;
use Carbon\Carbon;
 use Barryvdh\DomPDF\Facade\Pdf;

class InverseCalculatorSalaryPage extends Component
{

     public $salaire_brut;
    public $salaire_net;
    public $shareOption = 'whatsapp'; // Valeur par défaut

    public $email = '';

    public $mois_brut;
    public $mois_inverse;
    public $showShareModal = false;

    public $cnss_ouvriere = 3.6;
    public $cnss_patronale = 16.4;
    public $vps = 4;

    public $resultats = [];

    public $type_calcul = null; // 'brut' ou 'net'
    public function mount()
    {
        Carbon::setLocale('fr');

        $this->mois_inverse = Carbon::now()->isoFormat('MMMM'); // Par exemple "juin"
$this->mois_inverse = ucfirst(strtolower($this->mois_inverse)); // => "Juin"

    }

    // Calcule l'impôt selon les tranches
    public function getTaxRate(int $income): float
    {
        $income = (int)$income;
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


    public function openPdf()
{
    // stocke en session ou crée une URL signée avec les données nécessaires
    session(['payslip_data' => [
        'periode_paie' => $this->periode_paie,
        'date_paiement' => $this->date_paiement,
        'nom_employe' => $this->nom_employe,
        'resultats' => $this->resultats,
    ]]);

    $this->dispatchBrowserEvent('open-pdf');
}




public $showModal = false;
public $periode_paie, $date_paiement, $nom_employe, $date_embauche,
       $type_contrat, $num_cnss_employe, $num_cnss_employeur, $poste_employe,
       $date_fin_contrat, $ifu, $logo_entreprise, $signature_employeur;

public function openModal()
{
    $this->showModal = true;
    $this->periode_paie = $this->mois_inverse . ' ' . now()->year;
    $this->date_paiement = now()->format('Y-m-d');
}

public function closeModal()
{
    $this->showModal = false;
}





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


    // En haut du fichier

// ...

public function generatePayslipPdf()
{
    // Valide les champs nécessaires pour la fiche de paie
    $this->validate([
        'periode_paie' => 'required|string|max:255',
        'date_paiement' => 'required|date',
        'nom_employe' => 'required|string|max:255',
        'date_embauche' => 'required|date',
        'type_contrat' => 'required|string|max:100',
        'num_cnss_employe' => 'required|string|max:50',
        'num_cnss_employeur' => 'required|string|max:50',
        'poste_employe' => 'required|string|max:255',
        'date_fin_contrat' => 'nullable|date|after_or_equal:date_embauche',
        'ifu' => 'required|string|max:50',
        // Pour images, tu peux gérer l'upload avant ou adapter si c'est un chemin/url
        'logo_entreprise' => 'nullable|string|max:255',
        'signature_employeur' => 'nullable|string|max:255',
    ]);

    // Prépare les données à passer à la vue PDF
    $data = [
        'periode_paie' => $this->periode_paie,
        'date_paiement' => $this->date_paiement,
        'nom_employe' => $this->nom_employe,
        'date_embauche' => $this->date_embauche,
        'type_contrat' => $this->type_contrat,
        'num_cnss_employe' => $this->num_cnss_employe,
        'num_cnss_employeur' => $this->num_cnss_employeur,
        'poste_employe' => $this->poste_employe,
        'date_fin_contrat' => $this->date_fin_contrat,
        'ifu' => $this->ifu,
        'logo_entreprise' => $this->logo_entreprise,
        'signature_employeur' => $this->signature_employeur,
        'resultats' => $this->resultats,
    ];

    // Génère le PDF depuis la vue 'pdf.payslip'
    $pdf = Pdf::loadView('pdf.payslip', $data);

    // Ferme la modale
    $this->showModal = false;

    // Retourne la réponse pour déclencher le téléchargement du PDF
    return response()->streamDownload(
        fn () => print($pdf->output()),
        "fiche-de-paie-{$this->periode_paie}.pdf"
    );
}



    // Calcul CNSS ou VPS
    public function calcCNSS(float $montant, float $taux): float
    {
        return $montant * $taux;
    }

    // Calcul net à partir du brut
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
            ['label' => 'Salaire Brut', 'val' => number_format($SB, 0, ',', ' ') . ' FCFA'],
            ['label' => 'CNSS Ouvrière', 'val' => number_format($cnssOuvriere, 0, ',', ' ') . ' FCFA'],
            ['label' => 'Impôt sur salaire (' . $this->getTaxBracket((int)$SB) . ')', 'val' => number_format($impots, 0, ',', ' ') . ' FCFA'],
            ['label' => $taxeSpecifique['label'], 'val' => number_format($taxeSpecifique['montant'], 0, ',', ' ') . ' FCFA'],
            ['label' => 'Salaire Net à payer', 'val' => number_format($net, 0, ',', ' ') . ' FCFA'],
            ['label' => 'CNSS Patronale', 'val' => number_format($cnssPatronale, 0, ',', ' ') . ' FCFA'],
            ['label' => 'VPS', 'val' => number_format($vps, 0, ',', ' ') . ' FCFA'],
        ];
    }

    // Calcule le net pour un brut donné (aide pour méthode binaire inverse)
    public function calculateNetFromBrut(float $gross, string $month, float $cnssOuvriereRate): float
    {
        $impots = $this->getTaxRate((int)$gross);
        $taxeSpecifique = $this->getSpecificTax($month);
        $cnssOuvriere = $gross * $cnssOuvriereRate;

        return $gross - $cnssOuvriere - $impots - $taxeSpecifique['montant'];
    }

    // Recherche du salaire brut approximatif via méthode binaire
    public function findGrossSalaryFinal(float $targetNet, string $month, float $cnssOuvriereRate): float
    {
        $low = 0;
        $high = 5_000_000;
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

    // Calcul inverse : net → brut
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
            $this->type_calcul = 'net';
        }

        $cnssOuvriereRate = $this->cnss_ouvriere / 100;

        $gross = $this->findGrossSalaryFinal((float)$this->salaire_net, $this->mois_inverse, $cnssOuvriereRate);

        $cnssOuvriere = $gross * $cnssOuvriereRate;
        $cnssPatronale = $gross * ($this->cnss_patronale / 100);
        $vps = $gross * ($this->vps / 100);
        $impots = $this->getTaxRate((int)$gross);
        $taxeSpecifique = $this->getSpecificTax($this->mois_inverse);

        $this->resultats = [
            ['label' => 'Salaire brut estimé', 'val' => number_format($gross, 0, ',', ' ') . ' FCFA'],
            ['label' => 'CNSS Ouvrière', 'val' => number_format($cnssOuvriere, 0, ',', ' ') . ' FCFA'],
            ['label' => 'Impôt sur salaire (' . $this->getTaxBracket((int)$gross) . ')', 'val' => number_format($impots, 0, ',', ' ') . ' FCFA'],
            ['label' => $taxeSpecifique['label'], 'val' => number_format($taxeSpecifique['montant'], 0, ',', ' ') . ' FCFA'],
            ['label' => 'Salaire net à payer', 'val' => number_format($this->salaire_net, 0, ',', ' ') . ' FCFA'],
            ['label' => 'CNSS Patronale', 'val' => number_format($cnssPatronale, 0, ',', ' ') . ' FCFA'],
            ['label' => 'VPS', 'val' => number_format($vps, 0, ',', ' ') . ' FCFA'],
        ];
    }

    public function downloadPdf()
{
    if ($this->shareOption === 'email') {
        // envoyer par mail à $this->email
    } elseif ($this->shareOption === 'whatsapp') {
        // ouvrir WhatsApp dans le navigateur (géré côté front si besoin)
    }

    // Puis déclenche le téléchargement
    $this->dispatchBrowserEvent('download-pdf', [
        'pdfData' => base64_encode($this->generatePdf()->output()),
        'filename' => 'fiche_paie.pdf',
    ]);

    $this->showShareModal = false;
}



    public function render()
    {
        return view('livewire.front-end.salary-calculator-page.inverse-calculator-salary-page');
    }
}
