<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', function(User $user){
            return $user->role == 2;
        });

        Gate::define('isModarator', function(User $user){
            return $user->role == 1;
        });

        // share the logged-in user's info with all views
        View::composer('*', function ($view) {
            $view->with('authUser', Auth::user());
        });
    }
}
