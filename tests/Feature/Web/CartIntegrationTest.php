<?php

namespace Tests\Feature\Web;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_add_to_session_cart(): void
    {
        $product = $this->createProduct();

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertOk()
            ->assertJson(['success' => true, 'cart_count' => 2]);

        $this->assertEquals(2, session('guest_cart')[$product->id]);
    }

    protected function createProduct(): Product
    {
        $category = Category::create([
            'name' => 'Desserts',
            'slug' => 'desserts',
            'is_active' => true,
        ]);

        return Product::create([
            'name' => 'Test Cake',
            'slug' => 'test-cake',
            'description' => 'Test',
            'price' => 100,
            'images' => ['test.jpg'],
            'category_id' => $category->id,
            'stock' => 10,
            'sku' => 'SCB-TEST99',
            'status' => 'active',
        ]);
    }
}
