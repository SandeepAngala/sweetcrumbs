<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\CustomCakeOrder;
use App\Models\CustomCakeOption;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\PageContent;
use App\Models\Product;
use App\Models\Review;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $page = PageContent::findBySlug('about');
        $team = TeamMember::active()->get();

        return view('about', compact('page', 'team'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:2000',
        ]);

        Contact::create($request->all());

        return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }

    public function faq()
    {
        $faqs = Faq::active()->get()->groupBy('category');

        return view('faq', compact('faqs'));
    }

    public function gallery()
    {
        $items = GalleryItem::active()->get();
        $categories = $items->pluck('category')->unique()->values();

        return view('gallery', compact('items', 'categories'));
    }

    public function testimonials()
    {
        $reviews = Review::approved()
            ->with(['user', 'product'])
            ->latest()
            ->paginate(12);

        $products = Product::active()->orderBy('name')->get(['id', 'name']);

        return view('testimonials', compact('reviews', 'products'));
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return back()->with('success', 'Thank you! Your review is pending moderation.');
    }

    public function customCake()
    {
        $options = CustomCakeOption::active()->get()->groupBy('group');

        return view('custom-cake', compact('options'));
    }

    public function customCakeStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:20',
            'cake_type' => 'required|string|max:100',
            'size' => 'required|string|max:50',
            'shape' => 'nullable|string|max:50',
            'flavor' => 'required|string|max:100',
            'filling' => 'nullable|string|max:100',
            'decoration' => 'nullable|string|max:2000',
            'message_on_cake' => 'nullable|string|max:100',
            'delivery_date' => 'required|date|after_or_equal:today',
            'special_instructions' => 'nullable|string|max:1000',
            'budget' => 'nullable|numeric|min:0',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $data = $request->all();
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        CustomCakeOrder::create($data);

        return back()->with('success', 'Your tea combo request has been submitted! Our team will confirm details and contact you shortly.');
    }
}
