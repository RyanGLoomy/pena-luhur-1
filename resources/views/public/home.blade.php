<x-public-layout>
    <section
        class="relative bg-cover bg-center text-white"
        style="background-image: url('{{ asset('images/hero/background.jpg') }}');">

        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <div class="relative container mx-auto px-6 py-32 text-center">
            <div data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl font-bold">Membuka Jendela Dunia,</h1>
                <h2 class="text-4xl md:text-6xl font-bold text-blue-400">Satu Buku Sekaligus.</h2>
                <p class="mt-6 text-gray-200 max-w-2xl mx-auto">
                    Jelajahi koleksi kami dan temukan inspirasi baru di Perpustakaan Pena Luhur, rumah bagi para pencari ilmu dan imajinasi.
                </p>
            </div>
        </div>
    </section>

    <section id="tentang" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-800">Tentang Pena Luhur</h2>
                <p class="text-gray-600 mt-2">Lebih dari sekadar tumpukan buku.</p>
            </div>
            <div class="flex flex-wrap items-center">

                <div class="w-full md:w-1/2 px-4" data-aos="fade-right">
                    <div class="text-center">
                        <img src="{{ asset('images/about/person_2.jpg') }}"
                            alt="Foto Jatmiko, S.Hum., Kepala Perpustakaan Pena Luhur"
                            class="rounded-lg shadow-lg w-full max-w-sm mx-auto"
                            onerror="this.onerror=null;this.src='https.placehold.co/600x400/E2E8F0/4A5568?text=Foto+Pimpinan';">

                        <div class="mt-4">
                            <h4 class="text-xl font-bold text-gray-800">Windy Jatmiko, S.S</h4>
                            <p class="text-md text-gray-600">Kepala Kelurahan Sawah Luhur</p>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-4 mt-8 md:mt-0" data-aos="fade-left">
                    <h3 class="text-2xl font-semibold text-gray-800">Visi Kami</h3>
                    <p class="text-gray-600 mt-4">
                        Menjadi pusat literasi dan kegiatan komunitas yang inspiratif, menyediakan akses tak terbatas terhadap pengetahuan, dan mendorong budaya membaca bagi semua kalangan masyarakat.
                    </p>
                    <h3 class="text-2xl font-semibold text-gray-800 mt-6">Misi Kami</h3>
                    <ul class="list-disc list-inside text-gray-600 mt-4 space-y-2">
                        <li>Menyediakan koleksi buku yang beragam dan relevan.</li>
                        <li>Menciptakan ruang yang nyaman dan kondusif untuk belajar.</li>
                        <li>Menyelenggarakan acara dan lokakarya yang edukatif.</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-800">Koleksi Terbaru</h2>
                <p class="text-gray-600 mt-2">Buku-buku baru yang siap Anda jelajahi.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse ($latestBooks as $book)
                    <div class="bg-gray-50 p-4 rounded-lg text-center transform hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <img src="https://placehold.co/300x400/E2E8F0/4A5568?text={{ urlencode($book->judul) }}" alt="[Sampul buku {{ $book->judul }}]" class="w-full h-64 object-cover rounded-md mx-auto">
                        <h4 class="mt-4 font-semibold text-gray-800">{{ Str::limit($book->judul, 25) }}</h4>
                        <p class="text-sm text-gray-500">{{ $book->pengarang }}</p>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Belum ada buku baru.</p>
                @endforelse
            </div>
        </div>
    </section>
</x-public-layout>
