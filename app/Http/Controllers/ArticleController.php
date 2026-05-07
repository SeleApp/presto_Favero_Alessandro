<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->orderBy('created_at', 'desc')->paginate(10);

        return view('article.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    public function byCategory(Category $category)
    {
        return view('article.byCategory', [
            'articles' => $category->articles()->with('category')->orderBy('created_at', 'desc')->get(),
            'category' => $category,
        ]);
    }
}
