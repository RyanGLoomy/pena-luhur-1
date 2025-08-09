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
        <!-- Nama Lengkap -->
        <div>
            <label for="nama_lengkap" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $member->nama_lengkap ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <!-- No. Telp/HP -->
        <div>
            <label for="no_telp" class="block font-medium text-sm text-gray-700">No. Telp/HP</label>
            <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $member->no_telp ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <!-- Alamat -->
        <div class="md:col-span-2">
            <label for="alamat" class="block font-medium text-sm text-gray-700">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('alamat', $member->alamat ?? '') }}</textarea>
        </div>

        <!-- Pekerjaan -->
        <div>
            <label for="pekerjaan" class="block font-medium text-sm text-gray-700">Pekerjaan</label>
            <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $member->pekerjaan ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <!-- Pendidikan Terakhir -->
        <div>
            <label for="pendidikan_terakhir" class="block font-medium text-sm text-gray-700">Pendidikan Terakhir</label>
            <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $member->pendidikan_terakhir ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex items-center justify-end mt-8">
        <a href="{{ route('admin.members.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
            {{ $submitButtonText ?? 'Simpan' }}
        </button>
    </div>
    