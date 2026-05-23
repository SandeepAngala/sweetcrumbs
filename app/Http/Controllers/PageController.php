<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\CustomCakeOrder;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('about');
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
        return view('faq');
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function testimonials()
    {
        return view('testimonials');
    }

    public function customCake()
    {
        return view('custom-cake');
    }

    public function customCakeStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:20',
            'cake_type' => 'required|string',
            'size' => 'required|string',
            'flavor' => 'required|string',
            'filling' => 'nullable|string',
            'decoration' => 'nullable|string',
            'message_on_cake' => 'nullable|string|max:100',
            'delivery_date' => 'required|date|after_or_equal:today',
            'special_instructions' => 'nullable|string|max:1000',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $data = $request->all();
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        CustomCakeOrder::create($data);

        return back()->with('success', 'Your custom cake request has been submitted! Our chef will review it and contact you shortly.');
    }
}
