<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        //Register new collection method to filter improvements collection by improvement status
        Collection::macro('filterByStatus', function ($status) {
            return Collection::filter(function ($eloquent) use ($status){//By using Use we are making $status available in filters function scope
                return $eloquent->status == $status;
            });
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
