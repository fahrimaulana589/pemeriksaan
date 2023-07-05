<?php

namespace App\Providers;

use App\services\DokterService;
use App\services\JadwalService;
use App\services\ObatService;
use App\services\PasienService;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PasienService::class,function (){
            return new PasienService();
        });

        $this->app->singleton(DokterService::class,function (){
            return new DokterService();
        });

        $this->app->singleton(ObatService::class,function (){
            return new ObatService();
        });

        $this->app->singleton(JadwalService::class,function (){
            return new JadwalService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
