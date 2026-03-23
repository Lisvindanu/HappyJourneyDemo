<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display the blog index page with optional category filtering.
     */
    public function index(Request $request)
    {
        $activeCategory = $request->query('category');

        $query = BlogArticle::where('is_active', true)
            ->orderByDesc('published_at');

        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        $articles = $query->paginate(9)->withQueryString();

        $categories = ['China', 'Vietnam', 'Jepang', 'Inspirasi', 'Corporate'];

        return view('blog.index', compact('articles', 'categories', 'activeCategory'));
    }

    /**
     * Display a single blog article with related articles from the same category.
     */
    public function show(string $slug)
    {
        $article = BlogArticle::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = BlogArticle::where('is_active', true)
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('article', 'related'));
    }
}
