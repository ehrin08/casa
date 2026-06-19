<x-modal name="auth-prompt" maxWidth="md">
    <div class="p-8 text-center bg-spa-cream rounded-xl">
        <div class="w-16 h-16 bg-[#2c3e38] text-spa-gold rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
        </div>
        <h2 class="text-2xl font-serif font-bold text-spa-charcoal mb-2">Welcome to Casa Paraiso</h2>
        <p class="text-spa-gray opacity-80 mb-8 text-sm leading-relaxed">
            Please log in or register an account to book your wellness journey and access personalized promotions.
        </p>
        <div class="space-y-4">
            <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#2c3e38] hover:bg-[#1f2d28] transition-colors shadow-sm">
                Log In
            </a>
            <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-6 py-3 border border-spa-wood text-base font-medium rounded-md text-spa-charcoal hover:bg-spa-beige transition-colors bg-white shadow-sm">
                Create an Account
            </a>
        </div>
        <button type="button" x-on:click="$dispatch('close-modal', 'auth-prompt')" class="mt-6 text-sm text-spa-gray opacity-60 hover:text-spa-charcoal transition-colors underline">
            Continue as Guest
        </button>
    </div>
</x-modal>
