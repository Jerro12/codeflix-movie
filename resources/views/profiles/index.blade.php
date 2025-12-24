@extends('layouts.app-new')

@section('title', 'Who\'s Watching?')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="font-outfit text-4xl font-bold text-white mb-12">Who's watching?</h1>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            @foreach($profiles as $profile)
            <form action="{{ route('profiles.switch', $profile) }}" method="POST" class="group">
                @csrf
                @if($profile->pin)
                <div x-data="{ showPin: false }">
                    <button type="button" @click="showPin = true" class="w-full">
                        <div class="relative mx-auto w-32 h-32 rounded-lg overflow-hidden border-2 border-transparent group-hover:border-codeflix-primary transition-all">
                            <img src="{{ $profile->avatar_url }}" alt="{{ $profile->name }}" class="w-full h-full object-cover">
                            @if($profile->is_kids)
                            <div class="absolute bottom-0 left-0 right-0 bg-yellow-500 text-xs font-bold text-black py-0.5 text-center">KIDS</div>
                            @endif
                        </div>
                        <p class="mt-3 text-gray-400 group-hover:text-white font-medium transition-colors">{{ $profile->name }}</p>
                        <p class="text-xs text-gray-600"><i class="fa-solid fa-lock"></i> PIN protected</p>
                    </button>
                    
                    <!-- PIN Modal -->
                    <div x-show="showPin" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/90">
                        <div class="bg-codeflix-card rounded-xl p-6 w-80">
                            <h3 class="text-white font-semibold mb-4 text-center">Enter PIN for {{ $profile->name }}</h3>
                            <input type="password" name="pin" maxlength="4" pattern="[0-9]{4}" 
                                   class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-center text-2xl tracking-widest text-white mb-4"
                                   placeholder="• • • •" autofocus>
                            <div class="flex gap-2">
                                <button type="button" @click="showPin = false" class="flex-1 py-2 bg-gray-700 text-white rounded-lg">Cancel</button>
                                <button type="submit" class="flex-1 py-2 bg-codeflix-primary text-white rounded-lg">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <button type="submit" class="w-full">
                    <div class="relative mx-auto w-32 h-32 rounded-lg overflow-hidden border-2 border-transparent group-hover:border-codeflix-primary transition-all">
                        <img src="{{ $profile->avatar_url }}" alt="{{ $profile->name }}" class="w-full h-full object-cover">
                        @if($profile->is_kids)
                        <div class="absolute bottom-0 left-0 right-0 bg-yellow-500 text-xs font-bold text-black py-0.5 text-center">KIDS</div>
                        @endif
                    </div>
                    <p class="mt-3 text-gray-400 group-hover:text-white font-medium transition-colors">{{ $profile->name }}</p>
                </button>
                @endif
            </form>
            @endforeach

            <!-- Add Profile Button -->
            @if($profiles->count() < 5)
            <a href="{{ route('profiles.create') }}" class="group">
                <div class="mx-auto w-32 h-32 rounded-lg border-2 border-dashed border-gray-700 group-hover:border-codeflix-primary flex items-center justify-center transition-all">
                    <i class="fa-solid fa-plus text-4xl text-gray-700 group-hover:text-codeflix-primary transition-colors"></i>
                </div>
                <p class="mt-3 text-gray-400 group-hover:text-white font-medium transition-colors">Add Profile</p>
            </a>
            @endif
        </div>

        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition">
            <i class="fa-solid fa-arrow-left"></i> Back to Home
        </a>
    </div>
</div>
@endsection
