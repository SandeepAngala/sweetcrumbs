<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ImageUploadService
{
    public function uploadProductImages(Product $product, array $files, bool $optimize = true): array
    {
        $paths = [];

        foreach ($files as $index => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $path = $this->storeImage($file, 'products/'.$product->id, $optimize);
            $paths[] = $path;

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'is_primary' => $index === 0 && ! $product->productImages()->where('is_primary', true)->exists(),
                'sort_order' => $index,
            ]);
        }

        $existingImages = is_array($product->images) ? $product->images : [];
        $product->update(['images' => array_merge($existingImages, $paths)]);

        return $paths;
    }

    public function storeImage(UploadedFile $file, string $directory, bool $optimize = true): string
    {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $extension = strtolower($file->getClientOriginalExtension() ?: '');

        if (! in_array($extension, $allowed, true)) {
            throw ValidationException::withMessages([
                'image' => 'Only JPG, PNG, WebP, and GIF images are allowed.',
            ]);
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'image' => 'Image must be smaller than 5MB.',
            ]);
        }

        $filename = Str::uuid().'.'.$extension;
        $path = $file->storeAs($directory, $filename, 'public');

        if ($optimize && function_exists('imagecreatefromstring')) {
            $path = $this->convertToWebp($path);
        }

        return $path;
    }

    public function deleteImage(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function convertToWebp(string $path): string
    {
        $fullPath = Storage::disk('public')->path($path);
        $webpPath = preg_replace('/\.\w+$/', '.webp', $path);

        try {
            $image = @imagecreatefromstring(file_get_contents($fullPath));
            if ($image) {
                $webpFull = Storage::disk('public')->path($webpPath);
                imagewebp($image, $webpFull, 80);
                imagedestroy($image);
                Storage::disk('public')->delete($path);

                return $webpPath;
            }
        } catch (\Throwable) {
            // Keep original if conversion fails
        }

        return $path;
    }
}
