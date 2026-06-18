<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Casa Paraiso') }} - Customer</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#fdfcfaf8]">
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Mobile Navigation Bar -->
            <div class="md:hidden bg-[#2c3e38] text-[#e8dbce] p-4 flex justify-between items-center z-50 sticky top-0">
                <div class="font-semibold text-lg flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    Casa Paraiso
                </div>
                <button id="mobile-menu-btn" class="p-1 hover:bg-[#1f2d28] rounded">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <div id="sidebar" class="w-full md:w-64 bg-[#2c3e38] text-[#e8dbce] hidden md:flex flex-col shadow-lg transition-all duration-300 z-40 fixed md:sticky top-0 h-screen overflow-y-auto">
                <div class="p-6 border-b border-[#3d524a] hidden md:block">
                    <h2 class="text-2xl font-bold tracking-wider text-white">Casa Paraiso</h2>
                    <p class="text-xs text-[#a0afaa] uppercase tracking-widest mt-1">Guest Portal</p>
                </div>

                <div class="p-4 border-b border-[#3d524a]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#1f2d28] flex items-center justify-center text-white font-bold text-sm border border-[#3d524a]">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white truncate max-w-[130px]">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-[#a0afaa] capitalize">{{ auth()->user()->role }}</p>
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
                        ];
                    @endphp

                    @foreach($links as $link)
                        @php $isActive = request()->routeIs($link['route'] === 'customer.bookings.index' ? 'customer.bookings.*' : ($link['route'] === 'customer.services.index' ? 'customer.services.*' : ($link['route'] === 'customer.transactions.index' ? 'customer.transactions.*' : $link['route']))); @endphp
                        
                        @if($link['route'] === 'customer.bookings.create')
                            @php $isActive = request()->routeIs('customer.bookings.create'); @endphp
                        @endif

                        <a href="{{ route($link['route']) }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors group {{ $isActive ? 'bg-[#1f2d28] text-white border-l-4 border-[#e8dbce]' : 'text-[#c2cfca] hover:bg-[#3d524a] hover:text-white border-l-4 border-transparent' }}">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ $isActive ? 'text-[#e8dbce]' : 'text-[#a0afaa] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"></path>
                            </svg>
                            {{ $link['name'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="p-4 border-t border-[#3d524a]">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-[#c2cfca] rounded-md hover:bg-[#3d524a] hover:text-white transition-colors group">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 text-[#a0afaa] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#fdfcfaf8]">
                <!-- Header -->
                @if (isset($header))
                    <header class="bg-white shadow-sm border-b border-gray-100 z-10 hidden md:block">
                        <div class="px-6 py-4 flex justify-between items-center">
                            <h1 class="text-xl font-semibold text-gray-800 tracking-tight">
                                {{ $header }}
                            </h1>
                            <div class="text-sm text-gray-500">
                                {{ now()->format('l, F j, Y') }}
                            </div>
                        </div>
                    </header>
                @endif

                <!-- Content -->
                <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
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
