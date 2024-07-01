<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
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
        $data = $request->validated();

        $user = $this->authService->register($data);

        return $this->success(new UserResource($user), "User Created Successfully.", 201);
    }

    public function login(LoginUserRequest $request)
    {
        $data = $request->validated();
        $deviceName = $request->header('User-Agent');

        $result = $this->authService->login($data, $deviceName);

        return $this->success($result, 'User logged in successfully.');
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        return $this->success(new UserResource($user));
    }

    public function destroy(Request $request)
    {
        $id = $request->user()->id;
        $this->authService->destroy($id);
        $request->user()->tokens()->delete();

        return $this->success(null, 'User deleted successfully');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->success(null, "You're logged out successfully.");
    }
}
