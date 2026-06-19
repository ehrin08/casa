<x-therapist-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-spa-charcoal leading-tight">
            {{ __('My Availability') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <p class="text-sm text-spa-gray opacity-80 italic">For schedule changes, please contact the manager. Request workflow will be added later.</p>
            </div>

            <div class="bg-spa-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-spa-charcoal">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-spa-cream">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Schedule</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-spa-white divide-y divide-gray-200">
                                @forelse ($availabilities as $avail)
                                    <tr class="hover:bg-spa-beige transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-spa-charcoal">{{ $avail->availability_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-spa-gray opacity-80">{{ $avail->availability_date->format('l') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($avail->status === 'available')
                                                <div class="text-sm text-spa-charcoal font-semibold">
                                                    {{ \Carbon\Carbon::parse($avail->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($avail->end_time)->format('g:i A') }}
                                                </div>
                                                @if($avail->break_start_time)
                                                    <div class="text-xs text-spa-gray opacity-80">
                                                        Break: {{ \Carbon\Carbon::parse($avail->break_start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($avail->break_end_time)->format('g:i A') }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-sm text-spa-gray opacity-80 italic">-</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                                <x-ui.status-badge :status="$avail->status" />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-spa-gray opacity-80 truncate max-w-[200px]">{{ $avail->notes ?? '-' }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <x-ui.empty-state 
                                        colspan="4"
                                        icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        title="No upcoming availability"
                                        description="You don't have any availability scheduled."
                                    />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($availabilities->hasPages())
                        <div class="mt-4">
                            {{ $availabilities->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-therapist-layout>

