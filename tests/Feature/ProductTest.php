<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/product/45');

        $response->assertStatus(200);
    }
}
