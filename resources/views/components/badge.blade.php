@props([
    'color' => 'amber',
])

@php
    $classes = match ($color) {
        'green' => 'bg-green-500/20 text-green-300 ring-1 ring-green-400/30 hover:bg-green-500/30',
        default => 'bg-amber-500/20 text-amber-300 ring-1 ring-amber-400/30 hover:bg-amber-500/30',
    };

    $tag = $attributes->has('type') ? 'button' : 'span';
@endphp

<{{ $tag }}
    {{ $attributes->class(['rounded-full px-3 py-1 text-xs font-medium transition', $classes]) }}
>
    {{ $slot }}
</{{ $tag }}>
