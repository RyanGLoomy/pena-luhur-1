<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar anggota dengan fungsionalitas pencarian.
     */
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari URL
        $search = $request->input('search');

        // Query data anggota
        $members = Member::query()
            ->when($search, function ($query, $search) {
                // Cari berdasarkan nama atau kode anggota
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                             ->orWhere('kode_anggota', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        // Kirim data anggota DAN variabel $search ke view
        return view('admin.members.index', compact('members', 'search'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'nullable|string|max:15',
            'pekerjaan' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
        ]);

        // Generate Kode Anggota Otomatis
        $prefix = 'PL-' . date('Ym') . '-';
        $lastMember = Member::where('kode_anggota', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $lastNumber = $lastMember ? intval(substr($lastMember->kode_anggota, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $kodeAnggota = $prefix . $newNumber;

        Member::create(array_merge($request->all(), [
            'kode_anggota' => $kodeAnggota,
            'tanggal_registrasi' => now(),
        ]));

        return redirect()->route('admin.members.index')
                         ->with('success', 'Anggota baru berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'nullable|string|max:15',
            'pekerjaan' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
        ]);

        $member->update($request->all());

        return redirect()->route('admin.members.index')
                         ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.members.index')
                         ->with('success', 'Anggota berhasil dihapus.');
    }
}
