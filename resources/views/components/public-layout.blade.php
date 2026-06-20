<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Casa Paraiso') }} - Body and Wellness Spa</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-spa-cream text-spa-charcoal selection:bg-spa-leaf selection:text-white">
    <!-- Header / Navigation -->
    <header x-data="{ mobileMenuOpen: false }" class="bg-spa-white border-b border-spa-beige sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Top">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <svg class="w-8 h-8 text-spa-leaf" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2h-4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path></svg>
                        <span class="text-xl font-serif font-bold text-spa-espresso tracking-tight">Casa Paraiso</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/#services') }}" class="text-sm font-medium text-spa-gray hover:text-spa-brown transition-colors">Services</a>
                    <a href="{{ url('/#how-it-works') }}" class="text-sm font-medium text-spa-gray hover:text-spa-brown transition-colors">How It Works</a>
                    <a href="{{ url('/#promotions') }}" class="text-sm font-medium text-spa-gray hover:text-spa-brown transition-colors">Promotions</a>
                    <a href="{{ url('/#reviews') }}" class="text-sm font-medium text-spa-gray hover:text-spa-brown transition-colors">Reviews</a>
                    <a href="{{ url('/#contact') }}" class="text-sm font-medium text-spa-gray hover:text-spa-brown transition-colors">Contact</a>
                </div>

                <!-- Auth Links -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        @php
                            $dashboardUrl = url('/customer/dashboard'); // default
                            if (auth()->user()->role === 'manager') $dashboardUrl = url('/manager/dashboard');
                            if (auth()->user()->role === 'therapist') $dashboardUrl = url('/therapist/dashboard');
                        @endphp
                        <a href="{{ $dashboardUrl }}" class="text-sm font-semibold text-spa-brown hover:text-spa-espresso transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-spa-gray hover:text-spa-brown transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-spa-white bg-spa-brown hover:bg-spa-espresso focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-spa-brown transition-colors">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="bg-spa-white rounded-md p-2 inline-flex items-center justify-center text-spa-gray hover:text-spa-brown hover:bg-spa-cream focus:outline-none focus:ring-2 focus:ring-inset focus:ring-spa-brown" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6" x-show="mobileMenuOpen" style="display:none;" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" style="display:none;" class="md:hidden bg-spa-white border-t border-spa-beige" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ url('/#services') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-spa-gray hover:text-spa-brown hover:bg-spa-cream">Services</a>
                <a href="{{ url('/#how-it-works') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-spa-gray hover:text-spa-brown hover:bg-spa-cream">How It Works</a>
                <a href="{{ url('/#promotions') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-spa-gray hover:text-spa-brown hover:bg-spa-cream">Promotions</a>
                <a href="{{ url('/#reviews') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-spa-gray hover:text-spa-brown hover:bg-spa-cream">Reviews</a>
                <a href="{{ url('/#contact') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-spa-gray hover:text-spa-brown hover:bg-spa-cream">Contact</a>
            </div>
            <div class="pt-4 pb-4 border-t border-spa-beige">
                <div class="flex items-center px-5 space-x-4">
                    @auth
                        @php
                            $dashboardUrl = url('/customer/dashboard'); // default
                            if (auth()->user()->role === 'manager') $dashboardUrl = url('/manager/dashboard');
                            if (auth()->user()->role === 'therapist') $dashboardUrl = url('/therapist/dashboard');
                        @endphp
                        <a href="{{ $dashboardUrl }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-spa-white bg-spa-brown hover:bg-spa-espresso">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-1/2 text-center px-4 py-2 border border-spa-beige rounded-md shadow-sm text-base font-medium text-spa-gray bg-spa-white hover:bg-spa-cream">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block w-1/2 text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-spa-white bg-spa-brown hover:bg-spa-espresso">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-spa-charcoal text-spa-beige py-12 border-t-4 border-spa-wood">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-8 h-8 text-spa-leaf" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2h-4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path></svg>
                        <span class="text-xl font-serif font-bold text-spa-white tracking-tight">Casa Paraiso</span>
                    </div>
                    <p class="text-sm text-spa-beige opacity-80 mb-4 max-w-sm">
                        Body and Wellness Spa. A web-based spa appointment and service management system designed for smoother bookings, organized schedules, and better customer experience.
                    </p>
                    <p class="text-xs text-gray-500">
                        * Note: This is a capstone project demo.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#services" class="hover:text-white transition-colors">Services</a></li>
                        <li><a href="#how-it-works" class="hover:text-white transition-colors">How It Works</a></li>
                        <li><a href="#promotions" class="hover:text-white transition-colors">Promotions</a></li>
                        <li><a href="#reviews" class="hover:text-white transition-colors">Reviews</a></li>
                        @guest
                            <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a></li>
                        @endguest
                    </ul>
                </div>

                <!-- Contact -->
                <div id="contact">
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Sta. Teresita, Alitagtag, Batangas</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>[Contact number placeholder]</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>[Operating hours placeholder]</span>
                        </li>
                    </ul>
                    <div class="mt-4 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-spa-gray text-sm text-spa-beige opacity-70 text-center flex flex-col md:flex-row justify-between items-center gap-4">
                <p>&copy; {{ date('Y') }} Casa Paraiso. All rights reserved.</p>
                <p>Designed for smoother bookings and better customer experience.</p>
            </div>
        </div>
    </footer>
    @livewireScripts
    </body>
</html>
