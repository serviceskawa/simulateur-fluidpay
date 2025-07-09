<?php

namespace App\Providers;

use App\Services\Payslip\GeneratePdf;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {


    $this->app->singleton(GeneratePdf::class, function ($app) {
        return new GeneratePdf();
    });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
