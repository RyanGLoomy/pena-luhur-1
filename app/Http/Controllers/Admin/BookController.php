<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Menampilkan daftar buku dengan fungsionalitas pencarian.
     */
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari URL
        $search = $request->input('search');

        // Query data buku
        $books = Book::query()
            ->when($search, function ($query, $search) {
                // Cari berdasarkan judul atau pengarang
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('pengarang', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        // Kirim data buku DAN variabel $search ke view
        return view('admin.books.index', compact('books', 'search'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'nomor_induk' => 'required|string|unique:books,nomor_induk',
            'jumlah_eksemplar' => 'required|integer|min:1',
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku baru berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'nomor_induk' => 'required|string|unique:books,nomor_induk,' . $book->id,
            'jumlah_eksemplar' => 'required|integer|min:1',
        ]);

        $book->update($request->all());

        return redirect()->route('admin.books.index')
                         ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku berhasil dihapus.');
    }
}
