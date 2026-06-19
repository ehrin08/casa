<x-manager-layout>
    <x-slot name="header">
        Edit Promotion Rule
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('manager.promotions.rules') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">&larr; Back to Rules</a>
    </div>

    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <form action="{{ route('manager.promotions.rules.update', $promotionRule) }}" method="POST" class="p-6">
            @csrf
            @method('PATCH')
            
            @include('manager.promotions.rules._form', ['rule' => $promotionRule])

            <div class="mt-8 border-t pt-6 flex justify-end">
                <x-ui.submit-button label="Update Promotion Rule" />
            </div>
        </form>
    </div>
</x-manager-layout>
