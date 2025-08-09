<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Menampilkan Halaman Utama (Home).
     */
    public function home()
    {
        // PERBAIKAN: Ambil 8 buku terbaru dari database dan kirim ke view.
        $latestBooks = Book::latest()->take(8)->get();
        return view('public.home', compact('latestBooks'));
    }

    /**
     * Menampilkan halaman koleksi buku dengan fitur pencarian.
     */
    public function koleksi(Request $request)
    {
        $search = $request->input('search');
        $books = Book::query()
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('pengarang', 'like', "%{$search}%");
            })
            ->where('status_ketersediaan', 'Tersedia')
            ->latest()
            ->paginate(12);
        return view('public.koleksi', compact('books', 'search'));
    }

    /**
     * Menampilkan Halaman Galeri.
     */
    public function gallery()
    {
        return view('public.gallery');
    }

    /**
     * Menampilkan Halaman Lokasi.
     */
    public function location()
    {
        return view('public.location');
    }
}
