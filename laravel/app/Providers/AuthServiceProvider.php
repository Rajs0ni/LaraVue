<?php

namespace App\Providers;

use Illuminate\Http\Request;
use App\Sk\Session\SessionApi;
use Illuminate\Support\Facades\Auth;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Auth::viaRequest('sk-token', function (Request $request) {
            return SessionApi::authorizeByToken($request->bearerToken())->user;
        });
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return $modelClass::$policyClass ?? null;
        });
    }
}
