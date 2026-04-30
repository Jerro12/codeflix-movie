<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Admin - @yield('title', 'Dashboard') | Codeflix</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        codeflix: {
                            primary: '#1ABC9C',
                            secondary: '#E50914',
                            dark: '#0A0A0A',
                            darker: '#141414',
                            card: '#1A1A1A',
                            muted: '#8899A6',
                        }
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                        'outfit': ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-codeflix-dark text-white min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-codeflix-darker border-r border-gray-800 fixed h-full">
            <div class="p-6">
                <a href="{{ route('home') }}" class="block">
                    <img src="{{ asset('assets/img/codeflix_logo.png') }}" alt="Codeflix" class="h-8 mb-2">
                    <span class="text-xs bg-codeflix-primary/20 text-codeflix-primary px-2 py-0.5 rounded inline-block">Admin Panel</span>
                </a>
            </div>

            <nav class="px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-codeflix-primary text-white' : 'text-gray-400 hover:bg-codeflix-card hover:text-white' }}">
                    <i class="fa-solid fa-gauge-high w-5"></i>
                    <span>Dasbor</span>
                </a>
                <a href="{{ route('admin.movies.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.movies.*') ? 'bg-codeflix-primary text-white' : 'text-gray-400 hover:bg-codeflix-card hover:text-white' }}">
                    <i class="fa-solid fa-film w-5"></i>
                    <span>Film</span>
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-codeflix-primary text-white' : 'text-gray-400 hover:bg-codeflix-card hover:text-white' }}">
                    <i class="fa-solid fa-users w-5"></i>
                    <span>Pengguna</span>
                </a>
                
                <div class="border-t border-gray-800 my-4"></div>
                
                <a href="{{ route('home') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-codeflix-card hover:text-white transition">
                    <i class="fa-solid fa-arrow-left w-5"></i>
                    <span>Kembali ke Situs</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-codeflix-primary rounded-full flex items-center justify-center">
                        <span class="font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <!-- Top Bar -->
            <header class="bg-codeflix-darker border-b border-gray-800 px-8 py-4 sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <h1 class="font-outfit text-xl font-semibold">@yield('title', 'Dasbor')</h1>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-400">{{ now()->format('l, F j, Y') }}</span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg flex items-center gap-3">
                    <i class="fa-solid fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg flex items-center gap-3">
                    <i class="fa-solid fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>

</html>
