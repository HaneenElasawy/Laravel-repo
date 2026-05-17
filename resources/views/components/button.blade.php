@props(['type' => 'primary'])

@php
    $colors = [
        'primary' => 'background:#0d6efd; color:white;',
        'secondary' => 'background:#6c757d; color:white;',
        'danger' => 'background:#dc3545; color:white;',
        'success' => 'background:#198754; color:white;',
    ];

    $style = $colors[$type] ?? $colors['primary'];
@endphp

<button {{ $attributes }} style="{{ $style }} border:0; padding:6px 10px; border-radius:4px; cursor:pointer;">
    {{ $slot }}
</button>
