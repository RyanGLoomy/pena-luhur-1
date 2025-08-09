{{-- File: resources/views/gallery.blade.php --}}
<x-public-layout>
    <x-slot name="title">Galeri - Perpustakaan Pena Luhur</x-slot>

    <div class="container mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Galeri Kegiatan</h1>
            <p class="text-lg text-gray-600 mb-2">Momen-momen berharga di Perpustakaan Pena Luhur</p>
            <p class="text-sm text-gray-500">Klik gambar untuk memperbesar</p>
        </div>

        <!-- Simple Gallery dengan JavaScript Vanilla -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="gallery">
            @php
                $images = ['kegiatan_1.jpg', 'kegiatan_2.jpg', 'kegiatan_3.jpg', 'kegiatan_4.jpg', 'kegiatan_5.jpg', 'kegiatan_6.jpg'];
            @endphp

            @foreach($images as $index => $image)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="cursor-pointer hover:shadow-xl transition-shadow duration-300"
                     onclick="openModal({{ $index }})">
                    <img src="{{ asset('images/gallery/' . $image) }}"
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

        <!-- Modal Lightbox -->
        <div id="lightboxModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4">
            <!-- Close Button -->
            <button onclick="closeModal()"
                    class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-20">
                &times;
            </button>

            <!-- Previous Button -->
            <button id="prevBtn" onclick="previousImage()"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-2xl hover:text-gray-300 z-20 bg-black bg-opacity-50 w-12 h-12 rounded-full flex items-center justify-center">
                &#8249;
            </button>

            <!-- Next Button -->
            <button id="nextBtn" onclick="nextImage()"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-2xl hover:text-gray-300 z-20 bg-black bg-opacity-50 w-12 h-12 rounded-full flex items-center justify-center">
                &#8250;
            </button>

            <!-- Image -->
            <div class="relative max-w-full max-h-full">
                <img id="modalImage" src="" alt=""
                     class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">

                <!-- Counter -->
                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 text-white text-center">
                    <div class="bg-black bg-opacity-70 rounded-full px-4 py-2">
                        <span id="currentNum">1</span> / <span id="totalNum">{{ count($images) }}</span>
                    </div>
                </div>
            </div>

            <!-- Background click to close -->
            <div class="absolute inset-0" onclick="closeModal()"></div>
        </div>
    </div>

    <script>
        // Global variables
        let currentImageIndex = 0;
        const images = [
            @foreach($images as $image)
            '{{ asset('images/gallery/' . $image) }}',
            @endforeach
        ];

        console.log('Gallery initialized with ' + images.length + ' images');

        function openModal(index) {
            console.log('Opening modal for image index: ' + index);

            currentImageIndex = index;
            const modal = document.getElementById('lightboxModal');
            const modalImage = document.getElementById('modalImage');
            const currentNum = document.getElementById('currentNum');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            // Set image source
            modalImage.src = images[index];
            modalImage.alt = 'Kegiatan ' + (index + 1);

            // Update counter
            currentNum.textContent = index + 1;

            // Show/hide navigation buttons
            prevBtn.style.display = (index === 0) ? 'none' : 'flex';
            nextBtn.style.display = (index === images.length - 1) ? 'none' : 'flex';

            // Show modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            console.log('Closing modal');

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

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('lightboxModal');

            if (!modal.classList.contains('hidden')) {
                if (e.key === 'Escape') {
                    closeModal();
                } else if (e.key === 'ArrowLeft') {
                    previousImage();
                } else if (e.key === 'ArrowRight') {
                    nextImage();
                }
            }
        });

        // Test function to verify JavaScript is working
        function testJS() {
            alert('JavaScript is working!');
            console.log('Test function called successfully');
        }

        // Call test on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, gallery ready');
            // Uncomment line below to test if JS is working
            // testJS();
        });
    </script>
</x-public-layout>
