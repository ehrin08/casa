@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-spa-charcoal']) }}>
    {{ $value ?? $slot }}
</label>
