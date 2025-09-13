<?php

namespace App\Interfaces\Services;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $userData) : User;
    public function getUserToken(array $userData) : ?string;
}
