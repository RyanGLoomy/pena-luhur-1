@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => '
        w-full
        px-4 py-3
        text-base
        text-gray-800
        bg-white
        border border-gray-300
        rounded-lg
        shadow-sm
        transition duration-150 ease-in-out
        focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50
    '
]) !!}>
