<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register policies
        $this->registerPolicies();

        // Define Gates for event ownership
        Gate::define('manage-event', function ($user, $event) {
            return $user->id === $event->user_id;
        });

        // Define Gates for collection ownership
        Gate::define('manage-collection', function ($user, $collection) {
            return $user->id === $collection->user_id;
        });

        // Define Gates for transaction participation
        Gate::define('manage-transaction', function ($user, $transaction) {
            return $user->id === $transaction->seller_id || $user->id === $transaction->buyer_id;
        });
    }
}