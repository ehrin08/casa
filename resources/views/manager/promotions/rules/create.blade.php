<x-manager-layout>
    <x-slot name="header">
        Create Promotion Rule
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('manager.promotions.rules') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">&larr; Back to Rules</a>
    </div>

    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <form action="{{ route('manager.promotions.rules.store') }}" method="POST" class="p-6">
            @csrf
            
            @include('manager.promotions.rules._form', ['rule' => new \App\Models\PromotionRule()])

            <div class="mt-8 border-t border-spa-beige pt-6 flex justify-end">
                <x-ui.submit-button label="Save Promotion Rule" />
            </div>
        </form>
    </div>
</x-manager-layout>
