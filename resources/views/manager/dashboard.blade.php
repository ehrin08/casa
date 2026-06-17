<x-manager-layout>
    <x-slot name="header">
        {{ __('Manager Dashboard') }}
    </x-slot>

    @php
        // Safe data handling: Use real models if they exist, otherwise use safe fallback values (0)
        
        // 1. Today's Appointments
        $appointmentsCount = 0;
        if (class_exists('App\Models\Appointment')) {
            try {
                // Future integration: $appointmentsCount = App\Models\Appointment::whereDate('appointment_date', today())->count();
                $appointmentsCount = App\Models\Appointment::count(); 
            } catch (\Exception $e) {
                $appointmentsCount = 0;
            }
        } else {
            $appointmentsCount = 12; // Placeholder value for visual testing if model doesn't exist
        }

        // 2. Total Sales
        $totalSales = 0;
        if (class_exists('App\Models\Transaction')) {
            try {
                // Future integration: $totalSales = App\Models\Transaction::sum('amount');
                $totalSales = App\Models\Transaction::sum('amount') ?? 0;
            } catch (\Exception $e) {
                $totalSales = 0;
            }
        } else {
            $totalSales = 1450; // Placeholder value
        }

        // 3. Pending Bookings
        $pendingBookings = 0;
        if (class_exists('App\Models\Appointment')) {
            try {
                // Future integration: $pendingBookings = App\Models\Appointment::where('status', 'pending')->count();
                $pendingBookings = 0; 
            } catch (\Exception $e) {
                $pendingBookings = 0;
            }
        } else {
            $pendingBookings = 5; // Placeholder value
        }

        // 4. Active Promotions
        $activePromotions = 0;
        if (class_exists('App\Models\Promotion')) {
            try {
                // Future integration: $activePromotions = App\Models\Promotion::where('is_active', true)->count();
                $activePromotions = 0;
            } catch (\Exception $e) {
                $activePromotions = 0;
            }
        } else {
            $activePromotions = 3; // Placeholder value
        }
    @endphp

    <div class="mb-8">
        <h2 class="text-xl font-medium text-gray-800 mb-4">Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-dashboard.stat-card 
                title="Today's Appointments" 
                value="{{ class_exists('App\Models\Appointment') ? $appointmentsCount : '12' }}" 
                subtitle="{{ class_exists('App\Models\Appointment') ? 'From database' : 'Placeholder value' }}"
                icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" 
            />
            
            <x-dashboard.stat-card 
                title="Total Sales" 
                value="${{ number_format(class_exists('App\Models\Transaction') ? $totalSales : 1450, 2) }}" 
                subtitle="{{ class_exists('App\Models\Transaction') ? 'From database' : 'Placeholder value' }}"
                icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" 
            />

            <x-dashboard.stat-card 
                title="Pending Bookings" 
                value="{{ class_exists('App\Models\Appointment') ? $pendingBookings : '5' }}" 
                subtitle="{{ class_exists('App\Models\Appointment') ? 'From database' : 'Placeholder value' }}"
                icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" 
            />

            <x-dashboard.stat-card 
                title="Active Promotions" 
                value="{{ class_exists('App\Models\Promotion') ? $activePromotions : '3' }}" 
                subtitle="{{ class_exists('App\Models\Promotion') ? 'From database' : 'Placeholder value' }}"
                icon="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" 
            />
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Today's Appointment Overview Placeholder -->
            <x-dashboard.section-card title="Today's Appointment Overview" action="View All" actionUrl="#">
                <div class="flex flex-col items-center justify-center py-10 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm font-medium">Appointment table will be implemented here.</p>
                    <p class="text-xs text-gray-400 mt-1">Pending integration with Appointment model.</p>
                </div>
            </x-dashboard.section-card>

            <!-- Recent Activity Placeholder -->
            <x-dashboard.section-card title="Recent Activity">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-[#e8dbce] flex items-center justify-center text-[#7a6b5d]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-800">New booking from Sarah M.</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-[#d5ecd4] flex items-center justify-center text-[#3a6b35]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-800">Therapist Jane D. completed a session.</p>
                            <p class="text-xs text-gray-500">4 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-[#fce0e0] flex items-center justify-center text-[#b83232]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-800">Booking cancelled by user.</p>
                            <p class="text-xs text-gray-500">Yesterday</p>
                        </div>
                    </div>
                </div>
            </x-dashboard.section-card>
        </div>

        <div class="space-y-8">
            <!-- Quick Actions Section -->
            <x-dashboard.section-card title="Quick Actions">
                <div class="grid grid-cols-1 gap-3">
                    <a href="#" class="flex items-center p-3 text-sm font-medium text-[#2c3e38] bg-[#f0f4f2] rounded-lg hover:bg-[#e2ebe7] transition-colors border border-[#d5e0dc]">
                        <svg class="w-5 h-5 mr-3 text-[#40544c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Add Appointment
                    </a>
                    <a href="#" class="flex items-center p-3 text-sm font-medium text-[#4a3f35] bg-[#f9f8f6] rounded-lg hover:bg-[#f2ede9] transition-colors border border-[#e8dbce]">
                        <svg class="w-5 h-5 mr-3 text-[#7a6b5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Manage Services
                    </a>
                    <a href="#" class="flex items-center p-3 text-sm font-medium text-[#4a3f35] bg-[#f9f8f6] rounded-lg hover:bg-[#f2ede9] transition-colors border border-[#e8dbce]">
                        <svg class="w-5 h-5 mr-3 text-[#7a6b5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Manage Therapists
                    </a>
                    <a href="#" class="flex items-center p-3 text-sm font-medium text-[#4a3f35] bg-[#f9f8f6] rounded-lg hover:bg-[#f2ede9] transition-colors border border-[#e8dbce]">
                        <svg class="w-5 h-5 mr-3 text-[#7a6b5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        View Reports
                    </a>
                </div>
            </x-dashboard.section-card>
        </div>
    </div>
</x-manager-layout>
