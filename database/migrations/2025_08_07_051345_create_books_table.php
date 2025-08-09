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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_induk')->unique();
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            // MODIFIKASI: Menambahkan ->nullable() agar kolom ini boleh kosong
            $table->year('tahun_terbit')->nullable();
            $table->string('kota_terbit')->nullable();
            $table->text('deskripsi_fisik')->nullable();
            $table->string('isbn_issn')->nullable();
            $table->string('subjek')->nullable();
            $table->string('nomor_panggil')->nullable();
            $table->integer('jumlah_eksemplar')->default(1);
            $table->enum('status_ketersediaan', ['Tersedia', 'Dipinjam'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
