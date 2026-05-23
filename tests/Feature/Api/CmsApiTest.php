<?php

namespace Tests\Feature\Api;

use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_cms_settings_endpoint_returns_json(): void
    {
        $response = $this->getJson('/api/v1/cms/settings');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_cms_faqs_endpoint_returns_active_faqs(): void
    {
        Faq::create([
            'category' => 'general',
            'question' => 'Test question?',
            'answer' => 'Test answer.',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/v1/cms/faqs');

        $response->assertOk()
            ->assertJsonPath('data.0.question', 'Test question?');
    }

    public function test_cms_banners_endpoint_returns_json(): void
    {
        $response = $this->getJson('/api/v1/cms/banners');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }
}
