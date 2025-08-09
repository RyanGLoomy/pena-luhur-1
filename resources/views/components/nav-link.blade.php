@props(['active'])

@php
$baseClasses = 'inline-flex items-center px-3 py-2 text-sm font-medium leading-5 transition-colors duration-150 ease-in-out';

// Aktif → biru, Non-aktif → abu-abu
$classes = ($active ?? false)
            ? $baseClasses . ' text-blue-500 hover:text-blue-600'
            : $baseClasses . ' text-gray-500 hover:text-blue-600';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'data-active' => $active ? 'true' : 'false']) }}>
    {{ $slot }}
</a>
