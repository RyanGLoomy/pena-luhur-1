<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Perpustakaan Pena Luhur' }}</title>

    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233b82f6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpath d='M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z'%3e%3c/path%3e%3cpath d='M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z'%3e%3c/path%3e%3c/svg%3e">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS (Animate On Scroll) Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- PERBAIKAN: Memuat CSS dan JS dari Vite, termasuk Alpine.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CSS (fallback if Vite not running) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>


</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Header / Navigation -->
    <header x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}">
                <x-application-logo class="h-10 w-auto" />
            </a>
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Beranda</a>
                <a href="{{ route('koleksi') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Koleksi</a>
                <a href="{{ route('gallery') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Galeri</a>
                <a href="{{ route('location') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Lokasi</a>
            </div>
            <a href="{{ route('login') }}" class="hidden md:block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Login Admin</a>

            <!-- Mobile hamburger -->
            <div class="md:hidden">
                <button @click="open = !open" aria-label="Toggle menu" class="inline-flex items-center gap-2 justify-center px-3 py-2 rounded-md border border-gray-300 text-gray-700 bg-white hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-sm font-medium">Menu</span>
                </button>
            </div>
        </nav>

        <!-- Mobile menu -->
        <div x-show="open" x-transition.opacity x-cloak class="md:hidden border-t border-gray-200 bg-white">
            <div class="container mx-auto px-6 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-blue-600">Beranda</a>
                <a href="{{ route('koleksi') }}" class="block py-2 text-gray-700 hover:text-blue-600">Koleksi</a>
                <a href="{{ route('gallery') }}" class="block py-2 text-gray-700 hover:text-blue-600">Galeri</a>
                <a href="{{ route('location') }}" class="block py-2 text-gray-700 hover:text-blue-600">Lokasi</a>
                <a href="{{ route('login') }}" class="block py-2 text-blue-600 font-medium">Login Admin</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-16">
        <div class="container mx-auto px-6 py-8 text-center text-gray-600">
            <p>&copy; {{ date('Y') }} Perpustakaan Pena Luhur. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
          duration: 800,
          once: true,
      });
    </script>
</body>
</html>
