<?php

use App\Http\Controllers\FaqController; 
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
Route::get('/faqs/{id}/{type}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
Route::put('/faqs/{id}/{type}', [FaqController::class, 'update'])->name('faqs.update');
Route::delete('/faqs/{id}/{type}', [FaqController::class, 'destroy'])->name('faqs.destroy');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/admin/contact/{contact}', [ContactController::class, 'showMessage'])->name('contact.show-message');
    Route::patch('/admin/contact/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('contact.mark-read');
    Route::delete('/admin/contact/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');
});

require __DIR__.'/auth.php';