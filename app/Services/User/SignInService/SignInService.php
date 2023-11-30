<?php

namespace App\Services\User\SignInService;

class SignInService
{
    public function execute(SignInInput $input): ?SignInOutput
    {
        if (! auth()->attempt(['email' => $input->email, 'password' => $input->password])) {
            return null;
        }

        $user = auth()->user();

        return new SignInOutput(
            $input->email,
            $input->password,
            $user->createToken('api_token')->plainTextToken
        );
    }
}
