<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RevisorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'homepage'])->name('homepage');
Route::post('/language/{lang}', [PublicController::class, 'setLanguage'])->name('locale.switch');
Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->middleware('auth')->name('articles.create');
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/article/search', [ArticleController::class, 'search'])->name('article.search');
Route::get('/category/{category}', [ArticleController::class, 'byCategory'])->name('byCategory');

Route::middleware(['auth', 'isRevisor'])->prefix('revisor')->name('revisor.')->group(function () {
	Route::get('/index', [RevisorController::class, 'index'])->name('index');
	Route::patch('/accept/{article}', [RevisorController::class, 'accept'])->name('accept');
	Route::patch('/reject/{article}', [RevisorController::class, 'reject'])->name('reject');
});
