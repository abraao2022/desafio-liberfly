<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_get_all_products()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => 'Bearer ' . $token];

        $response = $this->withHeaders($headers)->getJson('/api/products');
        $response->assertStatus(200);
    }

    public function test_can_get_product_by_id()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => 'Bearer ' . $token];

        $response = $this->withHeaders($headers)->getJson('/api/products/1');
        $response->assertStatus(200);
    }

    public function test_can_create_product()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => 'Bearer ' . $token];

        $productType = \App\Models\ProductType::create([
            'name' => 'Electronics'
        ]);

        $data = [
            'name' => 'New Product',
            'price' => 99.99,
            'product_type_id' => $productType->id
        ];

        $response = $this->withHeaders($headers)->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJson($data);

        $this->assertDatabaseHas('products', $data);
    }

    public function test_can_update_product()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => 'Bearer ' . $token];

        $productType = \App\Models\ProductType::create([
            'name' => 'Electronics',
            'description' => 'Electronic Products'
        ]);

        $product = Product::create([
            'name' => 'Old Product',
            'description' => 'Old Product Description',
            'price' => 50.00,
            'product_type_id' => $productType->id,
        ]);

        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'Updated Product Description',
            'price' => 75.00,
            'product_type_id' => $productType->id,
        ];

        $response = $this->withHeaders($headers)->putJson("/api/products/{$product->id}", $updatedData);

        $response->dump();
        $response->assertStatus(200);
    }
}
