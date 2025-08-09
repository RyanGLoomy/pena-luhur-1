<div class="flex items-center space-x-3">
    <!-- SVG Logo: Buku Terbuka + Pena Bulu -->
    <svg {{ $attributes->merge(['class' => 'h-10 w-10 text-blue-600']) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none">
        <!-- Buku kiri -->
        <path d="M4 10V54C12 50 20 50 28 54V10C20 6 12 6 4 10Z" stroke="currentColor" stroke-width="2" fill="none"/>
        <!-- Buku kanan -->
        <path d="M36 10V54C44 50 52 50 60 54V10C52 6 44 6 36 10Z" stroke="currentColor" stroke-width="2" fill="none"/>
        <!-- Garis halaman kiri -->
        <path d="M8 16C13 14 19 14 24 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M8 24C13 22 19 22 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M8 32C13 30 19 30 24 32" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        <!-- Garis halaman kanan -->
        <path d="M40 16C45 14 51 14 56 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M40 24C45 22 51 22 56 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M40 32C45 30 51 30 56 32" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
    </svg>

    <span class="text-2xl font-bold text-gray-800">
        Pena Luhur
    </span>
</div>
