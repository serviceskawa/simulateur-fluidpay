<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front_end.layouts.app');
});
