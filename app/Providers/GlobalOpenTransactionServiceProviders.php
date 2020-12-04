<?php

namespace warehouse\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class GlobalOpenTransactionServiceProviders extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GlobalTransactionComposer::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            '*',
            'warehouse\Http\ViewComposers\GlobalTransactionComposer'
        );
    }
}
