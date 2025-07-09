<?php

namespace App\Livewire\FrontEnd\SalaryCalculatorPage;

use Livewire\Component;

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
    \App\Models\Visits::firstOrCreate(
        ['ip' => $ip, 'type_calcul' => 'brut'], // brut juste comme défaut pour l’enregistrement initial
        ['calcul_count' => 0, 'pdf_count' => 0]
    );

    // Statistiques
    $this->totalVisiteurs = \App\Models\Visits::distinct('ip')->count('ip');
    $this->totalBrut = \App\Models\Visits::where('type_calcul', 'brut')->sum('calcul_count');
    $this->totalNet = \App\Models\Visits::where('type_calcul', 'net')->sum('calcul_count');
    $this->totalPdf = \App\Models\Visits::sum('pdf_count');
}

    public function render()
    {
        return view('livewire.front-end.salary-calculator-page.visitor');
    }
}
