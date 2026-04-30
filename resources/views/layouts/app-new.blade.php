<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Codeflix') - Stream Movies & Series</title>
    <meta name="description" content="@yield('description', 'Watch unlimited movies and TV shows on Codeflix. Start your free trial today.')">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:title" content="@yield('og_title', 'Codeflix - Stream Movies & Series')">
    <meta property="og:description" content="@yield('og_description', 'Watch unlimited movies and TV shows')">
    <meta property="og:image" content="@yield('og_image', asset('assets/img/codeflix_logo.png'))">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

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
                        'jakarta': ['Plus Jakarta Sans', 'sans-serif'],
                        'outfit': ['Outfit', 'sans-serif'],
                        'poppins': ['Poppins', 'sans-serif'],
                        'space': ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        /* Base styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0A0A0A;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #141414;
        }
        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #1ABC9C;
        }

        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-duration: 150ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Card hover effects */
        .movie-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .movie-card:hover {
            transform: scale(1.05);
            z-index: 10;
        }

        /* Toast animations */
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .toast-enter { animation: slideIn 0.3s ease-out; }
        .toast-exit { animation: slideOut 0.3s ease-out; }

        /* Loading skeleton */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .skeleton {
            background: linear-gradient(90deg, #1A1A1A 25%, #2A2A2A 50%, #1A1A1A 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
    </style>

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="bg-codeflix-dark text-white min-h-screen flex flex-col antialiased">
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-20 right-4 z-50 flex flex-col gap-3">
        @if(session('success'))
            <div class="toast-enter bg-codeflix-card border-l-4 border-green-500 px-4 py-3 rounded-lg shadow-xl flex items-center gap-3">
                <i class="fa-solid fa-check-circle text-green-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-gray-400 hover:text-white">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="toast-enter bg-codeflix-card border-l-4 border-red-500 px-4 py-3 rounded-lg shadow-xl flex items-center gap-3">
                <i class="fa-solid fa-exclamation-circle text-red-500 text-xl"></i>
                <span class="font-medium">{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-gray-400 hover:text-white">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        @endif
        @if(session('warning'))
            <div class="toast-enter bg-codeflix-card border-l-4 border-yellow-500 px-4 py-3 rounded-lg shadow-xl flex items-center gap-3">
                <i class="fa-solid fa-exclamation-triangle text-yellow-500 text-xl"></i>
                <span class="font-medium">{{ session('warning') }}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-gray-400 hover:text-white">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Navbar -->
    @include('components.navbar-new')

    <!-- Main Content -->
    <main class="flex-grow pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-codeflix-darker border-t border-gray-800 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-2 md:col-span-1">
                    <img src="{{ asset('assets/img/codeflix_logo.png') }}" alt="Codeflix" class="h-8 mb-4">
                    <p class="text-codeflix-muted text-sm">
                        Tonton film dan acara TV tanpa batas di perangkat apa pun.
                    </p>
                </div>
                
                <!-- Links -->
                <div>
                    <h4 class="font-outfit font-semibold text-white mb-4">Jelajahi</h4>
                    <ul class="space-y-2 text-sm text-codeflix-muted">
                        <li><a href="{{ route('movies.index') }}" class="hover:text-codeflix-primary">Film</a></li>
                        <li><a href="{{ route('series.index') }}" class="hover:text-codeflix-primary">Serial</a></li>
                        <li><a href="{{ route('watchlist.index') }}" class="hover:text-codeflix-primary">Daftar Saya</a></li>
                        <li><a href="{{ route('movies.search') }}" class="hover:text-codeflix-primary">Cari</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-outfit font-semibold text-white mb-4">Akun</h4>
                    <ul class="space-y-2 text-sm text-codeflix-muted">
                        <li><a href="{{ route('profiles.index') }}" class="hover:text-codeflix-primary">Profil</a></li>
                        <li><a href="{{ route('settings.index') }}" class="hover:text-codeflix-primary">Pengaturan</a></li>
                        <li><a href="{{ route('reviews.history.index') }}" class="hover:text-codeflix-primary">Cerita Ulasan</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-outfit font-semibold text-white mb-4">Lainnya</h4>
                    <ul class="space-y-2 text-sm text-codeflix-muted">
                        <li><a href="{{ route('referral.index') }}" class="hover:text-codeflix-primary">Undang Teman</a></li>
                        <li><a href="mailto:support@codeflix.com" class="hover:text-codeflix-primary">Hubungi Kami</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-codeflix-primary">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-codeflix-primary">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-codeflix-muted text-sm">
                <p>&copy; {{ date('Y') }} Codeflix by RENDRADEV. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Custom Scripts -->
    <script>
        // Auto-dismiss toasts after 5 seconds
        document.querySelectorAll('#toast-container > div').forEach(toast => {
            setTimeout(() => {
                toast.classList.add('toast-exit');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        });

        // Toast function for JS
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const icons = {
                success: 'fa-check-circle text-green-500',
                error: 'fa-exclamation-circle text-red-500',
                warning: 'fa-exclamation-triangle text-yellow-500',
                info: 'fa-info-circle text-blue-500'
            };
            const borders = {
                success: 'border-green-500',
                error: 'border-red-500',
                warning: 'border-yellow-500',
                info: 'border-blue-500'
            };
            
            const toast = document.createElement('div');
            toast.className = `toast-enter bg-codeflix-card border-l-4 ${borders[type]} px-4 py-3 rounded-lg shadow-xl flex items-center gap-3`;
            toast.innerHTML = `
                <i class="fa-solid ${icons[type]} text-xl"></i>
                <span class="font-medium">${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-gray-400 hover:text-white">
                    <i class="fa-solid fa-times"></i>
                </button>
            `;
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('toast-exit');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        };

        // Toggle Watchlist function
        window.toggleWatchlist = function(movieId, btn) {
            fetch(`/watchlist/${movieId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = btn.querySelector('i');
                    if (data.in_watchlist) {
                        btn.classList.add('bg-codeflix-primary', 'opacity-100');
                        icon.classList.remove('fa-plus');
                        icon.classList.add('fa-check');
                        showToast('Added to My List', 'success');
                    } else {
                        btn.classList.remove('bg-codeflix-primary', 'opacity-100');
                        icon.classList.remove('fa-check');
                        icon.classList.add('fa-plus');
                        showToast('Removed from My List', 'info');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Please login to add to watchlist', 'warning');
            });
        };
    </script>

    @stack('scripts')
</body>

</html>
