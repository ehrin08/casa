@props(['icon' => 'folder', 'title', 'description' => '', 'action' => null])

<div {{ $attributes->merge(['class' => 'text-center py-12 px-4 sm:px-6 lg:px-8 border-2 border-dashed border-spa-beige rounded-2xl bg-spa-cream/50']) }}>
    @if($icon === 'folder')
        <svg class="mx-auto h-12 w-12 text-spa-wood opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
        </svg>
    @elseif($icon === 'calendar')
        <svg class="mx-auto h-12 w-12 text-spa-wood opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    @elseif($icon === 'users')
        <svg class="mx-auto h-12 w-12 text-spa-wood opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
    @elseif($icon === 'receipt')
        <svg class="mx-auto h-12 w-12 text-spa-wood opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
    @elseif($icon === 'star')
        <svg class="mx-auto h-12 w-12 text-spa-gold opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
        </svg>
    @else
        <div class="text-4xl mb-3 text-spa-wood opacity-50">{!! $icon !!}</div>
    @endif
    
    <h3 class="mt-2 text-lg font-serif font-bold text-spa-charcoal">{{ $title }}</h3>
    @if($description)
        <p class="mt-1 text-sm text-spa-gray opacity-80">{{ $description }}</p>
    @endif
    @if($action)
        <div class="mt-6">
            {{ $action }}
        </div>
    @endif
</div>
