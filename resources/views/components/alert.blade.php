@props([
    'type' => 'info',
])

@php
    $colors = match($type) {
        'success' => 'background: #dcfce7; color: #166534; border-left: 4px solid #16a34a;',
        'error' => 'background: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626;',
        'warning' => 'background: #fef3c7; color: #92400e; border-left: 4px solid #d97706;',
        default => 'background: #dbeafe; color: #1e3a8a; border-left: 4px solid #2563eb;',
    };
@endphp

<div {{ $attributes->merge(['style' => "padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; {$colors}"]) }}>
    @if (isset($title))
        <strong style="display: block; margin-bottom: 4px;">{{ $title }}</strong>
    @endif
    {{ $slot }}
</div>
