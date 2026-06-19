@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-spa-beige bg-spa-white text-spa-charcoal focus:border-spa-wood focus:ring-spa-wood rounded-md shadow-sm']) }}>
