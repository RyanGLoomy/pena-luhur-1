<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BookController; // Tambahkan ini
use App\Http\Controllers\Admin\MemberController; // Tambahkan ini
use App\Http\Controllers\Admin\LoanController; // Tambahkan ini
use App\Http\Controllers\PublicController; // Tambahkan ini

// ... route lainnya

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/lokasi', [PublicController::class, 'location'])->name('location');
Route::get('/koleksi', [PublicController::class, 'koleksi'])->name('koleksi');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Grup Route untuk Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('books', BookController::class);
        Route::resource('members', MemberController::class);
        Route::resource('loans', LoanController::class);
        // Route untuk pengembalian buku
        Route::patch('loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
    });
});

require __DIR__.'/auth.php';
