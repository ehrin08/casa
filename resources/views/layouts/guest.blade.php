<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-spa-charcoal antialiased selection:bg-spa-leaf selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-spa-cream relative overflow-hidden">
            <!-- Decorative background elements -->
            <div class="absolute inset-0 opacity-5 bg-[radial-gradient(circle_at_center,_var(--tw-colors-spa-gold)_1px,_transparent_1px)]" style="background-size: 24px 24px;"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                <a href="/" wire:navigate class="flex flex-col items-center gap-3 group">
                    <div class="w-16 h-16 bg-spa-charcoal rounded-full flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-8 h-8 text-spa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2h-4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path></svg>
                    </div>
                    <span class="text-2xl font-serif font-bold text-spa-charcoal uppercase tracking-widest">Casa Paraiso</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-spa-white shadow-xl border border-spa-beige overflow-hidden sm:rounded-2xl relative z-10">
                {{ $slot }}
            </div>
        </div>
        @livewireScripts
    </body>
</html>
