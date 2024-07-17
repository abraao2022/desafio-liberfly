<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup method to migrate database before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Optional: seed your database
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_all_products()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => 'Bearer ' . $token];

        $response = $this->withHeaders($headers)->getJson('/api/products');
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_product_by_id()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => 'Bearer ' . $token];

        $response = $this->withHeaders($headers)->getJson('/api/products/11');
        $response->assertStatus(200);
    }
}
