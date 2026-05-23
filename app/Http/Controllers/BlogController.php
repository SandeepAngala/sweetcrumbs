<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()->with('author')->orderBy('published_at', 'desc')->paginate(9);
        return view('blog.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::published()->where('slug', $slug)->with('author')->firstOrFail();
        $relatedBlogs = Blog::published()->with('author')
            ->where('id', '!=', $blog->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('blog.show', compact('blog', 'relatedBlogs'));
    }
}
