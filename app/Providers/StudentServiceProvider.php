<?php

namespace App\Providers;

use App\StudentService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use League\OAuth2\Server\Grant\PasswordGrant;

class StudentServiceProvider extends PassportServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function makePasswordGrant()
    {
        $grant = new PasswordGrant(
            $this->app->make(StudentService::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }
}
