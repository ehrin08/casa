<x-manager-layout>
    <x-slot name="header">
        Therapist Management
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-spa-charcoal">Therapist Management</h2>
            <p class="text-sm text-spa-gray opacity-80 mt-1">Manage therapist accounts, contact details, specializations, and status.</p>
        </div>
        <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-therapist')" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] focus:bg-[#1f2d28] active:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Therapist
        </button>
    </div>



    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden mb-6">
        <div class="p-6 border-b border-spa-beige bg-gray-50/50">
            <form method="GET" action="{{ route('manager.therapists.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-spa-gray opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-spa-wood rounded-md leading-5 bg-spa-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm transition duration-150 ease-in-out" placeholder="Search by name, email, phone, or specialization">
                    </div>
                </div>
                <div>
                    <label for="specialization" class="sr-only">Specialization</label>
                    <select name="specialization" id="specialization" class="block w-full py-2 pl-3 pr-10 border border-spa-wood bg-spa-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                        <option value="">All Specializations</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label for="status" class="sr-only">Status</label>
                        <select name="status" id="status" class="block w-full py-2 pl-3 pr-10 border border-spa-wood bg-spa-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 border border-spa-wood rounded-md shadow-sm text-sm font-medium text-spa-charcoal opacity-90 bg-spa-white hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'specialization', 'status']))
                        <a href="{{ route('manager.therapists.index') }}" class="px-4 py-2 border border-transparent text-sm font-medium text-[#2c3e38] hover:text-[#1f2d28]">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-spa-cream">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Therapist Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Contact</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Specialization</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-spa-white divide-y divide-gray-200">
                    @forelse ($therapists as $therapist)
                        <tr class="hover:bg-spa-beige transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-[#e8dbce] flex items-center justify-center text-[#7a6b5d] font-bold">
                                        {{ substr($therapist->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-spa-charcoal">{{ $therapist->user->name }}</div>
                                        <div class="text-xs text-spa-gray opacity-80">Account Linked</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-spa-charcoal">{{ $therapist->user->email }}</div>
                                <div class="text-sm text-spa-gray opacity-80">{{ $therapist->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-spa-charcoal">{{ $therapist->specialization }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-ui.status-badge :status="$therapist->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'edit-therapist-{{ $therapist->id }}')" class="text-[#2c3e38] hover:text-[#1f2d28] mr-3">Edit</button>
                                <button type="button" x-data="" x-on:click="$dispatch('open-modal-confirm-delete-{{ $therapist->id }}')" class="text-red-600 hover:text-red-900">Delete</button>
                                
                                <x-ui.confirm-modal 
                                    id="confirm-delete-{{ $therapist->id }}"
                                    name="confirm-delete-{{ $therapist->id }}"
                                    title="Delete Therapist Profile"
                                    message="Are you sure you want to remove {{ $therapist->user->name }}'s profile? The user account will remain but will lose therapist access."
                                    action="{{ route('manager.therapists.destroy', $therapist) }}"
                                    method="DELETE"
                                    confirmText="Delete Profile"
                                />
                                
                                <x-modal name="edit-therapist-{{ $therapist->id }}" :show="$errors->any() && old('_modal_id') === 'edit-therapist-'.$therapist->id">
                                    <x-ui.modal-form 
                                        title="Edit Therapist" 
                                        subtitle="Update profile and contact details for {{ $therapist->user->name }}." 
                                        action="{{ route('manager.therapists.update', $therapist) }}" 
                                        method="PUT"
                                    >
                                        @include('manager.therapists._form', ['modalId' => 'edit-therapist-'.$therapist->id])
                                        <x-slot name="actions">
                                            <x-ui.submit-button label="Save Changes" />
                                        </x-slot>
                                    </x-ui.modal-form>
                                </x-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 whitespace-nowrap">
                                <x-ui.empty-state 
                                    icon="users" 
                                    title="No therapists found" 
                                    description="Get started by adding a new therapist profile." 
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($therapists->hasPages())
            <div class="px-6 py-4 border-t border-spa-beige">
                {{ $therapists->links() }}
            </div>
        @endif
    </div>

    <x-modal name="create-therapist" :show="$errors->any() && old('_modal_id') === 'create-therapist'">
        <x-ui.modal-form 
            title="Add New Therapist" 
            subtitle="Create a therapist profile. A user account will be automatically created with a default password." 
            action="{{ route('manager.therapists.store') }}" 
            method="POST"
        >
            @include('manager.therapists._form', ['modalId' => 'create-therapist', 'therapist' => new \App\Models\Therapist()])
            <x-slot name="actions">
                <x-ui.submit-button label="Create Therapist" />
            </x-slot>
        </x-ui.modal-form>
    </x-modal>
</x-manager-layout>
