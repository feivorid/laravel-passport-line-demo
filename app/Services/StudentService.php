<?php

namespace App\Services;

use Illuminate\Http\Request;
use Laravel\Passport\Bridge\UserRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class StudentService extends UserRepository
{

    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        $guard = \App::make(Request::class)->get('guard') ?: 'api';

        $provider = config("auth.guards.{$guard}.provider");

        if (is_null($model = config('auth.providers.' . $provider . '.model'))) {
            throw new \RuntimeException('Unable to determine student model from configuration.');
        }

        if (method_exists($model, 'findForPassport')) {
            $user = (new $model)->findForPassport($username);
        } else {
            $user = (new $model)->where('email', $username)->first();
        }

        if (!$user) {
            return;
        } else if (method_exists($user, 'validateForPassportPasswordGrant')) {
            if (!$user->validateForPassportPasswordGrant($password)) {
                return;
            }
        } else if (!$this->hasher->check($password, $user->getAuthPassword())) {
            return;
        }

        return new \Laravel\Passport\Bridge\User($user->getAuthIdentifier());
    }
}
