<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/artikel', fn () => redirect('/#artikel'))->name('article.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
