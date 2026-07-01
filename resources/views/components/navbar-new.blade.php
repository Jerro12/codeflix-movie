<!-- New Navbar with Tailwind -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-b from-black/90 to-transparent backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('assets/img/codeflix_logo.png') }}" alt="Codeflix" class="h-8">
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="font-medium text-white hover:text-codeflix-primary {{ request()->routeIs('home') ? 'text-codeflix-primary' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('movies.index') }}" class="font-medium text-gray-300 hover:text-codeflix-primary {{ request()->routeIs('movies.*') ? 'text-codeflix-primary' : '' }}">
                    Film
                </a>

                <!-- Categories Dropdown -->
                <div class="relative group">
                    <button class="font-medium text-gray-300 hover:text-codeflix-primary flex items-center gap-1">
                        Kategori
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

                <!-- Research Mode Dropdown -->
                @auth
                <div class="relative group">
                    <button class="font-medium text-yellow-500 hover:text-yellow-400 flex items-center gap-1">
                        <i class="fa-solid fa-flask text-xs"></i>
                        Mode Riset (K={{ request('k', 5) }})
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute top-full left-0 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="bg-codeflix-card rounded-xl shadow-2xl border border-gray-800 p-4 min-w-[200px] flex flex-col gap-1">
                            <p class="text-[10px] text-gray-500 uppercase font-bold px-3 mb-1">Atur Parameter K</p>
                            @foreach([3, 5, 10, 20] as $kVal)
                                <a href="{{ request()->fullUrlWithQuery(['k' => $kVal]) }}" 
                                   class="px-3 py-2 rounded-lg text-sm {{ request('k', 5) == $kVal ? 'bg-yellow-500/20 text-yellow-500' : 'text-gray-300' }} hover:bg-yellow-500/10 transition">
                                    K = {{ $kVal }} {{ $kVal == 5 ? '(Default)' : '' }}
                                </a>
                            @endforeach
                            <div class="border-t border-gray-800 mt-2 pt-2">
                                <a href="{{ route('movies.debug') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs text-yellow-500 hover:bg-yellow-500/10 transition font-bold">
                                    <i class="fa-solid fa-calculator"></i>
                                    Lihat Proses Hitung (Debug)
                                </a>
                                <p class="text-[9px] text-gray-500 leading-tight px-3 mt-1 italic">
                                    Ubah K untuk menguji akurasi algoritma KNN (Bab 4 Skripsi).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-4">
                <!-- Search -->
                <form action="{{ route('movies.search') }}" method="GET" class="hidden md:block relative">
                    <input type="text" name="q" value="{{ request('q') }}" 
                           placeholder="Cari film..."
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
                                <h4 class="font-outfit font-semibold text-white mb-3">Notifikasi</h4>
                                <div class="space-y-3 max-h-64 overflow-y-auto">
                                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-800">
                                        <div class="w-10 h-10 rounded bg-gradient-to-br from-codeflix-primary to-emerald-600 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-film text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-white">Selamat datang di <span class="text-codeflix-primary">Codeflix</span>! Mulai jelajahi film sekarang.</p>
                                            <p class="text-xs text-gray-500">Baru saja</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-800">
                                        <div class="w-10 h-10 rounded bg-gradient-to-br from-codeflix-primary to-emerald-600 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-film text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-white">Film baru ditambahkan: <span class="text-codeflix-primary">The Matrix Resurrections</span></p>
                                            <p class="text-xs text-gray-500">2 jam yang lalu</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('reviews.history.index') }}" class="block text-center text-sm text-codeflix-primary hover:underline mt-3 pt-3 border-t border-gray-800">
                                    Lihat Cerita Ulasan
                                </a>
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
                                        Dasbor Admin
                                    </a>
                                @endif
                                
                                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-codeflix-primary">
                                    <i class="fa-solid fa-cog w-5"></i>
                                    Pengaturan Akun
                                </a>
                                <a href="{{ route('reviews.history.index') }}" class="flex items-center gap-3 px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-codeflix-primary">
                                    <i class="fa-solid fa-star-half-stroke w-5"></i>
                                    Cerita Ulasan
                                </a>
                                
                                <div class="border-t border-gray-800 mt-2 pt-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-red-500">
                                            <i class="fa-solid fa-sign-out-alt w-5"></i>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="font-medium text-gray-300 hover:text-white hidden sm:inline-block">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium px-4 py-2 rounded-lg hidden sm:inline-flex items-center justify-center">
                        Mulai
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
            <a href="{{ route('home') }}" class="block py-2 text-white hover:text-codeflix-primary transition">Beranda</a>
            <a href="{{ route('movies.index') }}" class="block py-2 text-gray-300 hover:text-codeflix-primary transition">Film</a>

            
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-300 hover:text-codeflix-primary transition">Dasbor Admin</a>
                @endif
                <a href="{{ route('settings.index') }}" class="block py-2 text-gray-300 hover:text-codeflix-primary transition">Pengaturan Akun</a>
                <a href="{{ route('reviews.history.index') }}" class="block py-2 text-gray-300 hover:text-codeflix-primary transition">Cerita Ulasan</a>

                <!-- Mode Riset Mobile Section -->
                <div class="pt-3 pb-2 border-t border-gray-800">
                    <p class="text-xs text-yellow-500 font-bold flex items-center gap-1.5 mb-2">
                        <i class="fa-solid fa-flask"></i> Mode Riset (K={{ request('k', 5) }})
                    </p>
                    <div class="grid grid-cols-4 gap-2 mb-2">
                        @foreach([3, 5, 10, 20] as $kVal)
                            <a href="{{ request()->fullUrlWithQuery(['k' => $kVal]) }}" 
                               class="text-center py-1.5 rounded-lg text-xs {{ request('k', 5) == $kVal ? 'bg-yellow-500/20 text-yellow-500 font-bold border border-yellow-500/30' : 'bg-gray-900 text-gray-300 hover:bg-gray-800' }} transition">
                                K = {{ $kVal }}
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ route('movies.debug') }}" class="flex items-center gap-2 py-2 text-xs text-yellow-500 hover:underline">
                        <i class="fa-solid fa-calculator"></i>
                        Lihat Proses Hitung (Debug)
                    </a>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="pt-2 border-t border-gray-800">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 text-red-500 hover:text-red-400 transition">Keluar</button>
                </form>
            @else
                <div class="flex flex-col gap-2 pt-2 border-t border-gray-800">
                    <a href="{{ route('login') }}" class="block text-center py-2.5 text-gray-300 hover:text-white bg-gray-800 rounded-lg transition">Masuk</a>
                    <a href="{{ route('register') }}" class="block text-center py-2.5 text-white bg-codeflix-primary hover:bg-codeflix-primary/80 rounded-lg font-medium transition">Mulai</a>
                </div>
            @endauth
            
            <!-- Mobile Search -->
            <form action="{{ route('movies.search') }}" method="GET" class="pt-2 border-t border-gray-800">
                <div class="relative">
                    <input type="text" name="q" placeholder="Cari..." 
                           class="w-full bg-gray-900 border border-gray-700 rounded-lg pl-4 pr-10 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-codeflix-primary">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>
