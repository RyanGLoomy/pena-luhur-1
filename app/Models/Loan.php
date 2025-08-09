<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Book.
     * Ini memungkinkan Anda untuk mengambil data buku yang terkait dengan peminjaman.
     * Contoh penggunaan: $loan->book;
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model Member.
     * Ini memungkinkan Anda untuk mengambil data anggota yang terkait dengan peminjaman.
     * Contoh penggunaan: $loan->member;
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
