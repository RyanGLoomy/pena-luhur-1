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

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

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
                                        <td class="py-3 px-4 border-b">
                                            {{-- Tampilkan tanggal kembali jika ada, jika tidak tampilkan strip --}}
                                            {{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="py-3 px-4 border-b">
                                            @if($loan->status == 'Dipinjam')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Dipinjam
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Kembali
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 border-b text-center whitespace-nowrap">
                                            @if($loan->status == 'Dipinjam')
                                                <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin buku ini sudah dikembalikan?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-500 hover:text-green-700">Tandai Kembali</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">Tidak ada data peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $loans->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
