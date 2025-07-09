<?php

use App\Livewire\FrontEnd\WelcomePage\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('welcome');

// routes/web.php
// Route::get('/salaire', function () {
//     return view('salaire');
// });

