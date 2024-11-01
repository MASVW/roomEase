<?php

namespace App\Providers;

use App\Traits\ValidationRules;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use ValidationRules;
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
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        Validator::extend('time_range', function ($attribute, $value, $parameters, $validator) {
            $time = strtotime($value);
            $hour = date('H', $time);
            if (($hour < 9) || ($hour >= 21)) {
                return false;
            }
            return true;
        }, 'The :attribute is out of the allowed time range.');
    }
}
