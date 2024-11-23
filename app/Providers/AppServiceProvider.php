<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
        Validator::extend('filter', function ($attribute, $value) {
            if (strtolower($value) == 'word') {
                return false;
            }
            return true;
        },'The value is phoripted!');
    }
}
