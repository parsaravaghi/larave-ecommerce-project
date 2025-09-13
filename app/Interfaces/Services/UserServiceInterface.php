<?php

namespace App\Interfaces\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function createUser(array $userData) : User ;
    public function getUser() : ?User;
    public function getUserId(): ?int;
    public function is_authenticated() : bool;
    public function isUserSeller():bool;
    public function isUserAdmin():bool;
}
