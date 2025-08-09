<!-- Pesan Error Validasi -->
@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
        <p class="font-bold">Terjadi Kesalahan</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Judul Buku -->
    <div>
        <label for="judul" class="block font-medium text-sm text-gray-700">Judul Buku</label>
        <input type="text" name="judul" id="judul" value="{{ old('judul', $book->judul ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <!-- Pengarang -->
    <div>
        <label for="pengarang" class="block font-medium text-sm text-gray-700">Pengarang</label>
        <input type="text" name="pengarang" id="pengarang" value="{{ old('pengarang', $book->pengarang ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <!-- Penerbit -->
    <div>
        <label for="penerbit" class="block font-medium text-sm text-gray-700">Penerbit</label>
        <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $book->penerbit ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <!-- Tahun Terbit -->
    <div>
        <label for="tahun_terbit" class="block font-medium text-sm text-gray-700">Tahun Terbit</label>
        <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <!-- Nomor Induk -->
    <div>
        <label for="nomor_induk" class="block font-medium text-sm text-gray-700">Nomor Induk</label>
        <input type="text" name="nomor_induk" id="nomor_induk" value="{{ old('nomor_induk', $book->nomor_induk ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <!-- Jumlah Eksemplar -->
    <div>
        <label for="jumlah_eksemplar" class="block font-medium text-sm text-gray-700">Jumlah Eksemplar</label>
        <input type="number" name="jumlah_eksemplar" id="jumlah_eksemplar" value="{{ old('jumlah_eksemplar', $book->jumlah_eksemplar ?? 1) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>
</div>

<!-- Tombol Aksi -->
<div class="flex items-center justify-end mt-8">
    <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
        {{ $submitButtonText ?? 'Simpan' }}
    </button>
</div>
