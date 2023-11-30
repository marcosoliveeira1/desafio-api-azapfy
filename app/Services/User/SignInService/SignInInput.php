<?php

namespace App\Services\User\SignInService;

class SignInInput
{
    public readonly string $email;
    public readonly string $password;

    public function __construct(
        array $input
    ) {
        $this->email = $input['email'];
        $this->password = $input['password'];
    }
}
