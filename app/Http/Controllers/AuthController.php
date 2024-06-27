<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponses;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->all();

        $user = $this->authService->register($data);

        $deviceName = $request->header('User-Agent');

        return $this->success(
            [
                'user' => $user,
                'token' => $user->createToken($deviceName)->plainTextToken,
            ],
            "User Created Successfully.",
            201
        );
    }
}
