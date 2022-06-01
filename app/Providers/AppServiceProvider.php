<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Sanctum::authenticateAccessTokensUsing(
        //     static function (PersonalAccessToken $accessToken, bool $is_valid) {
        //         if (!$accessToken->can('read:once')) {
        //             return $is_valid; // We keep the current validation.
        //         }

        //         return $is_valid && $accessToken->last_used_at === null;
        //     }
        // );
    }
}
