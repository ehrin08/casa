@props(['status'])

@php
    $statusLower = strtolower($status);
    $classes = match($statusLower) {
        'available', 'paid', 'completed', 'active' => 'bg-green-100 text-green-800',
        'unavailable', 'cancelled', 'voided', 'inactive' => 'bg-red-100 text-red-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
        'refunded' => 'bg-orange-100 text-orange-800',
        'draft', 'hidden' => 'bg-gray-100 text-gray-800',
        default => 'bg-blue-100 text-blue-800'
    };
@endphp

<span {{ $attributes->merge(['class' => "px-2.5 py-0.5 inline-flex items-center text-xs leading-5 font-medium rounded-full $classes"]) }}>
    {{ ucfirst($status) }}
</span>
