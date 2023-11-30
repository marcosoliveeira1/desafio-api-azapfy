<?php

namespace App\Http\Controllers\User;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Services\User\SignInService\SignInInput;
use App\Services\User\SignInService\SignInService;
use App\Services\User\SignUpService\SignUpInput;
use App\Services\User\SignUpService\SignUpService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly SignInService $signInService,
        private readonly SignUpService $signUpService,
    ) {
    }

    public function signIn(SignInRequest $request): JsonResponse
    {
        $input = new SignInInput($request->only(['email', 'password']));
        $output = $this->signInService->execute($input);
        if ($output === null || $output->token === null) {
            abort(HttpStatus::UNPROCESSABLE_ENTITY, 'The provided credentials are incorrect.');
        }

        return response()->json($output);
    }

    public function signUp(SignUpRequest $request): JsonResponse
    {
        $input = new SignUpInput($request->only(['name', 'email', 'password']));

        $user = $this->signUpService->execute($input);

        return response()->json($user, HttpStatus::CREATED);
    }
}
