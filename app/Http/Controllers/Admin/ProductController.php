<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'category_id' => 'required|exists:categories,_id',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,draft',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'external_image_url' => 'nullable|url',
        ]);

        $data = $request->except(['images', 'external_image_url']);
        $data['slug'] = Str::slug($request->name);

        // Scaffolding local/demo image links if none uploaded
        $imageUrls = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Since this is locally stored
                $path = $image->store('products', 'public');
                $imageUrls[] = '/storage/' . $path;
            }
        }

        if ($request->filled('external_image_url')) {
            $imageUrls[] = $request->input('external_image_url');
        }

        if (empty($imageUrls)) {
            // Mock placeholder images
            $imageUrls[] = 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=600&auto=format&fit=crop';
        }

        $data['images'] = $imageUrls;
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'category_id' => 'required|exists:categories,_id',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,draft',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'external_image_url' => 'nullable|url',
        ]);

        $data = $request->except(['images', 'external_image_url']);
        $data['slug'] = Str::slug($request->name);

        $imageUrls = $product->images ?? [];
        if ($request->hasFile('images')) {
            // Reset and load new images
            $imageUrls = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imageUrls[] = '/storage/' . $path;
            }
        }

        // Handle external URL
        if ($request->filled('external_image_url')) {
            $imageUrls = array_filter($imageUrls, function ($img) {
                return !Str::startsWith($img, ['http://', 'https://']) || Str::contains($img, 'unsplash.com');
            });
            $imageUrls[] = $request->input('external_image_url');
            $imageUrls = array_values($imageUrls);
        } else {
            $imageUrls = array_filter($imageUrls, function ($img) {
                return !Str::startsWith($img, ['http://', 'https://']) || Str::contains($img, 'unsplash.com');
            });
            $imageUrls = array_values($imageUrls);
        }

        $data['images'] = $imageUrls;
        
        // Toggles
        $data['is_featured'] = $request->has('is_featured');
        $data['is_trending'] = $request->has('is_trending');
        $data['is_bestseller'] = $request->has('is_bestseller');

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function analyzeImage(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|max:4096', // Max 4MB
            'image_url' => 'nullable|url',
        ]);

        $base64Image = null;
        $mimeType = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $mimeType = $image->getMimeType();
            $base64Image = base64_encode(file_get_contents($image->getRealPath()));
        } elseif ($request->filled('image_url')) {
            $url = $request->input('image_url');
            try {
                $imageResponse = Http::timeout(15)->get($url);
                if (!$imageResponse->successful()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Could not fetch image from the provided URL.'
                    ], 400);
                }
                $imageData = $imageResponse->body();
                $base64Image = base64_encode($imageData);
                $mimeType = $imageResponse->header('Content-Type') ?: 'image/jpeg';
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve image from URL: ' . $e->getMessage()
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Please upload a dessert photo or provide an external image URL.'
            ], 400);
        }

        $apiKey = config('services.groq.api_key') ?? env('GROQ_API_KEY');

        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Groq API Key is not configured. Please add GROQ_API_KEY to your .env file.'
            ], 500);
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.2-11b-vision-preview',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => 'Analyze the uploaded image of a food/beverage/dessert item and return a JSON object with the following fields:
- "name": a catchy, high-end name for the menu item (e.g., "Classic Malai Bun Maska", "Premium Filter Coffee", "Spiced Masala Chai", "Gourmet Chocolate Mousse Cup").
- "price": recommended price in INR (integer, e.g., 120).
- "short_description": a short, appetizing one-sentence description (max 150 characters).
- "description": a detailed description describing the sensory experience, key ingredients, preparation, and why customers love it. Include a brief ingredients note.
- "suggested_category": one of the following exact category names that best fits the item:
  * "Signature Chai & Hot Items"
  * "Tea-Time Snacks & Sweets"
  * "Cold Drinks"
  * "Mocktails & Coolers"
  * "Premium Coffee & Filter Tea"
  * "Ice Creams & Desserts"

Return ONLY the raw JSON object. Do not wrap it in markdown code blocks or add any text.'
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => 'data:' . $mimeType . ';base64,' . $base64Image
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'temperature' => 0.2,
                    'response_format' => ['type' => 'json_object']
                ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Groq API Error: ' . ($response->json('error.message') ?? 'Unknown error')
                ], 500);
            }

            $resultText = $response->json('choices.0.message.content');
            $data = json_decode($resultText, true);

            if (!$data || json_last_error() !== JSON_ERROR_NONE) {
                // fallback if it returned markdown json block
                $cleaned = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', trim($resultText));
                $data = json_decode($cleaned, true);
            }

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to parse JSON response from Groq API.'
                ], 500);
            }

            // Now let\'s try to match category
            $suggestedCategoryName = $data['suggested_category'] ?? '';
            $matchedCategory = null;
            if ($suggestedCategoryName) {
                $matchedCategory = \App\Models\Category::where('name', 'like', '%' . $suggestedCategoryName . '%')->first();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $data['name'] ?? '',
                    'price' => $data['price'] ?? '',
                    'short_description' => $data['short_description'] ?? '',
                    'description' => $data['description'] ?? '',
                    'category_id' => $matchedCategory ? (string) $matchedCategory->id : '',
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
