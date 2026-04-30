{{-- Mobile Bottom Navigation --}}
{{-- Include in layouts/app.blade.php before closing body tag --}}

<nav class="fixed bottom-0 left-0 right-0 z-40 bg-codeflix-darker/95 backdrop-blur-xl border-t border-gray-800 md:hidden safe-area-inset-bottom">
    <div class="flex items-center justify-around py-2">
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->routeIs('home') || request()->routeIs('movies.index') ? 'text-codeflix-primary' : 'text-gray-400' }}">
            <i class="fa-solid fa-home text-xl"></i>
            <span class="text-xs">Beranda</span>
        </a>
        
        <a href="{{ route('movies.search') }}" class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->routeIs('movies.search') ? 'text-codeflix-primary' : 'text-gray-400' }}">
            <i class="fa-solid fa-search text-xl"></i>
            <span class="text-xs">Cari</span>
        </a>
        
        @auth
        <a href="{{ route('watchlist.index') }}" class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->routeIs('watchlist.*') ? 'text-codeflix-primary' : 'text-gray-400' }}">
            <i class="fa-solid fa-bookmark text-xl"></i>
            <span class="text-xs">Daftar Saya</span>
        </a>
        
        <a href="{{ route('reviews.history.index') }}" class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->routeIs('reviews.history.*') ? 'text-codeflix-primary' : 'text-gray-400' }}">
            <i class="fa-solid fa-star-half-stroke text-xl"></i>
            <span class="text-xs">Ulasan</span>
        </a>
        
        <a href="{{ route('settings.index') }}" class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->routeIs('settings.*') ? 'text-codeflix-primary' : 'text-gray-400' }}">
            <i class="fa-solid fa-user text-xl"></i>
            <span class="text-xs">Profil</span>
        </a>
        @else
        <a href="{{ route('series.index') }}" class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->routeIs('series.*') ? 'text-codeflix-primary' : 'text-gray-400' }}">
            <i class="fa-solid fa-tv text-xl"></i>
            <span class="text-xs">Serial</span>
        </a>
        
        <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 px-4 py-2 text-gray-400">
            <i class="fa-solid fa-right-to-bracket text-xl"></i>
            <span class="text-xs">Masuk</span>
        </a>
        @endauth
    </div>
</nav>

{{-- Add padding to body content for mobile nav --}}
<style>
    @media (max-width: 767px) {
        body {
            padding-bottom: 70px;
        }
    }
    .safe-area-inset-bottom {
        padding-bottom: env(safe-area-inset-bottom, 0);
    }
</style>
