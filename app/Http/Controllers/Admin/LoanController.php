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
    // ... (method index, create, store tidak berubah) ...
    public function index(Request $request)
    {
        $status = $request->query('status', 'Dipinjam');
        if (!in_array($status, ['Dipinjam', 'Kembali'])) {
            $status = 'Dipinjam';
        }
        $loans = Loan::with(['book', 'member'])
                     ->where('status', $status)
                     ->latest('tanggal_pinjam')
                     ->paginate(10);
        return view('admin.loans.index', compact('loans', 'status'));
    }

    public function create()
    {
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
        DB::transaction(function () use ($request) {
            Loan::create([
                'book_id' => $request->book_id,
                'member_id' => $request->member_id,
                'tanggal_pinjam' => now(),
                'status' => 'Dipinjam',
            ]);
            $book = Book::find($request->book_id);
            $book->status_ketersediaan = 'Dipinjam';
            $book->save();
        });
        return redirect()->route('admin.loans.index')
                         ->with('success', 'Peminjaman baru berhasil dicatat.');
    }

    public function returnBook(Loan $loan)
    {
        DB::transaction(function () use ($loan) {
            $loan->status = 'Kembali';
            $loan->tanggal_kembali = now();
            $loan->save();
            $book = $loan->book;
            if ($book) {
                $book->status_ketersediaan = 'Tersedia';
                $book->save();
            }
        });
        return redirect()->route('admin.loans.index', ['status' => 'Dipinjam'])
                         ->with('success', 'Buku telah ditandai sebagai kembali.');
    }

    /**
     * ====================================================================
     * METHOD BARU UNTUK MEMBATALKAN PENGEMBALIAN
     * ====================================================================
     */
    public function undoReturn(Loan $loan)
    {
        // Pengecekan krusial: Pastikan buku masih tersedia.
        // Jika statusnya sudah 'Dipinjam' (oleh orang lain), maka batalkan aksi.
        if ($loan->book && $loan->book->status_ketersediaan !== 'Tersedia') {
            return redirect()->back()
                             ->with('error', 'Gagal: Buku ini sudah dipinjamkan kembali ke anggota lain.');
        }

        DB::transaction(function () use ($loan) {
            // 1. Update status buku menjadi 'Dipinjam' kembali
            if ($loan->book) {
                $loan->book->status_ketersediaan = 'Dipinjam';
                $loan->book->save();
            }

            // 2. Update status peminjaman menjadi 'Dipinjam' dan hapus tanggal kembali
            $loan->status = 'Dipinjam';
            $loan->tanggal_kembali = null;
            $loan->save();
        });

        // Redirect ke tab Riwayat agar user lihat itemnya sudah 'pindah'
        return redirect()->route('admin.loans.index', ['status' => 'Kembali'])
                         ->with('success', 'Pengembalian berhasil dibatalkan. Data dipindahkan ke Peminjaman Aktif.');
    }
}
