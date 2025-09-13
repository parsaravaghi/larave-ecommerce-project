<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Services\AuthServiceInterface;
class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authService ,
    ){}

    public function register(RegisterRequest $request)
    {
        // Store a user with validated data
        $user = $this->authService->register($request->validated());

        // Success message
        return response()->json([
            "message" => "You registered successfully" ,
            "user" => $user
        ] , 202);
    }

    public function login(LoginRequest $request)
    {
        // Fetch jwt with having username and password
        $token = $this->authService->getUserToken($request->validated());

        // Send success message if the token wouldn't be null
        return response()->json([
            "message" => $token ? "you logged in successfully" : "login failed" ,
            "token" => $token
        ] ,
        $token ? 201 : 406
        );
    }
}
