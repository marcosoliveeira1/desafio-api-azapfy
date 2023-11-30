<?php

namespace App\Services\User\SignInService;

class SignInOutput
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $token
    ) {

    }
}
