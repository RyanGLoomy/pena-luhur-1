<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('admin.loans.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg mb-6 transition duration-300">
                        + Catat Peminjaman Baru
                    </a>

                    <div class="border-b border-gray-200 mb-6">
                        <nav class="flex -mb-px space-x-8" aria-label="Tabs">
                            <a href="{{ route('admin.loans.index', ['status' => 'Dipinjam']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm @if($status == 'Dipinjam') border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif">
                                Peminjaman Aktif
                            </a>
                            <a href="{{ route('admin.loans.index', ['status' => 'Kembali']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm @if($status == 'Kembali') border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif">
                                Riwayat Peminjaman
                            </a>
                        </nav>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left">Judul Buku</th>
                                    <th class="py-3 px-4 border-b text-left">Peminjam</th>
                                    <th class="py-3 px-4 border-b text-left">Tgl Pinjam</th>
                                    <th class="py-3 px-4 border-b text-left">Tgl Kembali</th>
                                    <th class="py-3 px-4 border-b text-left">Status</th>
                                    <th class="py-3 px-4 border-b text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loans as $loan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 border-b">{{ $loan->book->judul ?? 'Buku Dihapus' }}</td>
                                        <td class="py-3 px-4 border-b">{{ $loan->member->nama_lengkap ?? 'Anggota Dihapus' }}</td>
                                        <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td class="py-3 px-4 border-b">{{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') : '-' }}</td>
                                        <td class="py-3 px-4 border-b">
                                            @if($loan->status == 'Dipinjam')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Dipinjam</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Kembali</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 border-b text-center whitespace-nowrap">
                                            {{-- MODIFIKASI KOLOM AKSI --}}
                                            @if($loan->status == 'Dipinjam')
                                                <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="inline-block return-form" data-judul="{{ $loan->book->judul ?? 'Buku Dihapus' }}" data-peminjam="{{ $loan->member->nama_lengkap ?? 'Anggota Dihapus' }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-500 hover:text-green-700">Tandai Kembali</button>
                                                </form>
                                            @elseif($loan->status == 'Kembali')
                                                {{-- FORM BARU UNTUK AKSI BATALKAN KEMBALI --}}
                                                <form action="{{ route('admin.loans.undo_return', $loan) }}" method="POST" class="inline-block undo-return-form" data-judul="{{ $loan->book->judul ?? 'Buku Dihapus' }}" data-peminjam="{{ $loan->member->nama_lengkap ?? 'Anggota Dihapus' }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-yellow-500 hover:text-yellow-700">Batalkan Kembali</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="py-4 px-4 text-center text-gray-500">Tidak ada data untuk ditampilkan di tab ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">{{ $loans->appends(['status' => $status])->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Notifikasi Sukses
            @if (session('success'))
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session("success") }}', showConfirmButton: false, timer: 3000 });
            @endif

            // Notifikasi Gagal/Error
            @if (session('error'))
                Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session("error") }}' });
            @endif

            // Konfirmasi untuk "Tandai Kembali"
            document.querySelectorAll('.return-form').forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const bookTitle = form.dataset.judul;
                    const borrowerName = form.dataset.peminjam;
                    Swal.fire({
                        title: 'Konfirmasi Pengembalian',
                        html: `Tandai buku <strong>"${bookTitle}"</strong> telah dikembalikan oleh <strong>${borrowerName}</strong>?`,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#10B981',
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Ya, Sudah Kembali!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        showLoaderOnConfirm: true,
                        preConfirm: () => new Promise(resolve => setTimeout(() => resolve(), 500))
                    }).then(result => { if (result.isConfirmed) form.submit(); });
                });
            });

            // SCRIPT BARU UNTUK KONFIRMASI "BATALKAN KEMBALI"
            document.querySelectorAll('.undo-return-form').forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const bookTitle = form.dataset.judul;
                    Swal.fire({
                        title: 'Batalkan Pengembalian?',
                        html: `Status buku <strong>"${bookTitle}"</strong> akan diubah menjadi 'Dipinjam' kembali. Lanjutkan?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f59e0b', // Warna kuning/amber
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Ya, Batalkan!',
                        cancelButtonText: 'Tidak',
                        reverseButtons: true,
                        showLoaderOnConfirm: true,
                        preConfirm: () => new Promise(resolve => setTimeout(() => resolve(), 500))
                    }).then(result => { if (result.isConfirmed) form.submit(); });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
