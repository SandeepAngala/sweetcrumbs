<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'price' => (float) $this->price,
            'discount_price' => $this->discount_price ? (float) $this->discount_price : null,
            'discount_percentage' => $this->discount_percentage,
            'images' => $this->images,
            'primary_image' => $this->primary_image,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'ingredients' => $this->ingredients,
            'stock' => $this->stock,
            'sku' => $this->sku,
            'is_featured' => $this->is_featured,
            'is_trending' => $this->is_trending,
            'is_bestseller' => $this->is_bestseller,
            'status' => $this->status,
            'average_rating' => $this->average_rating,
            'reviews_count' => $this->when(isset($this->reviews_count), $this->reviews_count),
        ];
    }
}
