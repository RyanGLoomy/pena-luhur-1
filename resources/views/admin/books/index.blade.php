<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <form action="{{ route('admin.books.index') }}" method="GET" class="w-full md:w-1/2">
                            <div class="flex">
                                <input type="text" name="search" placeholder="Cari judul atau pengarang..." value="{{ $search ?? '' }}" class="w-full rounded-l-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4">
                                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-r-lg hover:bg-gray-900">Cari</button>
                            </div>
                        </form>
                        <a href="{{ route('admin.books.create') }}" class="w-full md:w-auto inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                            + Tambah Buku Baru
                        </a>
                    </div>

                    {{-- Pesan sukses akan digantikan oleh notifikasi SweetAlert --}}
                    {{-- @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif --}}

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left">Judul</th>
                                    <th class="py-3 px-4 border-b text-left">Pengarang</th>
                                    <th class="py-3 px-4 border-b text-left">Tahun</th>
                                    <th class="py-3 px-4 border-b text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 border-b">{{ $book->judul }}</td>
                                        <td class="py-3 px-4 border-b">{{ $book->pengarang }}</td>
                                        <td class="py-3 px-4 border-b">{{ $book->tahun_terbit }}</td>
                                        <td class="py-3 px-4 border-b text-center whitespace-nowrap">
                                            <a href="{{ route('admin.books.edit', $book) }}" class="text-yellow-500 hover:text-yellow-700 mr-3">Edit</a>

                                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline-block delete-form" data-judul="{{ $book->judul }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 px-4 text-center text-gray-500">
                                            @if($search)
                                                Buku dengan kata kunci "{{ $search }}" tidak ditemukan.
                                            @else
                                                Tidak ada data buku.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $books->appends(['search' => $search ?? ''])->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Notifikasi sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session("success") }}',
                    showConfirmButton: false,
                    timer: 2500
                });
            @endif

            // Event listener untuk form hapus buku
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const bookTitle = form.dataset.judul;

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        html: `Anda yakin ingin menghapus buku berjudul:<br><strong>"${bookTitle}"</strong>?<br><small>Tindakan ini tidak dapat dibatalkan!</small>`,
                        icon: 'warning',

                        showCancelButton: true,
                        confirmButtonColor: '#e53e3e',
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Ya, Hapus Saja!',
                        cancelButtonText: 'Tidak, Batal',
                        reverseButtons: true,

                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading(),

                        preConfirm: () => {
                            return new Promise((resolve) => {
                               setTimeout(() => resolve(), 500);
                            });
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
