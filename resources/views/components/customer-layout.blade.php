<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Casa Paraiso') }} - Customer</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-spa-cream text-spa-charcoal selection:bg-spa-leaf selection:text-white">
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Mobile Navigation Bar -->
            <div class="md:hidden bg-spa-charcoal text-spa-beige border-b border-spa-gray p-4 flex justify-between items-center z-50 sticky top-0">
                <div class="font-serif font-bold text-lg flex items-center gap-2 uppercase tracking-wider text-spa-white">
                    <svg class="w-6 h-6 text-spa-leaf" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2h-4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path></svg>
                    Casa Paraiso
                </div>
                <button id="mobile-menu-btn" class="p-1 hover:bg-[#1f2d28] rounded">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <div id="sidebar" class="w-full md:w-64 bg-spa-charcoal text-spa-beige hidden md:flex flex-col shadow-lg transition-all duration-300 z-40 fixed md:sticky top-0 h-screen overflow-y-auto border-r border-spa-gray">
                <div class="p-6 border-b border-spa-gray hidden md:block">
                    <h2 class="text-2xl font-serif font-bold tracking-wider text-spa-white uppercase">Casa Paraiso</h2>
                    <p class="text-xs text-spa-gold uppercase tracking-widest mt-1 font-semibold">Guest Portal</p>
                </div>

                <div class="p-4 border-b border-spa-gray">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-spa-gold flex items-center justify-center text-spa-charcoal font-bold text-sm border border-spa-wood shadow-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-spa-white truncate max-w-[130px]">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-spa-beige opacity-70 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 py-4 px-3 space-y-1">
                    @php
                        $links = [
                            ['name' => 'Dashboard', 'route' => 'customer.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            ['name' => 'Book Appointment', 'route' => 'customer.bookings.create', 'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
                            ['name' => 'My Appointments', 'route' => 'customer.bookings.index', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['name' => 'Services', 'route' => 'customer.services.index', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            ['name' => 'My Promotions', 'route' => 'customer.promotions.index', 'icon' => 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7'],
                            ['name' => 'Receipts', 'route' => 'customer.transactions.index', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['name' => 'My Reviews', 'route' => 'customer.reviews.index', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                        ];
                    @endphp

                    @foreach($links as $link)
                        @php $isActive = request()->routeIs($link['route'] === 'customer.bookings.index' ? 'customer.bookings.*' : ($link['route'] === 'customer.services.index' ? 'customer.services.*' : ($link['route'] === 'customer.transactions.index' ? 'customer.transactions.*' : $link['route']))); @endphp
                        
                        @if($link['route'] === 'customer.bookings.create')
                            @php $isActive = request()->routeIs('customer.bookings.create'); @endphp
                        @endif

                        <a href="{{ route($link['route']) }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors group {{ $isActive ? 'bg-spa-gray text-spa-white border-l-4 border-spa-gold' : 'text-spa-beige opacity-80 hover:bg-spa-gray hover:text-spa-white hover:opacity-100 border-l-4 border-transparent' }}">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ $isActive ? 'text-spa-gold' : 'text-spa-beige group-hover:text-spa-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"></path>
                            </svg>
                            {{ $link['name'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="p-4 border-t border-spa-gray">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-spa-beige opacity-80 rounded-md hover:bg-spa-gray hover:text-spa-white hover:opacity-100 transition-colors group">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 text-spa-beige group-hover:text-spa-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-spa-cream">
                <!-- Header -->
                @if (isset($header))
                    <header class="bg-spa-white shadow-sm border-b border-spa-beige z-10 hidden md:block">
                        <div class="px-6 py-4 flex justify-between items-center">
                            <h1 class="text-xl font-serif font-bold text-spa-charcoal tracking-tight">
                                {{ $header }}
                            </h1>
                            <div class="text-sm font-medium text-spa-gray opacity-70">
                                {{ now()->format('l, F j, Y') }}
                            </div>
                        </div>
                    </header>
                @endif

                <!-- Content -->
                <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
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

        <script>
            // Mobile menu toggle
            document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('hidden')) {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('flex');
                } else {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('flex');
                }
            });
        </script>
    </body>
</html>
