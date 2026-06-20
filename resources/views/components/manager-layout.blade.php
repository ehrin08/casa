<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Casa Paraiso') }} - Manager Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-spa-cream text-spa-charcoal selection:bg-spa-leaf selection:text-white" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-spa-charcoal text-spa-white transition-transform duration-300 ease-in-out md:static md:translate-x-0 shadow-lg flex flex-col border-r border-spa-gray">
                <div class="flex items-center justify-center h-20 border-b border-spa-gray px-4">
                    <svg class="w-6 h-6 text-spa-leaf mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2h-4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path></svg>
                    <span class="text-xl font-serif font-bold tracking-wider uppercase text-spa-white">Casa Paraiso</span>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    @php
                        $links = [
                            ['name' => 'Dashboard', 'route' => 'manager.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            ['name' => 'Analytics', 'route' => 'manager.analytics.index', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['name' => 'Appointments', 'route' => 'manager.bookings.index', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['name' => 'Services', 'route' => 'manager.services.index', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                            ['name' => 'Therapists', 'route' => 'manager.therapists.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                            ['name' => 'Therapist Availability', 'route' => 'manager.therapist-availabilities.index', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['name' => 'Transactions', 'route' => 'manager.transactions.index', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['name' => 'Commissions', 'route' => 'manager.commissions.index', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['name' => 'Promotions', 'route' => 'manager.promotions.index', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                            ['name' => 'Reviews', 'route' => 'manager.reviews.index', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
                        ];
                    @endphp
                    @foreach ($links as $link)
                        <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ Str::startsWith(request()->route()->getName(), Str::before($link['route'], '.index')) ? 'bg-spa-gray text-spa-white border-l-4 border-spa-gold' : 'hover:bg-spa-gray text-spa-beige opacity-80 hover:opacity-100 hover:text-spa-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"></path>
                            </svg>
                            <span class="font-medium">{{ $link['name'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </aside>

            <!-- Overlay for mobile sidebar -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 md:hidden" style="display: none;"></div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Top Navbar -->
                <header class="bg-spa-white shadow-sm border-b border-spa-beige flex items-center justify-between h-20 px-6 lg:px-8">
                    <!-- Mobile menu button -->
                    <button @click="sidebarOpen = true" class="md:hidden text-spa-gray hover:text-spa-charcoal focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="flex-1">
                        @if (isset($header))
                            <h1 class="text-2xl font-serif font-bold text-spa-charcoal">{{ $header }}</h1>
                        @endif
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <div class="hidden sm:block text-right">
                            <div class="text-sm font-bold text-spa-charcoal">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-spa-gray opacity-70 uppercase tracking-wide">{{ auth()->user()->role }}</div>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-spa-gold flex items-center justify-center text-spa-charcoal font-bold shadow-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}" class="ml-4">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-spa-gray hover:text-spa-brown transition-colors flex items-center">
                                <svg class="w-5 h-5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-spa-cream p-6 lg:p-8">
                    @if (session('success'))
                        <x-ui.alert type="success" :message="session('success')" />
                    @endif
                    @if (session('error'))
                        <x-ui.alert type="error" :message="session('error')" />
                    @endif
                    @if (session('warning'))
                        <x-ui.alert type="warning" :message="session('warning')" />
                    @endif
                    @if (session('info'))
                        <x-ui.alert type="info" :message="session('info')" />
                    @endif
                    
                    {{ $slot }}
                </main>
            </div>
        </div>
        @livewireScripts
    </body>
</html>
