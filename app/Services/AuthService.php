<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;
use App\Traits\ApiResponses;

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
}
