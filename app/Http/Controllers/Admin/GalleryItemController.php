<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class GalleryItemController extends Controller
{
    public function index()
    {
        $items = GalleryItem::orderBy('sort_order')->paginate(20);

        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request, ImageUploadService $images)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:50',
            'sort_order' => 'nullable|integer',
            'image' => 'required|image|max:4096',
        ]);

        GalleryItem::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'category' => $data['category'],
            'sort_order' => $data['sort_order'] ?? 0,
            'image' => $images->storeImage($request->file('image'), 'gallery'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item added.');
    }

    public function edit(GalleryItem $gallery)
    {
        return view('admin.gallery.edit', ['item' => $gallery]);
    }

    public function update(Request $request, GalleryItem $gallery, ImageUploadService $images)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:50',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|max:4096',
        ]);

        $payload = [
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'category' => $data['category'],
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $payload['image'] = $images->storeImage($request->file('image'), 'gallery');
        }

        $gallery->update($payload);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(GalleryItem $gallery)
    {
        $gallery->delete();

        return back()->with('success', 'Gallery item deleted.');
    }
}
