<x-therapist-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Commission Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center px-4 sm:px-0">
                <a href="{{ route('therapist.commissions.index') }}" class="text-[#2c3e38] hover:underline flex items-center text-sm font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to History
                </a>
                
                @if($commission->status === 'unpaid')
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Status: Unpaid</span>
                @elseif($commission->status === 'paid')
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Status: Paid</span>
                @else
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Status: Voided</span>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="border-b border-gray-100 p-8 text-center bg-[#f9f8f6]">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Commission Reference</p>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $commission->commission_reference }}</h1>
                    <p class="text-sm text-gray-500 mt-2">Earned on {{ $commission->earned_at ? $commission->earned_at->format('M d, Y') : 'N/A' }}</p>
                </div>

                <div class="p-8">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-b pb-2">Computation Summary</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center mb-8">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Gross Service Amount</p>
                            <p class="text-xl font-bold text-gray-900">₱{{ number_format($commission->gross_amount, 2) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 flex items-center justify-center">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Commission Rate</p>
                                <p class="text-xl font-bold text-gray-900">{{ number_format($commission->commission_rate, 0) }}%</p>
                            </div>
                        </div>
                        <div class="bg-[#e8dbce]/30 rounded-lg p-4 border border-[#e8dbce]">
                            <p class="text-xs font-medium text-[#7a6b5d] uppercase tracking-wider mb-1">Net Commission</p>
                            <p class="text-2xl font-bold text-[#2c3e38]">₱{{ number_format($commission->commission_amount, 2) }}</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-b pb-2">Service Details</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2 mb-8">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Service Performed</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $commission->service->name }} ({{ $commission->service->duration_minutes }} mins)</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Related Transaction</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $commission->transaction->transaction_reference ?? 'N/A' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Paid Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $commission->paid_at ? $commission->paid_at->format('M d, Y h:i A') : 'Pending' }}</dd>
                        </div>
                    </dl>
                    
                    @if($commission->status === 'voided')
                        <div class="mt-6 p-4 bg-red-50 rounded-md border border-red-100">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Commission Voided</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>{{ $commission->notes ?: 'This commission has been cancelled and will not be disbursed.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</x-therapist-layout>

