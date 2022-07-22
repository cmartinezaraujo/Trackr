<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Registrar as Charts;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            \App\Charts\OrganizationWeeklyCases::class,
            \App\Charts\OrganizationMonthlyCases::class,
            \App\Charts\OrganizationYearlyCases::class,
            \App\Charts\UserWeeklyCases::class,
            \App\Charts\OrganizationNetworkWeeklyCases::class,
            \App\Charts\OrganizationNetworkMonthlyCases::class,
            \App\Charts\OrganizationNetworkYearlyCases::class

        ]);
    }
}
