<?php

use App\Livewire\FrontEnd\SalaryCalculatorPage\CalculatorPage;
use App\Livewire\FrontEnd\WelcomePage\Welcome;
use Illuminate\Support\Facades\Route;

// Route::get('/', Welcome::class)->name('welcome');

Route::get('/', CalculatorPage::class)->name('salary.simulator');

// routes/web.php
// Route::get('/salaire', function () {
//     return view('salaire');
// });



// Route::get('/calculator-page', CalculatorPage::class)->name('calculator.page');


