<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordIndexController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DictionarySearchController;
use Illuminate\Support\Facades\Route;

// Dictionary search homepage as main index page
Route::get('/', [DictionarySearchController::class, 'index'])->name('dictionary.index');

// Dictionary search results - public search route
Route::get('/dictionary/search', [DictionarySearchController::class, 'search'])->name('dictionary.search');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dictionary Routes (protected by auth)
    Route::resource('wordindex', WordIndexController::class);
    
    // WordIndex search route (admin/authenticated)
    Route::get('/admin/search', [WordIndexController::class, 'index'])->name('search');
});

require __DIR__.'/auth.php';
