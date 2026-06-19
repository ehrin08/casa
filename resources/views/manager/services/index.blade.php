<x-manager-layout>
    <x-slot name="header">
        Service Management
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Service Management</h2>
            <p class="text-sm text-gray-500 mt-1">Manage spa services, pricing, duration, availability, and commission rate.</p>
        </div>
        <a href="{{ route('manager.services.create') }}" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] focus:bg-[#1f2d28] active:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Service
        </a>
    </div>



    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('manager.services.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm transition duration-150 ease-in-out" placeholder="Search by name or description">
                    </div>
                </div>
                <div>
                    <label for="category" class="sr-only">Category</label>
                    <select name="category" id="category" class="block w-full py-2 pl-3 pr-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                        <option value="">All Categories</option>
                        <option value="Massage" {{ request('category') == 'Massage' ? 'selected' : '' }}>Massage</option>
                        <option value="Nails" {{ request('category') == 'Nails' ? 'selected' : '' }}>Nails</option>
                        <option value="Facial" {{ request('category') == 'Facial' ? 'selected' : '' }}>Facial</option>
                        <option value="Body Treatment" {{ request('category') == 'Body Treatment' ? 'selected' : '' }}>Body Treatment</option>
                        <option value="Package" {{ request('category') == 'Package' ? 'selected' : '' }}>Package</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label for="status" class="sr-only">Status</label>
                        <select name="status" id="status" class="block w-full py-2 pl-3 pr-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ route('manager.services.index') }}" class="px-4 py-2 border border-transparent text-sm font-medium text-[#2c3e38] hover:text-[#1f2d28]">
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price / Duration</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission Rate</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($services as $service)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                @if($service->description)
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($service->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $service->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-semibold">${{ number_format($service->price, 2) }}</div>
                                <div class="text-xs text-gray-500">{{ $service->duration_minutes }} mins</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($service->commission_rate, 2) }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-ui.status-badge :status="$service->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('manager.services.edit', $service) }}" class="text-[#2c3e38] hover:text-[#1f2d28] mr-3">Edit</a>
                                <button type="button" x-data="" x-on:click="$dispatch('open-modal-confirm-delete-{{ $service->id }}')" class="text-red-600 hover:text-red-900">Delete</button>
                                
                                <x-ui.confirm-modal 
                                    id="confirm-delete-{{ $service->id }}"
                                    name="confirm-delete-{{ $service->id }}"
                                    title="Delete Service"
                                    message="Are you sure you want to delete '{{ $service->name }}'? This action cannot be undone."
                                    action="{{ route('manager.services.destroy', $service) }}"
                                    method="DELETE"
                                    confirmText="Delete"
                                />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 whitespace-nowrap">
                                <x-ui.empty-state 
                                    icon="folder" 
                                    title="No services found" 
                                    description="Try adjusting your search or filters." 
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($services->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</x-manager-layout>
