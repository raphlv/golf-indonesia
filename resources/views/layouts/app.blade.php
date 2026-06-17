<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Golf Indonesia') - Portal & Live Scoring</title>
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        golf: {
                            light: '#FFFFFF',
                            bg: '#F8FAFC',
                            orange: '#FF6B00',
                            orangelight: '#FFF1E6',
                            orangedark: '#E05300',
                            slate: '#1E293B',
                            border: '#E2E8F0',
                        }
                    },
                    fontFamily: {
                        sans: ['Outfit', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #F8FAFC;
            color: #1E293B;
        }
        .premium-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 20px -2px rgba(148, 163, 184, 0.08), 0 2px 8px -1px rgba(148, 163, 184, 0.04);
            border-radius: 24px;
        }
        .premium-card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-card-hover:hover {
            border-color: rgba(255, 107, 0, 0.3);
            box-shadow: 0 12px 30px -4px rgba(255, 107, 0, 0.08), 0 4px 12px -2px rgba(255, 107, 0, 0.04);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="bg-golf-orange p-2 rounded-xl text-white group-hover:rotate-12 transition-transform duration-300">
                            <i class="fa-solid fa-golf-ball-tee text-2xl"></i>
                        </div>
                        <div>
                            <span class="text-xl font-extrabold text-slate-800 tracking-wider block">GOLF<span class="text-golf-orange">INDONESIA</span></span>
                            <span class="text-[10px] text-slate-400 tracking-widest block uppercase -mt-1">Live Scoring & Marketplace</span>
                        </div>
                    </a>
                </div>

                <!-- Navlinks -->
                <nav class="hidden md:flex space-x-8 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-slate-600 hover:text-golf-orange transition-colors {{ request()->routeIs('home') ? 'text-golf-orange border-b-2 border-golf-orange pb-1' : '' }}">
                        <i class="fa-solid fa-calendar-days mr-1.5"></i> Event
                    </a>
                    <a href="{{ route('marketplace.index') }}" class="text-slate-600 hover:text-golf-orange transition-colors {{ request()->routeIs('marketplace.index') ? 'text-golf-orange border-b-2 border-golf-orange pb-1' : '' }}">
                        <i class="fa-solid fa-book-open-reader mr-1.5"></i> Yardage Marketplace
                    </a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-golf-orange transition-colors {{ request()->routeIs('admin.*') ? 'text-golf-orange border-b-2 border-golf-orange pb-1' : '' }}">
                                <i class="fa-solid fa-sliders mr-1.5"></i> Panel Admin
                            </a>
                        @endif
                    @endauth
                </nav>

                <!-- Auth Buttons & User Wallet Info -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Wallet Balance -->
                        <div class="hidden sm:flex items-center space-x-2 bg-golf-orangelight border border-golf-orange/30 px-3.5 py-1.5 rounded-full">
                            <i class="fa-solid fa-wallet text-golf-orange"></i>
                            <span class="text-xs text-slate-500">Saldo:</span>
                            <span class="text-sm font-bold text-golf-orange">Rp{{ number_format(auth()->user()->current_balance, 0, ',', '.') }}</span>
                        </div>

                        <!-- User Profile display -->
                        <div class="flex items-center space-x-3 border-l border-slate-200 pl-4">
                            <div class="text-right">
                                <span class="block text-sm font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</span>
                                <span class="block text-[10px] text-golf-orange uppercase tracking-wider font-bold">{{ auth()->user()->role }}</span>
                            </div>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-50 hover:bg-red-100 border border-red-200/50 p-2 rounded-xl text-red-500 hover:text-red-700 transition-all shadow-sm" title="Keluar">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="text-slate-600 hover:text-slate-800 text-sm font-semibold px-4 py-2 rounded-xl transition-all">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-golf-orange/10">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Alerts Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
        @if(session('success'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-700 rounded-2xl bg-green-50 border border-green-200 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check text-xl mr-3 text-green-500"></i>
                <div>
                    <span class="font-bold">Sukses!</span> {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center p-4 mb-4 text-sm text-red-700 rounded-2xl bg-red-50 border border-red-200 shadow-sm" role="alert">
                <i class="fa-solid fa-triangle-exclamation text-xl mr-3 text-red-500"></i>
                <div>
                    <span class="font-bold">Gagal!</span> {{ session('error') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 py-10 mt-16 text-slate-400 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="bg-golf-orange p-1.5 rounded-lg text-white">
                            <i class="fa-solid fa-golf-ball-tee text-lg"></i>
                        </div>
                        <span class="text-md font-extrabold text-white tracking-wider uppercase">GOLF<span class="text-golf-orange">INDONESIA</span></span>
                    </div>
                    <p class="text-slate-300 leading-relaxed text-xs">
                        Portal Scoring Real-time dan Bursa Marketplace Yardage Book Resmi Turnamen Golf Indonesia.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4 tracking-wider uppercase text-xs">Tautan Penting</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-golf-orange transition-colors">Daftar Event & Kompetisi</a></li>
                        <li><a href="{{ route('marketplace.index') }}" class="hover:text-golf-orange transition-colors">Bursa Yardage Book</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-golf-orange transition-colors">Masuk Akun</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4 tracking-wider uppercase text-xs">Tentang Kami</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Dikembangkan untuk menyatukan komunitas pegolf Indonesia, menyediakan live standings kelas dunia dan sistem barter informasi rute lapangan terintegrasi.
                    </p>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-8 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; 2026 Golf Indonesia. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex space-x-4 mt-4 sm:mt-0">
                    <a href="#" class="hover:text-golf-orange"><i class="fa-brands fa-instagram text-lg"></i></a>
                    <a href="#" class="hover:text-golf-orange"><i class="fa-brands fa-youtube text-lg"></i></a>
                    <a href="#" class="hover:text-golf-orange"><i class="fa-brands fa-facebook-f text-lg"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
