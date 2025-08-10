{{-- File: resources/views/public/gallery.blade.php --}}
<x-public-layout>
    <x-slot name="title">Galeri - Perpustakaan Pena Luhur</x-slot>

    <div class="container mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Galeri Kegiatan</h1>
            <p class="text-lg text-gray-600 mb-2">Momen-momen berharga di Perpustakaan Pena Luhur</p>
            <p class="text-sm text-gray-500">Klik gambar untuk memperbesar</p>
        </div>

        @php
            $imageFiles = ['kegiatan_1.jpg', 'kegiatan_2.jpg', 'kegiatan_3.jpg', 'kegiatan_4.jpg', 'kegiatan_5.jpg', 'kegiatan_6.jpg'];
            // Buat array baru yang berisi path lengkap ke setiap gambar
            $imagePaths = array_map(function($file) {
                return asset('images/gallery/' . $file);
            }, $imageFiles);
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="gallery">
            @foreach($imagePaths as $index => $path)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="cursor-pointer hover:shadow-xl transition-shadow duration-300" onclick="openModal({{ $index }})">
                    <img loading="lazy"
                         src="{{ $path }}"
                         alt="Kegiatan {{ $index + 1 }}"
                         class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300"
                         onerror="this.src='https://picsum.photos/600/400?random={{ $index + 1 }}'">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800">Kegiatan {{ $index + 1 }}</h3>
                    <p class="text-sm text-gray-600">Perpustakaan Pena Luhur</p>
                </div>
            </div>
            @endforeach
        </div>

        <div id="lightboxModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-20">&times;</button>
            <button id="prevBtn" onclick="previousImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-2xl hover:text-gray-300 z-20 bg-black bg-opacity-50 w-12 h-12 rounded-full flex items-center justify-center">&#8249;</button>
            <button id="nextBtn" onclick="nextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-2xl hover:text-gray-300 z-20 bg-black bg-opacity-50 w-12 h-12 rounded-full flex items-center justify-center">&#8250;</button>

            <div class="relative max-w-full max-h-full flex items-center justify-center">
                <div id="modalSpinner" class="w-16 h-16 border-4 border-dashed rounded-full animate-spin border-white"></div>

                <img id="modalImage" src="" alt="" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl hidden">

                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 text-white text-center">
                    <div class="bg-black bg-opacity-70 rounded-full px-4 py-2">
                        <span id="currentNum">1</span> / <span id="totalNum">{{ count($imagePaths) }}</span>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 -z-10" onclick="closeModal()"></div>
        </div>
    </div>

    @push('scripts')
    <script>
        // =======================================================
        // PERUBAHAN 4: MENGAMBIL DATA GAMBAR DARI PHP
        // =======================================================
        const images = @json($imagePaths);
        let currentImageIndex = 0;

        function openModal(index) {
            currentImageIndex = index;
            const modal = document.getElementById('lightboxModal');
            const modalImage = document.getElementById('modalImage');
            const spinner = document.getElementById('modalSpinner');
            const currentNum = document.getElementById('currentNum');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            // Tampilkan spinner dan sembunyikan gambar saat memuat
            spinner.style.display = 'block';
            modalImage.style.display = 'none';

            // Set sumber gambar dan tunggu sampai selesai dimuat
            modalImage.src = images[index];
            modalImage.onload = () => {
                // Setelah gambar selesai dimuat, sembunyikan spinner dan tampilkan gambar
                spinner.style.display = 'none';
                modalImage.style.display = 'block';
            };

            modalImage.alt = 'Kegiatan ' + (index + 1);
            currentNum.textContent = index + 1;
            prevBtn.style.display = (index === 0) ? 'none' : 'flex';
            nextBtn.style.display = (index === images.length - 1) ? 'none' : 'flex';

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('lightboxModal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function nextImage() {
            if (currentImageIndex < images.length - 1) {
                openModal(currentImageIndex + 1);
            }
        }

        function previousImage() {
            if (currentImageIndex > 0) {
                openModal(currentImageIndex - 1);
            }
        }

        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('lightboxModal');
            if (!modal.classList.contains('hidden')) {
                if (e.key === 'Escape') closeModal();
                else if (e.key === 'ArrowLeft') previousImage();
                else if (e.key === 'ArrowRight') nextImage();
            }
        });
    </script>
    @endpush
</x-public-layout>
