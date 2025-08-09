<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Exception;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // In app/Http/Controllers/Admin/BookController.php

    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari URL
        $search = $request->input('search');

        // Mulai query ke database
        $books = Book::query()
            // Jika ada kata kunci pencarian, filter data
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                            ->orWhere('pengarang', 'like', "%{$search}%");
            })
            // Urutkan dan bagi per halaman
            ->latest()
            ->paginate(10);

        // Kirim data buku dan kata kunci pencarian ke view
        return view('admin.books.index', compact('books', 'search'));
    }

    public function run(): void
    {
        // 1. Matikan sementara pengecekan foreign key
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel-tabel terkait
        DB::table('books')->truncate();
        DB::table('members')->truncate();
        DB::table('loans')->truncate();

        // 3. Aktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        // 4. Lanjutkan proses membaca dan memasukkan data dari CSV
        $csvFile = fopen(database_path('data/books_data.csv'), 'r');

        // Lewati baris header
        fgetcsv($csvFile);

        $rowNumber = 1;
        // **PERBAIKAN FINAL:** Menggunakan titik koma (;) sebagai pemisah, sesuai file CSV Anda
        while (($data = fgetcsv($csvFile, 2000, ';')) !== false) {
            $rowNumber++;
            // Melewatkan baris yang kosong atau tidak memiliki judul
            if (empty($data) || empty($data[2])) {
                continue;
            }

            try {
                // Pengecekan aman untuk tahun_terbit
                // Indeks [5] sesuai dengan kolom 'Tahun Terbit' di file 'Buku Induk.csv'
                $yearValue = isset($data[5]) ? intval($data[5]) : null;
                $tahun_terbit = ($yearValue > 1000 && $yearValue <= (date('Y') + 1)) ? $yearValue : null;

                // Membuat record baru di tabel 'books' untuk setiap baris di CSV
                // Indeks disesuaikan dengan struktur file 'Buku Induk.csv'
                Book::create([
                    'nomor_induk'       => $data[8] ?? 'N/A-' . $rowNumber, // Kolom ke-9
                    'judul'             => $data[2], // Kolom ke-3
                    'pengarang'         => $data[3], // Kolom ke-4
                    'penerbit'          => $data[4], // Kolom ke-5
                    'tahun_terbit'      => $tahun_terbit, // Kolom ke-6 (sudah divalidasi)
                    'jumlah_eksemplar'  => 1,
                    // Kolom lain bisa diisi null atau data default
                    'kota_terbit'       => null,
                    'deskripsi_fisik'   => null,
                    'isbn_issn'         => null,
                    'subjek'            => null,
                    'nomor_panggil'     => null,
                ]);
            } catch (Exception $e) {
                // Jika terjadi error, tampilkan pesan yang jelas
                $this->command->error("Error processing row {$rowNumber}: " . $e->getMessage());
                continue;
            }
        }

        fclose($csvFile);
    }
}
