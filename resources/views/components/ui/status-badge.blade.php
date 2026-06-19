@props(['status'])

@php
    $statusLower = strtolower($status);
    $classes = match($statusLower) {
        'available', 'paid', 'completed', 'active' => 'bg-spa-leaf bg-opacity-10 text-spa-leaf font-bold tracking-wider',
        'unavailable', 'cancelled', 'voided', 'inactive' => 'bg-red-100 text-red-800 font-bold tracking-wider',
        'pending' => 'bg-spa-gold bg-opacity-20 text-spa-brown font-bold tracking-wider',
        'refunded' => 'bg-orange-100 text-orange-800 font-bold tracking-wider',
        'draft', 'hidden' => 'bg-spa-gray bg-opacity-10 text-spa-charcoal font-bold tracking-wider',
        default => 'bg-spa-beige text-spa-charcoal font-bold tracking-wider'
    };
@endphp

<span {{ $attributes->merge(['class' => "px-2.5 py-0.5 inline-flex items-center text-xs leading-5 font-medium rounded-full $classes"]) }}>
    {{ ucfirst($status) }}
</span>
