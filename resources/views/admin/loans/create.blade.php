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
                                    <input type="text" id="book_search" placeholder="Cari buku berdasarkan judul/pengarang..." class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" autocomplete="off" />
                                    <select name="book_id" id="book_id" required class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Pilih Buku --</option>
                                        @foreach($books as $book)
                                            <option value="{{ $book->id }}">{{ $book->judul }} - ({{ $book->pengarang }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pilih Anggota -->
                                <div>
                                    <label for="member_id" class="block font-medium text-sm text-gray-700">Pilih Anggota Peminjam</label>
                                    <input type="text" id="member_search" placeholder="Cari anggota berdasarkan kode/nama..." class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" autocomplete="off" />
                                    <select name="member_id" id="member_id" required class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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

    <!-- Script: Fitur pencarian untuk select Buku & Anggota -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function setupSearch(inputId, selectId) {
                const input = document.getElementById(inputId);
                const select = document.getElementById(selectId);
                if (!input || !select) return;

                const placeholderOption = select.querySelector('option[value=""]');
                // Simpan semua opsi awal (kecuali placeholder)
                const originalOptions = Array.from(select.options)
                    .filter(opt => opt.value !== '')
                    .map(opt => ({ value: opt.value, text: opt.text }));

                function renderOptions(filteredItems) {
                    const currentValue = select.value;
                    // Bersihkan semua opsi
                    while (select.options.length) {
                        select.remove(0);
                    }
                    // Tambahkan kembali placeholder di paling atas
                    if (placeholderOption) {
                        const clone = placeholderOption.cloneNode(true);
                        select.add(clone);
                    } else {
                        const ph = document.createElement('option');
                        ph.value = '';
                        ph.textContent = '-- Pilih --';
                        select.add(ph);
                    }

                    if (filteredItems.length === 0) {
                        const empty = document.createElement('option');
                        empty.disabled = true;
                        empty.textContent = 'Tidak ada hasil';
                        select.add(empty);
                        return;
                    }

                    filteredItems.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.value;
                        opt.textContent = item.text;
                        select.add(opt);
                    });

                    // Pertahankan pilihan jika masih ada dalam hasil
                    const stillExists = filteredItems.some(i => i.value === currentValue);
                    if (stillExists) {
                        select.value = currentValue;
                    } else {
                        select.value = '';
                    }
                }

                input.addEventListener('input', function () {
                    const query = input.value.trim().toLowerCase();
                    if (!query) {
                        renderOptions(originalOptions);
                        return;
                    }
                    const filtered = originalOptions.filter(item => item.text.toLowerCase().includes(query));
                    renderOptions(filtered);
                });
            }

            setupSearch('book_search', 'book_id');
            setupSearch('member_search', 'member_id');
        });
    </script>
    </x-app-layout>
