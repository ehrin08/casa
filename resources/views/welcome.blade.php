<x-public-layout>
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-16 sm:pt-24 lg:pt-32 px-4 sm:px-6 lg:px-8">
                <main class="mx-auto max-w-7xl">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Relax, Book, and</span>
                            <span class="block text-[#2c3e38]">Rejuvenate</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            A web-based spa appointment and service management system designed for smoother bookings, organized schedules, and a better customer experience at Casa Paraiso.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                @auth
                                    @php
                                        $bookingUrl = route('customer.bookings.create'); // default for customer
                                        if(auth()->user()->role === 'manager') $bookingUrl = route('manager.dashboard');
                                        if(auth()->user()->role === 'therapist') $bookingUrl = route('therapist.dashboard');
                                    @endphp
                                    <a href="{{ $bookingUrl }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#2c3e38] hover:bg-[#1f2d28] md:py-4 md:text-lg md:px-10 transition-colors">
                                        {{ auth()->user()->role === 'customer' ? 'Book Appointment' : 'Go to Dashboard' }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#2c3e38] hover:bg-[#1f2d28] md:py-4 md:text-lg md:px-10 transition-colors">
                                        Book Appointment
                                    </a>
                                @endauth
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#services" class="w-full flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 transition-colors">
                                    View Services
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- Decorative background elements -->
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-[#f0f4f2] hidden lg:flex items-center justify-center rounded-l-[100px] overflow-hidden shadow-inner">
            <!-- Simulated spa image/pattern using CSS shapes since we don't have images -->
            <div class="relative w-full h-full flex items-center justify-center opacity-50">
                <svg class="absolute w-96 h-96 text-[#2c3e38] opacity-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-2-5.5h4v-1h-4v1zm0-3h4v-1h-4v1zm0-3h4v-1h-4v1z"></path></svg>
                <div class="grid grid-cols-2 gap-4">
                    <div class="w-32 h-48 bg-[#2c3e38] opacity-20 rounded-t-full rounded-bl-full"></div>
                    <div class="w-32 h-64 bg-[#e8dbce] opacity-40 rounded-b-full rounded-tr-full mt-12"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Services Section -->
    <div id="services" class="py-16 bg-[#fdfcfb]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-[#2c3e38] font-semibold tracking-wide uppercase">Pamper Yourself</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Featured Services</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Explore our range of wellness treatments tailored for your relaxation.</p>
            </div>

            <div class="mt-12">
                @if(isset($services) && $services->count() > 0)
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($services as $service)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                                <div class="p-6 flex-1">
                                    <div class="flex justify-between items-start mb-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#f0f4f2] text-[#2c3e38] capitalize">
                                            {{ str_replace('_', ' ', $service->category) }}
                                        </span>
                                        <span class="text-sm font-semibold text-gray-500">{{ $service->duration_minutes }} mins</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $service->name }}</h3>
                                    <p class="text-gray-500 text-sm mb-4 line-clamp-3">{{ $service->description }}</p>
                                    <div class="mt-auto">
                                        <span class="text-2xl font-bold text-[#2c3e38]">₱{{ number_format($service->price, 2) }}</span>
                                    </div>
                                </div>
                                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50">
                                    @auth
                                        @if(auth()->user()->role === 'customer')
                                            <a href="{{ route('customer.bookings.create', ['service_id' => $service->id]) }}" class="text-sm font-medium text-[#2c3e38] hover:text-[#1f2d28] flex items-center">
                                                Book Soon <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        @else
                                            <a href="{{ url('/') }}" class="text-sm font-medium text-gray-500 flex items-center">View Details</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="text-sm font-medium text-[#2c3e38] hover:text-[#1f2d28] flex items-center">
                                            Log in to Book <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center bg-white p-12 rounded-xl border border-gray-100 shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        <h3 class="text-lg font-medium text-gray-900">Services coming soon</h3>
                        <p class="mt-2 text-sm text-gray-500">We are currently updating our spa menu. Please check back later.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div id="how-it-works" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">How It Works</h2>
                <p class="mt-4 text-lg text-gray-500">Simple steps to schedule your relaxation time.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div class="relative">
                    <div class="w-16 h-16 mx-auto bg-[#f0f4f2] text-[#2c3e38] rounded-full flex items-center justify-center text-xl font-bold mb-4 shadow-sm z-10 relative">1</div>
                    <div class="hidden md:block absolute top-8 left-1/2 w-full h-0.5 bg-gray-100 -z-10"></div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Create Account</h3>
                    <p class="text-sm text-gray-500">Register or log in to securely access our booking system.</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 mx-auto bg-[#f0f4f2] text-[#2c3e38] rounded-full flex items-center justify-center text-xl font-bold mb-4 shadow-sm z-10 relative">2</div>
                    <div class="hidden md:block absolute top-8 left-1/2 w-full h-0.5 bg-gray-100 -z-10"></div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Choose Service</h3>
                    <p class="text-sm text-gray-500">Browse our menu and select your preferred spa service.</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 mx-auto bg-[#f0f4f2] text-[#2c3e38] rounded-full flex items-center justify-center text-xl font-bold mb-4 shadow-sm z-10 relative">3</div>
                    <div class="hidden md:block absolute top-8 left-1/2 w-full h-0.5 bg-gray-100 -z-10"></div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Select Schedule</h3>
                    <p class="text-sm text-gray-500">Pick a convenient date, time, and available therapist.</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 mx-auto bg-[#f0f4f2] text-[#2c3e38] rounded-full flex items-center justify-center text-xl font-bold mb-4 shadow-sm z-10 relative">4</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm & Visit</h3>
                    <p class="text-sm text-gray-500">Confirm booking online and pay over-the-counter during your visit.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="py-16 bg-[#2c3e38] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-white">Why Choose Casa Paraiso?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-[#1f2d28] p-6 rounded-xl border border-gray-700">
                    <svg class="w-8 h-8 text-[#e8dbce] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h3 class="text-lg font-bold mb-2">Easy Online Booking</h3>
                    <p class="text-gray-400 text-sm">Schedule your appointments seamlessly from anywhere, at any time.</p>
                </div>
                <div class="bg-[#1f2d28] p-6 rounded-xl border border-gray-700">
                    <svg class="w-8 h-8 text-[#e8dbce] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-lg font-bold mb-2">Real-time Availability</h3>
                    <p class="text-gray-400 text-sm">Check real-time therapist schedules to find the perfect slot for you.</p>
                </div>
                <div class="bg-[#1f2d28] p-6 rounded-xl border border-gray-700">
                    <svg class="w-8 h-8 text-[#e8dbce] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-lg font-bold mb-2">Personalized Promotions</h3>
                    <p class="text-gray-400 text-sm">Enjoy tailored discounts based on your visit history and loyalty.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotions Preview Section -->
    <div id="promotions" class="py-16 bg-[#fdfcfb]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Latest Promotions</h2>
                    <p class="mt-2 text-lg text-gray-500">Discover ways to save on your wellness journey.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('customer.promotions.index') }}" class="text-[#2c3e38] font-medium hover:underline flex items-center">
                                View My Promos <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-[#2c3e38] font-medium hover:underline flex items-center">
                            Log in to see your promos <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    @endauth
                </div>
            </div>

            @if(isset($promotions) && $promotions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($promotions as $promo)
                        <div class="bg-gradient-to-br from-[#2c3e38] to-[#1f2d28] rounded-xl shadow-md p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10"></div>
                            <h3 class="text-xl font-bold mb-2">{{ $promo->name }}</h3>
                            <div class="text-3xl font-extrabold text-[#e8dbce] mb-4">
                                @if($promo->discount_type === 'percentage')
                                    {{ $promo->discount_value }}% OFF
                                @elseif($promo->discount_type === 'fixed')
                                    ₱{{ number_format($promo->discount_value, 2) }} OFF
                                @else
                                    Free Service
                                @endif
                            </div>
                            <p class="text-sm text-gray-300 mb-4">{{ $promo->description ?? 'Available for active customers.' }}</p>
                            <div class="text-xs text-gray-400 bg-black bg-opacity-20 inline-block px-3 py-1 rounded-full">
                                @if($promo->valid_until)
                                    Valid until {{ \Carbon\Carbon::parse($promo->valid_until)->format('M d, Y') }}
                                @else
                                    Ongoing Promotion
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl border border-gray-100 p-8 text-center shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                    <p class="text-gray-500">More promotions coming soon. Register an account to receive personalized discounts!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Reviews Preview Section -->
    <div id="reviews" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">What Our Customers Say</h2>
                <p class="mt-4 text-lg text-gray-500">Verified feedback from completed appointments.</p>
            </div>

            @if(isset($reviews) && $reviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($reviews as $review)
                        <div class="bg-[#f0f4f2] p-6 rounded-xl border border-gray-100 relative">
                            <div class="absolute -top-4 left-6 bg-white rounded-full p-2 shadow-sm">
                                <svg class="w-6 h-6 text-[#2c3e38]" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                            </div>
                            <div class="mt-4 flex items-center space-x-1 mb-4 text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-gray-700 italic mb-6">"{{ $review->key_snippet ?: $review->comment }}"</p>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <div>
                                    @php
                                        // Use generic name to preserve privacy
                                        $firstName = explode(' ', $review->customer->name)[0] ?? 'Verified';
                                    @endphp
                                    <p class="text-sm font-semibold text-gray-900">{{ $firstName }} M.</p>
                                    <p class="text-xs text-gray-500">{{ $review->service->name }}</p>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Verified Visit
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center bg-[#f0f4f2] p-10 rounded-xl border border-gray-100">
                    <p class="text-gray-500">Customer reviews will appear here after completed appointments.</p>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
