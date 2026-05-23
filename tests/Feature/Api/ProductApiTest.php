<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_returns_paginated_list(): void
    {
        $category = Category::create([
            'name' => 'Desserts',
            'slug' => 'desserts',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Chocolate Cake',
            'slug' => 'chocolate-cake',
            'description' => 'Rich chocolate cake',
            'price' => 450,
            'images' => ['cake.jpg'],
            'category_id' => $category->id,
            'stock' => 10,
            'sku' => 'SCB-TEST001',
            'status' => 'active',
        ]);

        $response = $this->getJson('/api/v1/products');

        $response->assertOk()
            ->assertJsonStructure(['data', 'meta']);
    }
}
