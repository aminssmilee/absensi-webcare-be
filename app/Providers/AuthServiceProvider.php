<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        // Hanya user role = admin yang bisa akses Filament
        Gate::define('filament', function (?User $user) {
            return $user && $user->role === 'admin';
        });
    }
}
