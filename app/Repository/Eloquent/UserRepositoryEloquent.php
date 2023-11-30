<?php

namespace App\Repository\Eloquent;

use App\Domain\User;
use App\Models\User as UserModel;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepositoryEloquent implements UserRepositoryInterface
{
    public function create(User $user): User
    {
        $userCreated = UserModel::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($user->password),
        ]);

        $token = $userCreated->createToken('api_token')->plainTextToken;

        return User::restore($user->id, $user->email, $user->name, $token);
    }

    public function findByEmail(string $email): ?User
    {

        $user = UserModel::where('email', $email)->first();

        if ($user === null) {
            return null;
        }

        return User::restore($user->id, $user->email, $user->name);
    }
}
