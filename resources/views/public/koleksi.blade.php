<x-public-layout>
    <x-slot name="title">Koleksi Buku - Perpustakaan Pena Luhur</x-slot>
    <div class="container mx-auto px-6 py-16">
        <div class="text-center mb-12" data-aos="fade-up">
            <h1 class="text-4xl font-bold text-gray-800">Koleksi Buku Kami</h1>
            <p class="text-gray-600 mt-2">Temukan buku favorit Anda di sini.</p>
        </div>

        <!-- Form Pencarian -->
        <div class="mb-12" data-aos="fade-up">
            <form action="{{ route('koleksi') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="flex">
                    <input type="text" name="search" placeholder="Cari berdasarkan judul atau pengarang..." value="{{ $search ?? '' }}" class="w-full rounded-l-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-lg p-3">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700 font-semibold">Cari</button>
                </div>
            </form>
        </div>

        <!-- Grid Hasil Pencarian Buku -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @forelse ($books as $book)
                <div class="bg-white p-4 rounded-lg shadow-md text-center transform hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 50 }}">
                    <img src="https://placehold.co/300x400/E2E8F0/4A5568?text={{ urlencode(Str::limit($book->judul, 15)) }}" alt="[Sampul buku {{ $book->judul }}]" class="w-full h-64 object-cover rounded-md mx-auto shadow-inner">
                    <h4 class="mt-4 font-semibold text-gray-800 text-sm">{{ Str::limit($book->judul, 30) }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($book->pengarang, 25) }}</p>
                </div>
            @empty
                <div class="col-span-full text-center py-16" data-aos="fade-up">
                    <p class="text-gray-500 text-lg">
                        @if($search)
                            Buku dengan kata kunci "{{ $search }}" tidak ditemukan.
                        @else
                            Saat ini belum ada buku yang tersedia di koleksi.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Navigasi Halaman (Pagination) -->
        <div class="mt-12">
            {{ $books->appends(['search' => $search ?? ''])->links() }}
        </div>
    </div>
</x-public-layout>
