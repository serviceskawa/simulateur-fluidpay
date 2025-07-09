<?php

namespace App\Livewire\FrontEnd\WelcomePage;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('front_end.layouts.app')]
class Welcome extends Component
{

    #[Title('FLUIDPAY - Welcome Page')]
    public function render()
    {
        return view('livewire.front-end.welcome-page.welcome');
    }
}
