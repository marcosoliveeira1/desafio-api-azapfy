<?php

namespace App\Services\User\SignUpService;

class SignUpOutput
{
    public function __construct(
        public readonly string $name,
        public readonly string $email
    ) {

    }
}
