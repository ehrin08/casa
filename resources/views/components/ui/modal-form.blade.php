@props(['title', 'subtitle' => '', 'action' => '', 'method' => 'POST'])

<form method="POST" action="{{ $action }}">
    @csrf
    @if(strtoupper($method) !== 'POST')
        @method($method)
    @endif
    
    <div class="px-6 py-4 border-b border-spa-beige bg-spa-cream flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold font-serif text-spa-charcoal" id="modal-title">
                {{ $title }}
            </h3>
            @if($subtitle)
                <p class="text-sm text-spa-gray opacity-80 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        <button type="button" x-on:click="show = false" class="text-spa-gray hover:text-spa-charcoal transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="p-6 max-h-[65vh] overflow-y-auto">
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                    </div>
                </div>
            </div>
        @endif
        {{ $slot }}
    </div>

    <div class="bg-spa-cream border-t border-spa-beige px-6 py-4 flex items-center justify-end gap-3 rounded-b-lg">
        <button type="button" x-on:click="show = false" class="px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest shadow-sm hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-[#2c3e38] transition ease-in-out duration-150">
            Cancel
        </button>
        {{ $actions ?? '' }}
    </div>
</form>
