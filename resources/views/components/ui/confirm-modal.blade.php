@props([
    'name', 
    'title' => 'Confirm Action', 
    'message' => 'Are you sure you want to proceed?', 
    'action' => '', 
    'method' => 'POST', 
    'confirmText' => 'Confirm', 
    'cancelText' => 'Cancel', 
    'type' => 'danger'
])

@php
    $buttonClass = $type === 'danger' 
        ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white' 
        : 'bg-spa-brown hover:bg-spa-espresso focus:ring-spa-gold text-spa-white';
        
    $iconClass = $type === 'danger'
        ? 'text-red-600 bg-red-100'
        : 'text-spa-leaf bg-spa-leaf bg-opacity-20';
@endphp

<x-modal :name="$name" :show="false" maxWidth="sm">
    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full {{ $iconClass }} sm:mx-0 sm:h-10 sm:w-10">
                @if($type === 'danger')
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                @else
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                <h3 class="text-lg leading-6 font-serif font-bold text-spa-charcoal" id="modal-title">
                    {{ $title }}
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-spa-gray opacity-80">
                        {{ $message }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-spa-cream border-t border-spa-beige px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <form method="POST" action="{{ $action }}" class="w-full sm:w-auto">
            @csrf
            @if($method !== 'POST')
                @method($method)
            @endif
            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm transition-colors {{ $buttonClass }}">
                {{ $confirmText }}
            </button>
        </form>
        <button type="button" x-on:click="$dispatch('close-modal', '{{ $name }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-spa-wood shadow-sm px-4 py-2 bg-spa-white text-base font-bold text-spa-charcoal hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-spa-gold sm:mt-0 sm:w-auto sm:text-sm transition-colors">
            {{ $cancelText }}
        </button>
    </div>
</x-modal>
