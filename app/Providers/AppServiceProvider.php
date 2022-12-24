<?php

namespace App\Providers;

use App\Http\ViewComposers\CommunitiesYouMightLike;
use App\Http\ViewComposers\Communities;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        view()->composer('layouts.communities', CommunitiesYouMightLike::class);
        view()->composer('layouts.leftBar', Communities::class);
    }
}
