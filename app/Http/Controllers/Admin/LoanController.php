<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        // Ambil data peminjaman, termasuk data buku dan anggota terkait
        $loans = Loan::with(['book', 'member'])->latest()->paginate(10);
        return view('admin.loans.index', compact('loans'));
    }

    public function create()
    {
        // Ambil hanya buku yang statusnya 'Tersedia'
        $books = Book::where('status_ketersediaan', 'Tersedia')->orderBy('judul')->get();
        $members = Member::orderBy('nama_lengkap')->get();
        return view('admin.loans.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
        ]);

        // Gunakan transaction untuk memastikan kedua operasi berhasil
        DB::transaction(function () use ($request) {
            // 1. Buat catatan peminjaman baru
            Loan::create([
                'book_id' => $request->book_id,
                'member_id' => $request->member_id,
                'tanggal_pinjam' => now(),
                'status' => 'Dipinjam',
            ]);

            // 2. Update status buku menjadi 'Dipinjam'
            $book = Book::find($request->book_id);
            $book->status_ketersediaan = 'Dipinjam';
            $book->save();
        });

        return redirect()->route('admin.loans.index')
                         ->with('success', 'Peminjaman baru berhasil dicatat.');
    }

    // Fungsi baru untuk menandai buku telah kembali
    public function returnBook(Loan $loan)
    {
        DB::transaction(function () use ($loan) {
            // 1. Update status peminjaman menjadi 'Kembali'
            $loan->status = 'Kembali';
            $loan->tanggal_kembali = now();
            $loan->save();

            // 2. Update status buku menjadi 'Tersedia'
            $book = $loan->book;
            if ($book) {
                $book->status_ketersediaan = 'Tersedia';
                $book->save();
            }
        });

        return redirect()->route('admin.loans.index')
                         ->with('success', 'Buku telah ditandai sebagai kembali.');
    }
}
