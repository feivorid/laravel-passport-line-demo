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

    protected function makePasswordGrant()
    {
        dd(1231212312);
        $grant = new PasswordGrant(
            $this->app->make(StudentService::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }
}
