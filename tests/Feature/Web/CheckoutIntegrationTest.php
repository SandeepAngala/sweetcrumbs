<?php

namespace Tests\Feature\Web;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\BakeryNotification;
use App\Models\DeliveryTracking;
use App\Models\InventoryLog;
use Tests\TestCase;

class CheckoutIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->cleanup();
    }

    protected function tearDown(): void
    {
        $this->cleanup();
        parent::tearDown();
    }

    protected function cleanup(): void
    {
        User::where('email', 'customer@example.com')->delete();
        Category::where('slug', 'cakes')->delete();
        Product::where('slug', 'chocolate-cake')->delete();
        Cart::truncate();
        Address::truncate();
        Order::truncate();
        OrderItem::truncate();
        Payment::truncate();
        BakeryNotification::truncate();
        DeliveryTracking::truncate();
        InventoryLog::truncate();
    }

    public function test_authenticated_user_can_place_order(): void
    {
        $user = User::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $category = Category::create([
            'name' => 'Cakes',
            'slug' => 'cakes',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Chocolate Cake',
            'slug' => 'chocolate-cake',
            'description' => 'Delicious chocolate cake',
            'price' => 200,
            'images' => ['test.jpg'],
            'category_id' => $category->id,
            'stock' => 10,
            'sku' => 'SCB-CHO01',
            'status' => 'active',
        ]);

        // Add to cart
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'saved_for_later' => false,
        ]);

        // Create address
        $address = Address::create([
            'user_id' => $user->id,
            'label' => 'Home',
            'address_line_1' => '123 Test Street',
            'city' => 'Test City',
            'state' => 'Test State',
            'zip_code' => '123456',
            'country' => 'India',
        ]);

        $response = $this->post('/checkout', [
            'address_id' => $address->id,
            'payment_method' => 'cod',
            'delivery_date' => now()->addDay()->toDateString(),
            'delivery_time_slot' => 'Morning 9-12',
            'notes' => 'Leave at the door',
        ]);

        // If it redirected back with errors, print session errors
        if (session('errors')) {
            $errors = session('errors')->getBag('default')->getMessages();
            fwrite(STDERR, "Validation Errors: " . print_r($errors, true));
        }

        if (session('error')) {
            fwrite(STDERR, "Exception Message: " . session('error') . "\n");
        }

        $response->assertRedirect();
        
        // Assert order exists in DB
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'cod',
        ]);
    }
}
