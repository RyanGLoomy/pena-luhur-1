<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_anggota',
        'nama_lengkap',
        'alamat',
        'no_telp',
        'pekerjaan',
        'pendidikan_terakhir',
        'tanggal_registrasi',
    ];

    /**
     * Mendefinisikan relasi "hasMany" ke model Loan.
     * Ini memungkinkan Anda untuk mengambil semua riwayat peminjaman seorang anggota.
     * Contoh penggunaan: $member->loans;
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
