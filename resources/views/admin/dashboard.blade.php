@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Title Section -->
    <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800">Panel Kendali <span class="text-golf-orange">Administrator</span></h1>
            <p class="text-sm text-slate-400 mt-1">Kelola data kompetisi turnamen golf, daftar par lapangan, data profil pegolf, serta memantau omzet pesanan.</p>
        </div>
        
        <div class="flex items-center space-x-2">
            <span class="bg-golf-orangelight text-golf-orange text-xs font-bold px-3.5 py-1.5 rounded-full border border-golf-orange/20 uppercase tracking-widest">
                <i class="fa-solid fa-user-shield mr-1"></i> Mode Admin Aktif
            </span>
        </div>
    </div>

    <!-- Quick Stats Grid (White dominant cards with orange accents) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- 1. Total Events -->
        <div class="premium-card p-6 relative overflow-hidden bg-white border border-slate-100 shadow-md">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-golf-orangelight/30 rounded-full blur-xl"></div>
            <div class="flex justify-between items-center relative z-10">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Turnamen</span>
                    <span class="text-3xl font-black text-slate-800 block">{{ $totalEvents }}</span>
                </div>
                <div class="bg-golf-orangelight p-3.5 rounded-2xl text-golf-orange">
                    <i class="fa-solid fa-trophy text-2xl"></i>
                </div>
            </div>
            <a href="{{ route('admin.events.index') }}" class="text-[10px] text-golf-orange hover:underline font-bold uppercase tracking-wider mt-4 block relative z-10">Kelola Turnamen &rarr;</a>
        </div>

        <!-- 2. Total Players -->
        <div class="premium-card p-6 relative overflow-hidden bg-white border border-slate-100 shadow-md">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-golf-orangelight/30 rounded-full blur-xl"></div>
            <div class="flex justify-between items-center relative z-10">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pegolf Terdaftar</span>
                    <span class="text-3xl font-black text-slate-800 block">{{ $totalPlayers }}</span>
                </div>
                <div class="bg-golf-orangelight p-3.5 rounded-2xl text-golf-orange">
                    <i class="fa-solid fa-users-line text-2xl"></i>
                </div>
            </div>
            <a href="{{ route('admin.players.index') }}" class="text-[10px] text-golf-orange hover:underline font-bold uppercase tracking-wider mt-4 block relative z-10">Kelola Pegolf &rarr;</a>
        </div>

        <!-- 3. Total Orders -->
        <div class="premium-card p-6 relative overflow-hidden bg-white border border-slate-100 shadow-md">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-golf-orangelight/30 rounded-full blur-xl"></div>
            <div class="flex justify-between items-center relative z-10">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kuantitas Order</span>
                    <span class="text-3xl font-black text-slate-800 block">{{ $totalOrders }}</span>
                </div>
                <div class="bg-golf-orangelight p-3.5 rounded-2xl text-golf-orange">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                </div>
            </div>
            <span class="text-[10px] text-slate-400 font-semibold mt-4 block relative z-10 uppercase tracking-wider">Official & P2P Orders</span>
        </div>

        <!-- 4. Total Revenue -->
        <div class="premium-card p-6 relative overflow-hidden bg-white border border-slate-100 shadow-md">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-golf-orangelight/30 rounded-full blur-xl"></div>
            <div class="flex justify-between items-center relative z-10">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Omzet Transaksi</span>
                    <span class="text-2xl font-black text-slate-800 block">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
                <div class="bg-golf-orangelight p-3.5 rounded-2xl text-golf-orange">
                    <i class="fa-solid fa-hand-holding-dollar text-2xl"></i>
                </div>
            </div>
            <span class="text-[10px] text-slate-400 font-semibold mt-4 block relative z-10 uppercase tracking-wider">Perputaran Uang Bursa</span>
        </div>
    </div>

    <!-- Quick Navigation Panels & Recent Activity -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Navigation Panel Links (Left col span 2) -->
        <div class="md:col-span-2 space-y-6">
            <div class="premium-card p-6 shadow-xl bg-white border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-3 mb-6 uppercase tracking-wider">
                    <i class="fa-solid fa-gears text-golf-orange mr-2"></i> Menu Pintasan Administrasi
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Turnamen Link -->
                    <a href="{{ route('admin.events.index') }}" class="bg-slate-50 border border-slate-200 hover:border-golf-orange/30 p-5 rounded-2xl hover:bg-golf-orangelight/20 transition-all flex items-start space-x-4">
                        <div class="bg-golf-orange text-white p-3 rounded-xl shrink-0"><i class="fa-solid fa-trophy text-lg"></i></div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Kelola Turnamen</h4>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tambah event, kelola par hole, daftarkan pemain, dan live scoring.</p>
                        </div>
                    </a>

                    <!-- Pemain Link -->
                    <a href="{{ route('admin.players.index') }}" class="bg-slate-50 border border-slate-200 hover:border-golf-orange/30 p-5 rounded-2xl hover:bg-golf-orangelight/20 transition-all flex items-start space-x-4">
                        <div class="bg-golf-orange text-white p-3 rounded-xl shrink-0"><i class="fa-solid fa-user-plus text-lg"></i></div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Kelola Profil Pegolf</h4>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tambah data profil pemain bintang, unggah foto, dan biografi pegolf.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent events status tracker -->
        <div class="space-y-6">
            <div class="premium-card p-6 shadow-xl bg-white border border-slate-100">
                <h3 class="text-md font-bold text-slate-800 border-b border-slate-200 pb-3 mb-4 uppercase">Status Turnamen Aktif</h3>

                @if($recentEvents->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentEvents as $event)
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3 last:border-0 last:pb-0">
                                <div class="space-y-0.5 pr-2">
                                    <h4 class="text-xs font-bold text-slate-800 truncate max-w-[130px]">{{ $event->title }}</h4>
                                    <span class="text-[10px] text-slate-400 block"><i class="fa-regular fa-calendar text-golf-orange mr-1"></i> {{ $event->date->format('d M Y') }}</span>
                                </div>
                                <div>
                                    @if($event->status === 'ongoing')
                                        <span class="bg-red-50 text-red-500 border border-red-200 text-[8px] font-bold px-2 py-0.5 rounded-full uppercase animate-pulse">Ongoing</span>
                                    @elseif($event->status === 'finished')
                                        <span class="bg-slate-100 text-slate-600 border border-slate-200 text-[8px] font-bold px-2 py-0.5 rounded-full uppercase">Finished</span>
                                    @else
                                        <span class="bg-orange-50 text-golf-orange border border-orange-200 text-[8px] font-bold px-2 py-0.5 rounded-full uppercase">Upcoming</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 text-center py-4">Belum ada kompetisi terdaftar.</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
