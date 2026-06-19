<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center px-4 py-2 bg-spa-brown border border-transparent rounded-md font-semibold text-xs text-spa-white uppercase tracking-widest hover:bg-spa-espresso focus:bg-spa-espresso active:bg-spa-charcoal focus:outline-none focus:ring-2 focus:ring-spa-gold focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
