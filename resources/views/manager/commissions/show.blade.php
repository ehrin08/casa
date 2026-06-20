<x-manager-layout>
    <x-slot name="header">
        Commission Details
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-spa-charcoal">Ref: {{ $commission->commission_reference }}</h2>
            <p class="text-sm text-spa-gray opacity-80 mt-1">Generated on {{ $commission->created_at->format('M d, Y g:i A') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('manager.commissions.pdf', $commission) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest shadow-sm hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2 text-spa-gray opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                PDF
            </a>
            <a href="{{ route('manager.commissions.index') }}" class="inline-flex items-center px-4 py-2 bg-spa-beige border border-transparent rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to List
            </a>
        </div>
    </div>



    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Computation Overview</h3>
                    <x-ui.status-badge :status="$commission->status" />
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                        <div class="bg-spa-cream rounded-lg p-4 border border-spa-beige">
                            <p class="text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider mb-1">Gross Amount</p>
                            <p class="text-2xl font-bold text-spa-charcoal">₱{{ number_format($commission->gross_amount, 2) }}</p>
                        </div>
                        <div class="bg-spa-cream rounded-lg p-4 border border-spa-beige">
                            <p class="text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider mb-1">Rate</p>
                            <p class="text-2xl font-bold text-spa-charcoal">{{ number_format($commission->commission_rate, 0) }}%</p>
                        </div>
                        <div class="bg-[#e8dbce]/30 rounded-lg p-4 border border-[#e8dbce]">
                            <p class="text-xs font-medium text-[#7a6b5d] uppercase tracking-wider mb-1">Commission Earned</p>
                            <p class="text-3xl font-bold text-[#2c3e38]">₱{{ number_format($commission->commission_amount, 2) }}</p>
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2 mt-8">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Therapist</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $commission->therapist->user->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Service Rendered</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $commission->service->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Earned Date</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $commission->earned_at ? $commission->earned_at->format('M d, Y') : 'N/A' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Paid Date</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $commission->paid_at ? $commission->paid_at->format('M d, Y') : '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2 pt-4 border-t border-spa-beige">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Notes / Void Reason</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal whitespace-pre-line">{{ $commission->notes ?: 'None' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            @if($commission->status === 'unpaid')
                <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige p-6 flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-medium text-spa-charcoal">Mark as Settled</h4>
                        <p class="text-sm text-spa-gray opacity-80 mt-1">Has this commission been disbursed to the therapist?</p>
                    </div>
                    <div>
                        <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'confirm-pay')" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Mark as Paid
                        </button>
                        
                        <x-ui.confirm-modal 
                            id="confirm-pay"
                            name="confirm-pay"
                            title="Mark as Paid"
                            message="Are you sure you want to mark this commission as paid?"
                            action="{{ route('manager.commissions.markPaid', $commission) }}"
                            method="PATCH"
                            confirmText="Mark as Paid"
                            type="info"
                        />
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Transaction Source</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-medium text-spa-gray opacity-80">Transaction Reference</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal font-medium">
                                @if($commission->transaction)
                                    <a href="{{ route('manager.transactions.show', $commission->transaction) }}" class="text-[#2c3e38] hover:underline">{{ $commission->transaction->transaction_reference }}</a>
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-spa-gray opacity-80">Transaction Status</dt>
                            <dd class="mt-1">
                                @if($commission->transaction)
                                    <span class="text-sm font-medium {{ $commission->transaction->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ ucfirst($commission->transaction->payment_status) }}
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div class="pt-4 border-t border-spa-beige">
                            <dt class="text-xs font-medium text-spa-gray opacity-80">Booking Reference</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">
                                @if($commission->booking)
                                    <a href="{{ route('manager.bookings.show', $commission->booking) }}" class="text-[#2c3e38] hover:underline">{{ $commission->booking->booking_reference }}</a>
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-spa-gray opacity-80">Customer Name</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $commission->customer ? $commission->customer->name : 'Walk-in' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($commission->status !== 'voided')
                <div class="bg-spa-white rounded-xl shadow-sm border border-red-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-red-100 bg-red-50/50">
                        <h3 class="text-lg font-medium leading-6 text-red-800">Danger Zone</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-spa-gray opacity-80 mb-4">Manually voiding this commission will cancel it from the therapist's earnings.</p>
                        <div class="mb-3">
                            <label class="block text-xs font-medium text-spa-charcoal opacity-90 mb-1">Reason (Optional)</label>
                            <input type="text" readonly value="Provide reason in the next step" class="w-full bg-gray-50 rounded-md border-spa-wood shadow-sm text-sm text-spa-gray cursor-not-allowed">
                        </div>
                        <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'void-commission')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-spa-white border border-red-300 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Void Commission
                        </button>
                        
                        <x-modal name="void-commission" maxWidth="md">
                            <x-ui.modal-form 
                                title="Void Commission" 
                                subtitle="Are you sure you want to manually void this commission? This will cancel it from the therapist's earnings." 
                                action="{{ route('manager.commissions.void', $commission) }}" 
                                method="PATCH"
                            >
                                <div>
                                    <x-input-label for="reason" value="Reason (Optional)" />
                                    <x-text-input id="reason" name="reason" type="text" class="mt-1 block w-full border-spa-wood focus:border-red-500 focus:ring-red-500" />
                                </div>
                                <x-slot name="actions">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Void Commission
                                    </button>
                                </x-slot>
                            </x-ui.modal-form>
                        </x-modal>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-manager-layout>
