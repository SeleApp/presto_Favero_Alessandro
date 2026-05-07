<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function homepage()
    {
        $articles = Article::where('is_accepted', true)->take(6)->orderBy('created_at', 'desc')->get();

        return view('welcome', compact('articles'));
    }

    public function setLanguage(Request $request, string $lang): RedirectResponse
    {
        $allowedLanguages = ['it', 'uk', 'es'];

        if (! in_array($lang, $allowedLanguages, true)) {
            return back();
        }

        $request->session()->put('locale', $lang);

        return back();
    }
}
