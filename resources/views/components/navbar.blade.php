<!-- New Navbar with Tailwind -->
<nav class="fixed top-0 left-0 right-0 z-40 bg-gradient-to-b from-black/80 to-transparent backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('assets/img/codeflix_logo.png') }}" alt="Codeflix" class="h-8">
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="font-medium text-white hover:text-codeflix-primary {{ request()->routeIs('home') ? 'text-codeflix-primary' : '' }}">
                    Home
                </a>
                <a href="{{ route('movies.index') }}" class="font-medium text-gray-300 hover:text-codeflix-primary {{ request()->routeIs('movies.*') ? 'text-codeflix-primary' : '' }}">
                    Movies
                </a>

                <!-- Categories Dropdown -->
                <div class="relative group">
                    <button class="font-medium text-gray-300 hover:text-codeflix-primary flex items-center gap-1">
                        Categories
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute top-full left-0 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="bg-codeflix-card rounded-xl shadow-2xl border border-gray-800 p-4 min-w-[300px] grid grid-cols-2 gap-2">
                            @php
                                $categories = \App\Models\Category::all();
                            @endphp
                            @foreach($categories as $category)
                                <a href="{{ route('categories.show', $category->slug) }}" 
                                   class="px-3 py-2 rounded-lg text-gray-300 hover:bg-codeflix-primary/20 hover:text-codeflix-primary">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-4">
                <!-- Search -->
                <form action="{{ route('movies.search') }}" method="GET" class="hidden md:block relative">
                    <input type="text" name="q" value="{{ request('q') }}" 
                           placeholder="Search movies..."
                           class="w-64 bg-gray-900/50 border border-gray-700 rounded-full px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-codeflix-primary">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </form>

                @auth
                    <!-- Notifications -->
                    <div class="relative group">
                        <button class="text-gray-300 hover:text-white relative">
                            <i class="fa-solid fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-codeflix-secondary rounded-full"></span>
                        </button>
                        <div class="absolute top-full right-0 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="bg-codeflix-card rounded-xl shadow-2xl border border-gray-800 p-4 w-80">
                                <h4 class="font-outfit font-semibold text-white mb-3">Notifications</h4>
                                <div class="space-y-3 max-h-64 overflow-y-auto">
                                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-800">
                                        <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded">
                                        <div>
                                            <p class="text-sm text-white">New movie added: <span class="text-codeflix-primary">The Matrix</span></p>
                                            <p class="text-xs text-gray-500">2 hours ago</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-codeflix-primary to-emerald-600 flex items-center justify-center">
                                <span class="font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                        </button>
                        <div class="absolute top-full right-0 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="bg-codeflix-card rounded-xl shadow-2xl border border-gray-800 py-2 w-56">
                                <div class="px-4 py-3 border-b border-gray-800">
                                    <p class="font-medium text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-400">{{ Auth::user()->email }}</p>
                                </div>
                                
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-codeflix-primary">
                                        <i class="fa-solid fa-gauge-high w-5"></i>
                                        Admin Dashboard
                                    </a>
                                @endif
                                
                                <a href="#" class="flex items-center gap-3 px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-codeflix-primary">
                                    <i class="fa-solid fa-user w-5"></i>
                                    Manage Profiles
                                </a>
                                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-codeflix-primary">
                                    <i class="fa-solid fa-cog w-5"></i>
                                    Settings
                                </a>
                                
                                <div class="border-t border-gray-800 mt-2 pt-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-red-500">
                                            <i class="fa-solid fa-sign-out-alt w-5"></i>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="font-medium text-gray-300 hover:text-white">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium px-4 py-2 rounded-lg">
                        Get Started
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-white" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-codeflix-darker border-t border-gray-800">
        <div class="px-4 py-4 space-y-3">
            <a href="{{ route('home') }}" class="block py-2 text-white">Home</a>
            <a href="{{ route('movies.index') }}" class="block py-2 text-gray-300">Movies</a>

            
            <!-- Mobile Search -->
            <form action="{{ route('movies.search') }}" method="GET" class="pt-2">
                <input type="text" name="q" placeholder="Search..." 
                       class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white">
            </form>
        </div>
    </div>
</nav>
