    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Catat Peminjaman Baru') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8 text-gray-900">
                        <form action="{{ route('admin.loans.store') }}" method="POST">
                            @csrf

                            @if ($errors->any())
                                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="space-y-6">
                                <!-- Pilih Buku -->
                                <div>
                                    <label for="book_id" class="block font-medium text-sm text-gray-700">Pilih Buku (Hanya yang tersedia)</label>
                                    <select name="book_id" id="book_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Pilih Buku --</option>
                                        @foreach($books as $book)
                                            <option value="{{ $book->id }}">{{ $book->judul }} - ({{ $book->pengarang }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pilih Anggota -->
                                <div>
                                    <label for="member_id" class="block font-medium text-sm text-gray-700">Pilih Anggota Peminjam</label>
                                    <select name="member_id" id="member_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Pilih Anggota --</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->kode_anggota }} - {{ $member->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex items-center justify-end mt-8">
                                <a href="{{ route('admin.loans.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                                    Simpan Peminjaman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    