@props(['title', 'action' => null, 'actionUrl' => '#'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-white">
        <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
        @if($action)
            <a href="{{ $actionUrl }}" class="text-sm font-medium text-[#4a3f35] hover:text-[#2c3e38] transition-colors">
                {{ $action }} &rarr;
            </a>
        @endif
    </div>
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
