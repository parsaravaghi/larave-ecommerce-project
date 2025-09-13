<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->postJson('auth/login' , [
            "username" => "parsa" ,
            "password" => "98769687kkjjkki"
        ]);

        $response->assertStatus(201);
    }
}
