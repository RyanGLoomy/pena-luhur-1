<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Perintah ini membuat tabel bernama 'loans' di database Anda
        Schema::create('loans', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' sebagai Primary Key

            // Kolom ini terhubung dengan 'id' di tabel 'members'.
            // Jika anggota dihapus, data peminjamannya juga akan terhapus (onDelete('cascade')).
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');

            // Kolom ini terhubung dengan 'id' di tabel 'books'.
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');

            $table->date('tanggal_pinjam'); // Kolom untuk tanggal peminjaman
            $table->date('tanggal_kembali')->nullable(); // Kolom untuk tanggal kembali, boleh kosong
            $table->enum('status', ['Dipinjam', 'Kembali'])->default('Dipinjam'); // Kolom status dengan pilihan terbatas
            $table->timestamps(); // Membuat kolom 'created_at' dan 'updated_at' secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
