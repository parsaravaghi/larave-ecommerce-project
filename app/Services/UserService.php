<?php

namespace App\Services;

use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function __construct(
        private User $user ,
    ) {}

    // Fetch user data from json web token
    public function getUser(): ?User
    {
        return auth('api')->user();
    }

    // Get user id from getUser() function
    public function getUserId(): ?int
    {
        return $this->getUser() ? $this->getUser()['id'] : null;
    }

    // Store user Function with using userRepository
    public function createUser(array $userData): User
    {
        return $this->user->create($userData);
    }

    public function is_authenticated(): bool
    {
        return auth('api')->check();
    }

    // Check role from authenticated user
    public function isUserAdmin(): bool
    {
        return $this->getUser() ? $this->getUser()['role'] >= 2 : false;
    }

    public function isUserSeller(): bool
    {
        return $this->getUser()['role'] == 1 ;
    }
}
