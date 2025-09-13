<?php

namespace App\Services;

use App\Interfaces\Services\AuthServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private UserServiceInterface $userService
    ){}
    
    public function register(array $userData) : User
    {
        return $this->userService->createUser(
            array_merge($userData , ["is_verified" => $userData['role'] < 1])
        );
    }

    public function getUserToken(array $userData) :?string
    {
        // Get user credentials and return the token if the credentials would be valid
        if($token = JWTAuth::attempt($userData))
            return $token ;

        return null;
    }
}
