<x-manager-layout>
    <x-slot name="header">
        Therapist Availability
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Therapist Availability</h2>
            <p class="text-sm text-gray-500 mt-1">Manage date-specific therapist schedules, breaks, and availability status.</p>
        </div>
        <a href="{{ route('manager.therapist-availabilities.create') }}" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] focus:bg-[#1f2d28] active:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Availability
        </a>
    </div>



    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('manager.therapist-availabilities.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm transition duration-150 ease-in-out" placeholder="Search by name or notes">
                    </div>
                </div>
                <div>
                    <label for="therapist_id" class="sr-only">Therapist</label>
                    <select name="therapist_id" id="therapist_id" class="block w-full py-2 pl-3 pr-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                        <option value="">All Therapists</option>
                        @foreach($therapists as $t)
                            <option value="{{ $t->id }}" {{ request('therapist_id') == $t->id ? 'selected' : '' }}>{{ $t->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="date" class="sr-only">Date</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}" class="block w-full py-2 pl-3 pr-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm transition duration-150 ease-in-out">
                </div>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label for="status" class="sr-only">Status</label>
                        <select name="status" id="status" class="block w-full py-2 pl-3 pr-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                            <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'therapist_id', 'status', 'date']))
                        <a href="{{ route('manager.therapist-availabilities.index') }}" class="px-4 py-2 border border-transparent text-sm font-medium text-[#2c3e38] hover:text-[#1f2d28]">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Therapist</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($availabilities as $avail)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $avail->availability_date->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $avail->availability_date->format('l') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $avail->therapist->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($avail->status === 'available')
                                    <div class="text-sm text-gray-900 font-semibold">
                                        {{ \Carbon\Carbon::parse($avail->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($avail->end_time)->format('g:i A') }}
                                    </div>
                                    @if($avail->break_start_time)
                                        <div class="text-xs text-gray-500">
                                            Break: {{ \Carbon\Carbon::parse($avail->break_start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($avail->break_end_time)->format('g:i A') }}
                                        </div>
                                    @endif
                                @else
                                    <div class="text-sm text-gray-500 italic">-</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-ui.status-badge :status="$avail->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 truncate max-w-[150px]">{{ $avail->notes ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('manager.therapist-availabilities.edit', $avail) }}" class="text-[#2c3e38] hover:text-[#1f2d28] mr-3">Edit</a>
                                <button type="button" x-data="" x-on:click="$dispatch('open-modal-confirm-delete-{{ $avail->id }}')" class="text-red-600 hover:text-red-900">Delete</button>
                                
                                <x-ui.confirm-modal 
                                    id="confirm-delete-{{ $avail->id }}"
                                    name="confirm-delete-{{ $avail->id }}"
                                    title="Delete Availability"
                                    message="Are you sure you want to delete this availability record for {{ $avail->therapist->user->name }}?"
                                    action="{{ route('manager.therapist-availabilities.destroy', $avail) }}"
                                    method="DELETE"
                                    confirmText="Delete"
                                />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 whitespace-nowrap">
                                <x-ui.empty-state 
                                    icon="calendar" 
                                    title="No availability records found" 
                                    description="No schedules have been defined yet." 
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($availabilities->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $availabilities->links() }}
            </div>
        @endif
    </div>
</x-manager-layout>
