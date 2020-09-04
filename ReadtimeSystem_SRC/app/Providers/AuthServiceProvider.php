<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Auth\HyumonySessionGuard;
use App\Auth\HyumonyEloquentUserProvider;
use Auth;

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

        Auth::extend('hyumony_session', function ($app, $name, array $config) {
            $provider = Auth::createUserProvider($config['provider']);
            return new HyumonySessionGuard($name, $provider, $app['session.store']);
        });
 
        Auth::provider('hyumony_eloquent', function ($app, array $config) {
            return new HyumonyEloquentUserProvider($app['hash'], $config['model']);
        });
    }
}
