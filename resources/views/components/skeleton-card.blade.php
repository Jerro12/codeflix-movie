{{-- Skeleton Card Component --}}
{{-- Usage: @include('components.skeleton-card', ['count' => 6]) --}}

@php $count = $count ?? 1; @endphp

@for($i = 0; $i < $count; $i++)
<div class="animate-pulse">
    <div class="bg-codeflix-card rounded-xl overflow-hidden">
        {{-- Poster skeleton --}}
        <div class="skeleton aspect-[2/3] w-full"></div>
        
        {{-- Content skeleton --}}
        <div class="p-3 space-y-2">
            {{-- Title --}}
            <div class="skeleton h-4 w-3/4 rounded"></div>
            {{-- Meta --}}
            <div class="flex gap-2">
                <div class="skeleton h-3 w-10 rounded"></div>
                <div class="skeleton h-3 w-16 rounded"></div>
            </div>
        </div>
    </div>
</div>
@endfor
