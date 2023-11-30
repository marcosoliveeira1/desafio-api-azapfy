<?php

namespace App\Services\User\SignUpService;

class SignUpInput
{
    public readonly string $email;
    public readonly string $name;
    public readonly string $password;

    public function __construct(
        array $input
    ) {
        $this->email = $input['email'];
        $this->name = $input['name'];
        $this->password = $input['password'];
    }
}
