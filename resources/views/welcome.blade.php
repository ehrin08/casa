<x-public-layout>
    <!-- Hero Section -->
    <div class="relative bg-spa-charcoal overflow-hidden">
        <!-- Background Gradient/Texture -->
        <div class="absolute inset-0 bg-gradient-to-br from-spa-charcoal via-spa-gray to-spa-charcoal z-0"></div>
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-spa-gold via-transparent to-transparent z-0"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-16 sm:pt-24 lg:pt-32 px-4 sm:px-6 lg:px-8">
                <main class="mx-auto max-w-7xl">
                    <div class="sm:text-center lg:text-left">
                        <div class="flex items-center justify-center lg:justify-start gap-2 mb-4">
                            <svg class="w-6 h-6 text-spa-leaf" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2h-4c-1.25 0-2 .782-2 2v10c0 4 0 6 1 6z"></path></svg>
                            <span class="text-sm uppercase tracking-widest text-spa-gold font-medium">Body and Wellness Spa</span>
                        </div>
                        <h1 class="text-4xl tracking-tight font-serif font-extrabold text-spa-white sm:text-5xl md:text-6xl">
                            <span class="block text-spa-beige">Casa Paraiso</span>
                        </h1>
                        <p class="mt-3 text-base text-spa-cream opacity-80 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 font-light">
                            Reserve your spot. You deserve this. Experience modern elegance, natural wellness, and a relaxing spa environment tailored just for you.
                        </p>
                        <div class="mt-8 sm:flex sm:justify-center lg:justify-start gap-4">
                            @auth
                                @php
                                    $bookingUrl = route('customer.bookings.create'); // default for customer
                                    if(auth()->user()->role === 'manager') $bookingUrl = route('manager.dashboard');
                                    if(auth()->user()->role === 'therapist') $bookingUrl = route('therapist.dashboard');
                                @endphp
                                <a href="{{ $bookingUrl }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-spa-white bg-spa-brown hover:bg-spa-espresso md:py-4 md:text-lg md:px-10 transition-colors shadow-lg">
                                    {{ auth()->user()->role === 'customer' ? 'Book Appointment' : 'Go to Dashboard' }}
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-spa-white bg-spa-brown hover:bg-spa-espresso md:py-4 md:text-lg md:px-10 transition-colors shadow-lg">
                                    Book Appointment
                                </a>
                            @endauth
                            <div class="mt-3 sm:mt-0">
                                <a href="#services" class="w-full flex items-center justify-center px-8 py-3 border border-spa-wood text-base font-medium rounded-md text-spa-beige hover:bg-spa-gray hover:text-spa-white md:py-4 md:text-lg md:px-10 transition-colors">
                                    View Services
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- Decorative background elements -->
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-spa-gray hidden lg:flex items-center justify-center rounded-l-full overflow-hidden shadow-inner border-l-4 border-spa-wood">
            <!-- Simulated spa image/pattern using CSS shapes since we don't have images -->
            <div class="relative w-full h-full flex items-center justify-center opacity-40">
                <svg class="absolute w-[500px] h-[500px] text-spa-leaf opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-2-5.5h4v-1h-4v1zm0-3h4v-1h-4v1zm0-3h4v-1h-4v1z"></path></svg>
                <div class="grid grid-cols-2 gap-8">
                    <div class="w-40 h-64 bg-spa-wood opacity-30 rounded-t-full rounded-bl-full shadow-2xl"></div>
                    <div class="w-40 h-80 bg-spa-brown opacity-40 rounded-b-full rounded-tr-full mt-16 shadow-2xl"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Services Section -->
    <div id="services" class="py-20 bg-spa-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-sm text-spa-leaf font-bold tracking-widest uppercase">Pamper Yourself</h2>
                <p class="mt-2 text-3xl font-serif leading-8 font-extrabold tracking-tight text-spa-espresso sm:text-4xl">Featured Services</p>
                <div class="w-24 h-1 bg-spa-gold mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="mt-16">
                @if(isset($services) && $services->count() > 0)
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($services as $service)
                            <div class="bg-spa-white rounded-2xl shadow-sm border border-spa-beige overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col group">
                                <div class="h-2 bg-spa-wood group-hover:bg-spa-brown transition-colors"></div>
                                <div class="p-8 flex-1">
                                    <div class="flex justify-between items-start mb-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-spa-beige text-spa-espresso capitalize">
                                            {{ str_replace('_', ' ', $service->category) }}
                                        </span>
                                        <span class="text-sm font-medium text-spa-gray opacity-70">{{ $service->duration_minutes }} mins</span>
                                    </div>
                                    <h3 class="text-2xl font-serif font-bold text-spa-charcoal mb-3">{{ $service->name }}</h3>
                                    <p class="text-spa-gray opacity-80 text-sm mb-6 leading-relaxed line-clamp-3">{{ $service->description }}</p>
                                    <div class="mt-auto">
                                        <span class="text-3xl font-serif font-bold text-spa-brown">₱{{ number_format($service->price, 2) }}</span>
                                    </div>
                                </div>
                                <div class="px-8 py-5 border-t border-spa-beige bg-spa-cream group-hover:bg-spa-beige transition-colors">
                                    @auth
                                        @if(auth()->user()->role === 'customer')
                                            <a href="{{ route('customer.bookings.create', ['service_id' => $service->id]) }}" class="text-sm font-bold text-spa-charcoal hover:text-spa-brown flex items-center uppercase tracking-wider">
                                                Book This Service <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </a>
                                        @else
                                            <a href="{{ url('/') }}" class="text-sm font-bold text-spa-gray opacity-50 flex items-center uppercase tracking-wider">View Details</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="text-sm font-bold text-spa-charcoal hover:text-spa-brown flex items-center uppercase tracking-wider">
                                            Log in to Book <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center bg-spa-white p-12 rounded-2xl border border-spa-beige shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-spa-wood opacity-50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        <h3 class="text-lg font-serif font-medium text-spa-charcoal">Services coming soon</h3>
                        <p class="mt-2 text-sm text-spa-gray opacity-70">We are currently updating our spa menu. Please check back later.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div id="how-it-works" class="py-20 bg-spa-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-serif font-extrabold text-spa-espresso">Your Journey to Relaxation</h2>
                <div class="w-24 h-1 bg-spa-gold mx-auto mt-6 rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 text-center">
                <div class="relative group">
                    <div class="w-20 h-20 mx-auto bg-spa-cream text-spa-brown rounded-full flex items-center justify-center text-2xl font-serif font-bold mb-6 shadow-md border-2 border-spa-beige group-hover:border-spa-wood transition-colors z-10 relative">1</div>
                    <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-spa-beige -z-10"></div>
                    <h3 class="text-xl font-medium text-spa-charcoal mb-3">Create Account</h3>
                    <p class="text-sm text-spa-gray opacity-80 leading-relaxed">Register or log in to securely access our booking system.</p>
                </div>
                <div class="relative group">
                    <div class="w-20 h-20 mx-auto bg-spa-cream text-spa-brown rounded-full flex items-center justify-center text-2xl font-serif font-bold mb-6 shadow-md border-2 border-spa-beige group-hover:border-spa-wood transition-colors z-10 relative">2</div>
                    <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-spa-beige -z-10"></div>
                    <h3 class="text-xl font-medium text-spa-charcoal mb-3">Choose Service</h3>
                    <p class="text-sm text-spa-gray opacity-80 leading-relaxed">Browse our menu and select your preferred wellness treatment.</p>
                </div>
                <div class="relative group">
                    <div class="w-20 h-20 mx-auto bg-spa-cream text-spa-brown rounded-full flex items-center justify-center text-2xl font-serif font-bold mb-6 shadow-md border-2 border-spa-beige group-hover:border-spa-wood transition-colors z-10 relative">3</div>
                    <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-spa-beige -z-10"></div>
                    <h3 class="text-xl font-medium text-spa-charcoal mb-3">Select Schedule</h3>
                    <p class="text-sm text-spa-gray opacity-80 leading-relaxed">Pick a convenient date, time, and available therapist.</p>
                </div>
                <div class="relative group">
                    <div class="w-20 h-20 mx-auto bg-spa-cream text-spa-brown rounded-full flex items-center justify-center text-2xl font-serif font-bold mb-6 shadow-md border-2 border-spa-beige group-hover:border-spa-wood transition-colors z-10 relative">4</div>
                    <h3 class="text-xl font-medium text-spa-charcoal mb-3">Confirm & Visit</h3>
                    <p class="text-sm text-spa-gray opacity-80 leading-relaxed">Confirm booking online and pay over-the-counter during your visit.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="py-20 bg-spa-espresso text-spa-white border-y-8 border-spa-charcoal relative overflow-hidden">
        <!-- Overlay pattern -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(var(--tw-colors-spa-gold) 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-serif font-extrabold text-spa-beige">Why Choose Casa Paraiso?</h2>
                <div class="w-24 h-1 bg-spa-leaf mx-auto mt-6 rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-spa-charcoal p-8 rounded-2xl border border-spa-gray shadow-lg hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 bg-spa-gray rounded-full flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-spa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-spa-white mb-3">Easy Online Booking</h3>
                    <p class="text-spa-beige opacity-80 text-sm leading-relaxed">Schedule your appointments seamlessly from anywhere, at any time.</p>
                </div>
                <div class="bg-spa-charcoal p-8 rounded-2xl border border-spa-gray shadow-lg hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 bg-spa-gray rounded-full flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-spa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-spa-white mb-3">Real-time Availability</h3>
                    <p class="text-spa-beige opacity-80 text-sm leading-relaxed">Check real-time therapist schedules to find the perfect slot for you.</p>
                </div>
                <div class="bg-spa-charcoal p-8 rounded-2xl border border-spa-gray shadow-lg hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 bg-spa-gray rounded-full flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-spa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-spa-white mb-3">Personalized Promotions</h3>
                    <p class="text-spa-beige opacity-80 text-sm leading-relaxed">Enjoy tailored discounts based on your visit history and loyalty.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotions Preview Section -->
    <div id="promotions" class="py-20 bg-spa-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-serif font-extrabold text-spa-espresso">Exclusive Offers</h2>
                    <p class="mt-3 text-lg text-spa-gray opacity-80">Discover ways to save on your wellness journey.</p>
                </div>
                <div class="mt-6 md:mt-0">
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('customer.promotions.index') }}" class="text-spa-brown font-bold tracking-wide hover:text-spa-espresso flex items-center uppercase text-sm border-b-2 border-transparent hover:border-spa-wood pb-1 transition-all">
                                View My Promos <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-spa-brown font-bold tracking-wide hover:text-spa-espresso flex items-center uppercase text-sm border-b-2 border-transparent hover:border-spa-wood pb-1 transition-all">
                            Log in to see your promos <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endauth
                </div>
            </div>

            @if(isset($promotions) && $promotions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($promotions as $promo)
                        <div class="bg-spa-white rounded-2xl shadow-lg border border-spa-beige p-8 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-spa-gold rounded-bl-full opacity-10 group-hover:scale-110 transition-transform duration-500"></div>
                            <h3 class="text-2xl font-serif font-bold text-spa-charcoal mb-4">{{ $promo->name }}</h3>
                            <div class="text-4xl font-extrabold text-spa-brown mb-6">
                                @if($promo->discount_type === 'percentage')
                                    {{ $promo->discount_value }}% OFF
                                @elseif($promo->discount_type === 'fixed')
                                    <span class="text-2xl align-top">₱</span>{{ number_format($promo->discount_value, 0) }} <span class="text-xl">OFF</span>
                                @else
                                    Free Service
                                @endif
                            </div>
                            <p class="text-sm text-spa-gray opacity-80 mb-8 leading-relaxed">{{ $promo->description ?? 'Available for active customers.' }}</p>
                            <div class="text-xs font-semibold uppercase tracking-wider text-spa-leaf bg-spa-leaf bg-opacity-10 inline-block px-4 py-2 rounded-full">
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
                <div class="bg-spa-white rounded-2xl border border-spa-beige p-12 text-center shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-spa-gold opacity-50 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                    <p class="text-spa-gray text-lg">More promotions coming soon. Register an account to receive personalized discounts!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Reviews Preview Section -->
    <div id="reviews" class="py-20 bg-spa-white border-t border-spa-beige">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-serif font-extrabold text-spa-espresso">What Our Guests Say</h2>
                <div class="w-24 h-1 bg-spa-gold mx-auto mt-6 rounded-full"></div>
            </div>

            @if(isset($reviews) && $reviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    @foreach($reviews as $review)
                        <div class="bg-spa-cream p-8 rounded-2xl border border-spa-beige relative hover:shadow-md transition-shadow">
                            <div class="absolute -top-5 left-8 bg-spa-white rounded-full p-3 shadow-sm border border-spa-beige">
                                <svg class="w-6 h-6 text-spa-wood" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                            </div>
                            <div class="mt-6 flex items-center space-x-1 mb-6 text-spa-gold">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-spa-gold' : 'text-spa-beige opacity-50' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-spa-gray italic mb-8 leading-relaxed font-serif text-lg">"{{ $review->key_snippet ?: $review->comment }}"</p>
                            <div class="flex items-center justify-between border-t border-spa-beige pt-6">
                                <div>
                                    @php
                                        // Use generic name to preserve privacy
                                        $firstName = explode(' ', $review->customer->name)[0] ?? 'Verified';
                                    @endphp
                                    <p class="text-base font-bold text-spa-charcoal">{{ $firstName }} M.</p>
                                    <p class="text-sm text-spa-gray opacity-70">{{ $review->service->name }}</p>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-spa-leaf bg-opacity-10 text-spa-leaf uppercase tracking-wider">
                                        Verified
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center bg-spa-cream p-12 rounded-2xl border border-spa-beige shadow-sm">
                    <p class="text-spa-gray opacity-70 text-lg">Customer reviews will appear here after completed appointments.</p>
                </div>
            @endif
        </div>
    </div>

    <x-ui.auth-prompt-modal />
</x-public-layout>
