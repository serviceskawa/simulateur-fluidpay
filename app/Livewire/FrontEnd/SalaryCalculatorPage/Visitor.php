<?php

namespace App\Livewire\FrontEnd\SalaryCalculatorPage;

use Livewire\Component;
use App\Models\Visits;

class Visitor extends Component
{
    public $totalVisiteurs;
    public $totalBrut;
    public $totalNet;
    public $totalPdf;

    public function mount()
    {
        $ip = request()->ip();

        // Enregistre le visiteur s’il n’existe pas encore
        Visits::firstOrCreate(
            ['ip' => $ip, 'type_calcul' => 'brut'], // brut juste comme défaut pour l’enregistrement initial
            ['calcul_count' => 0, 'pdf_count' => 0]
        );

        // Statistiques
        $this->totalVisiteurs = Visits::distinct('ip')->count('ip');
        $this->totalBrut = Visits::where('type_calcul', 'brut')->sum('calcul_count');
        $this->totalNet = Visits::where('type_calcul', 'net')->sum('calcul_count');
        $this->totalPdf = Visits::sum('pdf_count');
    }

    public function render()
    {
        return view('livewire.front-end.salary-calculator-page.visitor');
    }
}
