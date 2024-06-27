<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
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

        return $this->success($user, "User Created Successfully.", 201);
    }

    public function login(LoginUserRequest $request)
    {
        $data = $request->all();

        $user = $this->authService->login($data);

        $deviceName = $request->header('User-Agent');

        $message = 'User logged in  successfully.';

        return $this->success([
            'user' => $user,
            'token' => $user->createToken($deviceName)->plainTextToken,
        ], $message);
    }

    public function profile(Request $request)
    {
        return $this->success($request->user());
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->user()->id;
            $this->authService->destroy($id);
            $request->user()->tokens()->delete();
            return $this->success(null, 'User deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return $this->success(null, "You're logged out successfully.", 200);
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }
}
