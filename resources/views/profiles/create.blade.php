@extends('layouts.app-new')

@section('title', 'Create Profile')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20">
    <div class="max-w-md mx-auto px-4">
        <h1 class="font-outfit text-3xl font-bold text-white mb-8 text-center">Create Profile</h1>
        
        <form action="{{ route('profiles.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-gray-400 mb-2">Profile Name</label>
                <input type="text" name="name" required maxlength="255"
                       class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 p-4 bg-codeflix-card rounded-lg">
                <input type="checkbox" name="is_kids" id="is_kids" class="rounded border-gray-700 text-yellow-500 focus:ring-yellow-500">
                <label for="is_kids" class="text-white">
                    <span class="font-medium">Kids Profile</span>
                    <span class="block text-sm text-gray-400">Only show content rated for children</span>
                </label>
            </div>

            <div>
                <label class="block text-gray-400 mb-2">Profile PIN (optional)</label>
                <input type="password" name="pin" maxlength="4" pattern="[0-9]{4}"
                       placeholder="4-digit PIN"
                       class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                <p class="text-sm text-gray-500 mt-1">Lock this profile with a 4-digit PIN</p>
                @error('pin')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('profiles.index') }}" 
                   class="flex-1 py-3 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-lg text-center transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 py-3 bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium rounded-lg transition">
                    Create Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
