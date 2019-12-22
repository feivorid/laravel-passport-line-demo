<?php

namespace App\Providers;


use App\Services\StudentService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Passport;
use League\OAuth2\Server\Grant\PasswordGrant;

class TeacherServiceProvider extends ServiceProvider
{
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
