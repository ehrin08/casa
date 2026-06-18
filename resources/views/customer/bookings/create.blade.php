<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book an Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="bookingWizard()">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('customer.bookings.store') }}" method="POST" class="p-6 md:p-8" @submit="submitForm">
                    @csrf

                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between relative">
                            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 z-0"></div>
                            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-[#2c3e38] z-0 transition-all duration-300" :style="'width: ' + ((step - 1) / 3 * 100) + '%'"></div>
                            
                            <template x-for="i in 4" :key="i">
                                <div class="relative z-10 flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold transition-colors duration-300"
                                         :class="step >= i ? 'bg-[#2c3e38] text-white' : 'bg-gray-200 text-gray-500'">
                                        <span x-text="i"></span>
                                    </div>
                                    <div class="mt-2 text-xs font-medium text-gray-500 hidden sm:block" x-text="stepLabels[i-1]"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Step 1: Service -->
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Step 1: Choose a Service</h3>
                        <div class="space-y-4">
                            @foreach($services as $s)
                                <label class="relative block bg-white border rounded-lg shadow-sm px-6 py-4 cursor-pointer hover:border-[#2c3e38] sm:flex sm:justify-between focus-within:ring-1 focus-within:ring-[#2c3e38]"
                                       :class="selectedService == {{ $s->id }} ? 'border-[#2c3e38] ring-1 ring-[#2c3e38]' : 'border-gray-300'">
                                    <input type="radio" name="service_id" value="{{ $s->id }}" class="sr-only" x-model="selectedService" @change="updateServiceInfo({{ $s->id }}, '{{ addslashes($s->name) }}', {{ $s->duration_minutes }}, {{ $s->price }})">
                                    <div class="flex items-center">
                                        <div class="text-sm">
                                            <p class="font-medium text-gray-900">{{ $s->name }}</p>
                                            <div class="text-gray-500">
                                                <span class="sm:inline">{{ $s->category }}</span>
                                                <span class="hidden sm:inline sm:mx-1">&middot;</span>
                                                <span class="sm:inline">{{ $s->duration_minutes }} minutes</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-sm sm:mt-0 sm:block sm:ml-4 sm:text-right">
                                        <div class="font-medium text-gray-900">₱{{ number_format($s->price, 2) }}</div>
                                    </div>
                                    <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true" :class="selectedService == {{ $s->id }} ? 'border-[#2c3e38]' : 'border-transparent'"></div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 2: Date, Time & Therapist -->
                    <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Step 2: Choose Date, Time & Therapist</h3>
                        
                        <div class="space-y-6">
                            <div class="bg-gray-50 p-4 rounded-md mb-4 border border-gray-100">
                                <p class="text-sm text-gray-700"><strong>Selected Service:</strong> <span x-text="serviceName"></span> (<span x-text="serviceDuration"></span> mins)</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="appointment_date" value="Date *" />
                                    <x-text-input id="appointment_date" name="appointment_date" type="date" class="mt-1 block w-full" x-model="appointmentDate" required min="{{ date('Y-m-d') }}" />
                                </div>
                                <div>
                                    <x-input-label for="start_time" value="Start Time *" />
                                    <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" x-model="startTime" required />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="therapist_id" value="Therapist *" />
                                <select id="therapist_id" name="therapist_id" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" x-model="therapistId" required>
                                    <option value="any">Any Available Therapist (Auto-assign)</option>
                                    @foreach($therapists as $t)
                                        <option value="{{ $t->id }}">{{ $t->user->name }} ({{ $t->specialization }})</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-2">If you select a specific therapist, we will check their schedule and breaks before confirming.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Customer Details -->
                    <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Step 3: Your Details</h3>
                        
                        <div class="space-y-5">
                            <div>
                                <x-input-label value="Name" />
                                <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500 cursor-not-allowed" value="{{ auth()->user()->name }}" disabled />
                            </div>

                            <div>
                                <x-input-label value="Email" />
                                <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500 cursor-not-allowed" value="{{ auth()->user()->email }}" disabled />
                            </div>

                            <div>
                                <x-input-label for="customer_phone" value="Phone Number *" />
                                <x-text-input id="customer_phone" name="customer_phone" type="text" class="mt-1 block w-full" x-model="customerPhone" required placeholder="09xxxxxxxxx" />
                            </div>

                            <div>
                                <x-input-label for="notes" value="Special Requests / Notes" />
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" placeholder="Any specific areas to focus on?"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Payment Confirmation -->
                    <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Step 4: Summary & Payment</h3>
                        
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 space-y-4">
                            <div class="flex justify-between border-b border-gray-200 pb-3">
                                <span class="text-gray-600">Service</span>
                                <span class="font-medium text-gray-900" x-text="serviceName"></span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-3">
                                <span class="text-gray-600">Date & Time</span>
                                <span class="font-medium text-gray-900"><span x-text="appointmentDate"></span> at <span x-text="startTime"></span></span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-3">
                                <span class="text-gray-600">Total Price</span>
                                <span class="font-bold text-[#2c3e38]" :class="selectedPromoId ? 'line-through text-gray-400 font-normal text-sm' : ''">₱<span x-text="servicePrice.toFixed(2)"></span></span>
                            </div>
                            
                            <div class="flex justify-between border-b border-gray-200 pb-3" x-show="selectedPromoId">
                                <span class="text-green-600 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    Promo Applied
                                </span>
                                <span class="font-bold text-green-600">-₱<span x-text="discountAmount.toFixed(2)"></span></span>
                            </div>

                            <div class="flex justify-between border-b border-gray-200 pb-3" x-show="selectedPromoId">
                                <span class="text-gray-900 font-bold">Final Amount</span>
                                <span class="font-bold text-[#2c3e38] text-lg">₱<span x-text="finalAmount.toFixed(2)"></span></span>
                            </div>

                            <!-- Promo Code Selection -->
                            <div class="pt-2 pb-4">
                                <x-input-label for="customer_promotion_id" value="Apply Promotion Code (Optional)" />
                                @if(count($availablePromotions) > 0)
                                    <select id="customer_promotion_id" name="customer_promotion_id" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" x-model="selectedPromoId" @change="calculateDiscount">
                                        <option value="">-- Do not use a promotion --</option>
                                        @foreach($availablePromotions as $promo)
                                            <option value="{{ $promo->id }}" 
                                                    data-type="{{ $promo->discount_type }}" 
                                                    data-value="{{ $promo->discount_value }}"
                                                    data-service="{{ $promo->rule->applicable_service_id ?? '' }}">
                                                {{ $promo->code }} - {{ $promo->title }} 
                                                (@if($promo->discount_type == 'percentage'){{ $promo->discount_value }}% Off
                                                 @elseif($promo->discount_type == 'fixed')₱{{ $promo->discount_value }} Off
                                                 @else Free @endif)
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-2" x-show="promoError" x-text="promoError" style="color: red;"></p>
                                @else
                                    <div class="mt-1 text-sm text-gray-500 bg-gray-100 p-3 rounded-md">
                                        You don't have any available promotions. <a href="{{ route('customer.promotions.index') }}" class="text-indigo-600 hover:underline" target="_blank">View your wallet</a>.
                                    </div>
                                @endif
                            </div>
                            
                            <div class="pt-4">
                                <div class="flex items-center text-sm text-yellow-800 bg-yellow-50 p-3 rounded-md border border-yellow-200">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <p>Payment is recorded as over-the-counter cash for capstone testing. Official transaction processing will be implemented later.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                        <button type="button" x-show="step > 1" @click="step--" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                            Back
                        </button>
                        <div x-show="step === 1" class="w-full"></div> <!-- Spacer -->

                        <button type="button" x-show="step < 4" @click="nextStep" class="px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] transition ease-in-out duration-150 shadow-sm">
                            Next
                        </button>

                        <button type="submit" x-show="step === 4" class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 transition ease-in-out duration-150 shadow-sm" style="display: none;">
                            Confirm Booking
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('bookingWizard', () => ({
                step: 1,
                stepLabels: ['Service', 'Date & Time', 'Details', 'Payment'],
                selectedService: '{{ old('service_id', '') }}',
                serviceName: '',
                serviceDuration: 0,
                servicePrice: 0,
                appointmentDate: '{{ old('appointment_date', '') }}',
                startTime: '{{ old('start_time', '') }}',
                therapistId: '{{ old('therapist_id', 'any') }}',
                customerPhone: '{{ old('customer_phone', '') }}',
                selectedPromoId: '{{ old('customer_promotion_id', '') }}',
                discountAmount: 0,
                finalAmount: 0,
                promoError: '',

                updateServiceInfo(id, name, duration, price) {
                    this.selectedService = id;
                    this.serviceName = name;
                    this.serviceDuration = duration;
                    this.servicePrice = price;
                    this.finalAmount = price;
                    this.calculateDiscount();
                },

                calculateDiscount() {
                    this.promoError = '';
                    this.discountAmount = 0;
                    this.finalAmount = this.servicePrice;

                    if (!this.selectedPromoId) return;

                    const select = document.getElementById('customer_promotion_id');
                    if(!select) return;

                    const option = select.options[select.selectedIndex];
                    const type = option.dataset.type;
                    const value = parseFloat(option.dataset.value);
                    const specificService = option.dataset.service;

                    // Basic frontend validation for specific service
                    if (specificService && specificService != this.selectedService) {
                        this.promoError = 'This promotion cannot be applied to the selected service.';
                        this.selectedPromoId = '';
                        return;
                    }

                    if (type === 'percentage') {
                        this.discountAmount = this.servicePrice * (value / 100);
                    } else if (type === 'fixed') {
                        this.discountAmount = value;
                    } else if (type === 'free_service') {
                        this.discountAmount = this.servicePrice;
                    }

                    if (this.discountAmount > this.servicePrice) {
                        this.discountAmount = this.servicePrice;
                    }

                    this.finalAmount = this.servicePrice - this.discountAmount;
                },

                nextStep() {
                    if (this.step === 1 && !this.selectedService) {
                        alert('Please select a service first.');
                        return;
                    }
                    if (this.step === 2 && (!this.appointmentDate || !this.startTime)) {
                        alert('Please select a date and time.');
                        return;
                    }
                    if (this.step === 3 && !this.customerPhone) {
                        alert('Please provide your phone number.');
                        return;
                    }
                    if (this.step === 3) {
                        // We are moving to step 4, calculate discount if a promo is selected by default or preserved
                        this.calculateDiscount();
                    }
                    this.step++;
                },

                submitForm(e) {
                    if (this.step !== 4) {
                        e.preventDefault();
                    }
                }
            }));
        });
    </script>
    @endpush
</x-customer-layout>

