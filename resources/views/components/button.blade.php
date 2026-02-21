@props([
    'variant' => 'default',
    'href' => null,
])

@php
    $classes = match ($variant) {
        'primary' => 'rounded-full bg-amber-400 px-5 py-2 text-sm font-medium text-gray-900 transition hover:bg-amber-300',
        'danger' => 'rounded-full bg-red-500/20 px-4 py-1.5 text-sm font-medium text-red-300 ring-1 ring-red-400/30 transition hover:bg-red-500/30',
        default => 'rounded-full bg-white/10 px-4 py-1.5 text-sm font-medium text-white/70 ring-1 ring-white/20 transition hover:bg-white/20 hover:text-white',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class($classes) }}>
        {{ $slot }}
    </button>
@endif
