<?php

namespace App\Livewire\FrontEnd\SalaryCalculatorPage;

use App\Services\Payslip\GeneratePdf;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Layout('front_end.layouts.app')]
class CalculatorPage extends Component
{
    #[Title('FLUIDPAY - Calculator')]
    public function render()
    {
        return view('livewire.front-end.salary-calculator-page.calculator-page');
    }
}
