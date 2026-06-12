@props([
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $classes = match($variant) {
        'primary' => 'background: #2563eb; color: white;',
        'danger' => 'background: #dc2626; color: white;',
        'secondary' => 'background: #e5e7eb; color: #1f2937;',
        default => 'background: #2563eb; color: white;',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['style' => "padding: 8px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; {$classes}"]) }}
>
    {{ $slot }}
</button>
