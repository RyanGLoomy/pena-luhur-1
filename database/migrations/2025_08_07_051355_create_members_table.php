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
        // Perintah ini membuat tabel bernama 'members' di database Anda
        Schema::create('members', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' sebagai Primary Key
            $table->string('kode_anggota')->unique(); // Kolom untuk kode anggota, harus unik
            $table->string('nama_lengkap'); // Kolom untuk nama lengkap
            $table->text('alamat'); // Kolom untuk alamat
            $table->string('no_telp')->nullable(); // Kolom untuk nomor telepon, boleh kosong
            $table->string('pekerjaan')->nullable(); // Kolom untuk pekerjaan, boleh kosong
            $table->string('pendidikan_terakhir')->nullable(); // Kolom untuk pendidikan, boleh kosong
            $table->date('tanggal_registrasi'); // Kolom khusus untuk tanggal
            $table->timestamps(); // Membuat kolom 'created_at' dan 'updated_at' secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
