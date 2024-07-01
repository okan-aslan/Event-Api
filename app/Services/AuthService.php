<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\AuthRepository;
use App\Traits\ApiResponses;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    use ApiResponses;

    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data): User
    {
        try {
            return $this->authRepository->store($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function login(array $data, string $deviceName)
    {
        $user = $this->authRepository->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'message' => 'The provided credentials are incorrect.',
            ]);
        }

        $existingToken = $user->tokens()->where('name', $deviceName)->first();
        if ($existingToken) {
            $token = $existingToken->plainTextToken;
        } else {
            $token = $user->createToken($deviceName)->plainTextToken;
        }

        return [
            'user' => new UserResource($user),
            'token' => $token,
        ];
    }

    public function destroy(string $id)
    {
        try {
            $this->authRepository->destroy($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function logout(User $user)
    {
        try {
            $user->tokens()->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
