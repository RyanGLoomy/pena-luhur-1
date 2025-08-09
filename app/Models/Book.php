<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    // Asumsikan tabel 'books' memiliki kolom 'title', 'author', dll.
    // Sesuaikan properti $fillable ini dengan skema database Anda.
    protected $fillable = [
        'title',
        'author',
        'stock',
    ];

    /**
     * Mendefinisikan relasi "hasMany" ke model Loan.
     * Ini memungkinkan Anda untuk mengambil semua riwayat peminjaman sebuah buku.
     * Contoh penggunaan: $book->loans;
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
