<?php

namespace App\Repository\Interfaces;

use App\Domain\User;

interface UserRepositoryInterface
{
    public function create(User $data): User;

    public function findByEmail(string $email): ?User;
}
