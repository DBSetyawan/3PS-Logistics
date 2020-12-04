<?php

namespace warehouse\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'warehouse\Model' => 'warehouse\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        // Gate::before(function ($user, $ability) {
        //     if ($user->hasRole('administrator')) {
        //         return true;
        //     }
        // });

        // Passport::personalAccessClientId('client-id');

        // Passport::tokensExpireIn(now()->addDays(15));

        // Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::routes();

    }
}
