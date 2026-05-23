<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:150',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! You have successfully subscribed to the Sweet Crumbs Newsletter.'
        ]);
    }
}
