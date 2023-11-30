<?php

namespace App\Domain;

class User
{
    private function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $name,
        public readonly string $password = ''
    ) {
    }

    public static function create(
        string $email,
        string $name,
        string $password,
        string $id = null,
    ): self {
        if (empty($id)) {
            $id = uniqid();
        }

        return new self($id, $email, $name, $password);
    }

    public static function restore(
        string $id,
        string $email,
        string $name
    ): self {
        return new self($id, $email, $name);
    }
}
