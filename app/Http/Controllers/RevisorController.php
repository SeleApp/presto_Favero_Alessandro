<?php

namespace App\Http\Controllers;

use App\Models\Article;

class RevisorController extends Controller
{
    public function index()
    {
        $article_to_check = Article::where('is_accepted', null)->first();

        return view('revisor.index', compact('article_to_check'));
    }

    public function accept(Article $article)
    {
        $article->setAccepted(true);

        return back()->with('message', 'Articolo accettato con successo.');
    }

    public function reject(Article $article)
    {
        $article->setAccepted(false);

        return back()->with('message', 'Articolo rifiutato con successo.');
    }
}
