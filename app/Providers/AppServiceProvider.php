<?php

namespace App\Providers;

use App\Models\Config;
use App\Services\Cart;
use Illuminate\Support\Facades\View;
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
        $this->app->singleton(\App\Services\Cart::class);
        View::composer('*', fn($v) => $v->with('cartCount', resolve(Cart::class)->totalItems()));

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $json   = file_get_contents(public_path('icons.json'));
        $icons  = json_decode($json, true);

        // share with every view (or pass from controller)
        View::share('icons', $icons);
        View::share('config',Config::first()->get());
    }
}
