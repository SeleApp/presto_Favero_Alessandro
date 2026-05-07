<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_accepted', true)->with(['category', 'images'])->orderBy('created_at', 'desc')->paginate(10);

        return view('article.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function show(Article $article)
    {
        $article->load(['category', 'images']);

        return view('article.show', compact('article'));
    }

    public function byCategory(Category $category)
    {
        return view('article.byCategory', [
            'articles' => $category->articles()->where('is_accepted', true)->with(['category', 'images'])->orderBy('created_at', 'desc')->get(),
            'category' => $category,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->string('query')->trim()->toString();

        if ($query === '') {
            $articles = Article::where('is_accepted', true)
                ->with(['category', 'images'])
                ->orderBy('created_at', 'desc')
                ->paginate(8)
                ->withQueryString();
        } else {
            $articles = Article::search($query)
                ->query(fn ($builder) => $builder->where('is_accepted', true)->with(['category', 'images']))
                ->paginate(8)
                ->withQueryString();
        }

        return view('article.searched', compact('articles', 'query'));
    }
}
