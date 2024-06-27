<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;
use App\Traits\ApiResponses;
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
            return $this->authRepository->create($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function login(array $data)
    {
        $user = $this->authRepository->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'message' => 'The provided credentials are incorrect.',
            ]);
        }

        return $user;
    }

    public function destroy(string $id)
    {
        $this->authRepository->destroy($id);
    }
}
