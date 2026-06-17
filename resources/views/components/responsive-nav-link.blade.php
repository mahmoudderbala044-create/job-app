@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-400 bg-zinc-900 focus:outline-none focus:text-indigo-300 focus:bg-zinc-800 focus:border-indigo-300 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-zinc-400 hover:text-white hover:bg-zinc-800 hover:border-zinc-700 focus:outline-none focus:text-white focus:bg-zinc-800 focus:border-zinc-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
