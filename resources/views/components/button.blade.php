@props(['variant' => 'primary', 'type' => 'submit'])
@php
    $classes = match($variant) {
        'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
        'secondary' => 'bg-zinc-100 text-zinc-800 hover:bg-zinc-200 focus:ring-zinc-400',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        default => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
    };
@endphp
<button type="{{ $type }}"
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 ' . $classes]) }}>
    {{ $slot }}
</button>
