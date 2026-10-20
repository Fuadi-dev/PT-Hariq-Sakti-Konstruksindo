<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Middleware\TrackVisitor;
use Illuminate\Support\Facades\Route;

Route::middleware(TrackVisitor::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/layanan', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/proyek', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/artikel', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');
});
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
