<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    /** @dataProvider publicRoutesProvider */
    public function test_public_pages_load(string $route): void
    {
        $this->get($route)->assertOk();
    }

    public static function publicRoutesProvider(): array
    {
        return [
            'home' => ['/'],
            'about' => ['/about'],
            'contact' => ['/contact'],
            'faq' => ['/faq'],
            'gallery' => ['/gallery'],
            'testimonials' => ['/testimonials'],
            'custom-cake' => ['/custom-cake'],
            'products' => ['/products'],
            'categories' => ['/categories'],
            'blog' => ['/blog'],
        ];
    }

    public function test_health_endpoint(): void
    {
        $this->get('/up')->assertOk();
    }

    public function test_product_search_requires_minimum_query(): void
    {
        $this->getJson('/search?query=a')->assertOk()->assertExactJson([]);
    }
}
