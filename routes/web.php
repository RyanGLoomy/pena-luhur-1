<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\PublicController;

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

        // ===================================================================
        // TAMBAHKAN ROUTE BARU DI SINI
        // ===================================================================
        Route::patch('loans/{loan}/undo-return', [LoanController::class, 'undoReturn'])->name('loans.undo_return');
    });
});

require __DIR__.'/auth.php';
