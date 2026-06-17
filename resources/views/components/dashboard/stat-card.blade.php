@props(['title', 'value', 'subtitle' => null, 'icon' => null, 'color' => 'bg-white'])

<div class="{{ $color }} rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between transition-transform duration-300 hover:-translate-y-1 hover:shadow-md">
    <div>
        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ $title }}</h3>
        <p class="mt-2 text-3xl font-bold text-gray-800">{{ $value }}</p>
        @if($subtitle)
            <p class="mt-1 text-sm text-gray-400">{{ $subtitle }}</p>
        @endif
    </div>
    @if($icon)
        <div class="p-3 bg-[#f2ede9] text-[#7a6b5d] rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                {!! $icon !!}
            </svg>
        </div>
    @endif
</div>
