<?php

namespace App\Services\User\SignUpService;

use App\Domain\User;
use App\Repository\Interfaces\UserRepositoryInterface;

class SignUpService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,

    ) {
    }

    public function execute(SignUpInput $input): SignUpOutput
    {
        $user = User::create($input->email, $input->name, password_hash($input->password, PASSWORD_DEFAULT));

        $this->userRepository->create($user);

        return new SignUpOutput(
            $user->name,
            $user->email
        );
    }
}
