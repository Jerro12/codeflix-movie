{{-- Skeleton Row Component --}}
{{-- Usage: @include('components.skeleton-row', ['rows' => 3]) --}}

@php $rows = $rows ?? 3; @endphp

<div class="animate-pulse space-y-4">
    @for($i = 0; $i < $rows; $i++)
    <div class="flex items-center gap-4">
        {{-- Avatar/Image --}}
        <div class="skeleton w-12 h-12 rounded-full flex-shrink-0"></div>
        
        {{-- Content --}}
        <div class="flex-1 space-y-2">
            <div class="skeleton h-4 w-1/3 rounded"></div>
            <div class="skeleton h-3 w-2/3 rounded"></div>
        </div>
        
        {{-- Action --}}
        <div class="skeleton h-8 w-20 rounded-lg flex-shrink-0"></div>
    </div>
    @endfor
</div>
