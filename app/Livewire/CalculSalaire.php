<?php
namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class CalculSalaire extends Component
{
    public $salaire_brut, $mois_brut;
    public $cnss_ouvriere_brut = 3.6;
    public $cnss_patronale_brut = 16.4;
    public $vps_brut = 4;

    public $resultats = [];

    public function mount()
    {
        Carbon::setLocale('fr');
        $this->mois_brut = ucfirst(Carbon::now()->isoFormat('MMMM'));
    }

    // Calcul du taux d'impôt progressif (équivalent getTaxRate JS)
    public function getTaxRate(int $income): float
    {
        $income = (int)$income;
        if ($income <= 60000) return 0;
        if ($income <= 150000) return ($income - 60000) * 0.1;
        if ($income <= 250000) return ($income - 150000) * 0.15 + 9000;
        if ($income <= 500000) return ($income - 250000) * 0.19 + 24000;
        return ($income - 500000) * 0.3 + 71500;
    }

    // Taxe spécifique par mois
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

    // Calcul du salaire net à partir du brut
    public function calculateNetFromBrut(float $gross, string $month, float $cnssOuvriereRate): float
    {
        $taxeSpecifique = $this->getSpecificTax($month)['montant'];
        $impots = $this->getTaxRate((int)$gross);
        $cnssOuvriere = $gross * $cnssOuvriereRate;
        return $gross - $cnssOuvriere - $impots - $taxeSpecifique;
    }

    // Calcul du salaire brut estimé à partir du net voulu (méthode inverse)
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

    // Méthode pour lancer le calcul complet
    public function calculer()
    {
        if (!$this->salaire_brut || $this->salaire_brut <= 0) {
            $this->addError('salaire_brut', 'Salaire brut invalide.');
            return;
        }


        $cnssOuvriereRate = $this->cnss_ouvriere_brut / 100;
        $cnssPatronaleRate = $this->cnss_patronale_brut / 100;
        $vpsRate = $this->vps_brut / 100;

        $cnssOuvriere = $this->salaire_brut * $cnssOuvriereRate;
        $cnssPatronale = $this->salaire_brut * $cnssPatronaleRate;
        $vps = $this->salaire_brut * $vpsRate;
        $impots = $this->getTaxRate((int)$this->salaire_brut);
        $taxeSpecifique = $this->getSpecificTax($this->mois_brut);

        $net = $this->salaire_brut - $cnssOuvriere - $impots - $taxeSpecifique['montant'];

        $this->resultats = [
            ['label' => 'Salaire Brut', 'val' => number_format($this->salaire_brut, 0, ',', ' ') . ' FCFA'],
            ['label' => 'CNSS Ouvrière', 'val' => number_format($cnssOuvriere, 0, ',', ' ') . ' FCFA'],
            ['label' => 'Impôt sur salaire', 'val' => number_format($impots, 0, ',', ' ') . ' FCFA'],
            ['label' => $taxeSpecifique['label'], 'val' => number_format($taxeSpecifique['montant'], 0, ',', ' ') . ' FCFA'],
            ['label' => 'Salaire Net à payer', 'val' => number_format($net, 0, ',', ' ') . ' FCFA'],
            ['label' => 'CNSS Patronale', 'val' => number_format($cnssPatronale, 0, ',', ' ') . ' FCFA'],
            ['label' => 'VPS', 'val' => number_format($vps, 0, ',', ' ') . ' FCFA'],
        ];
    }

    public function render()
    {
        return view('livewire.calcul-salaire');
    }
}
