@extends('layouts.app')

@section('title', 'Beranda Utama')

@section('content')
<!-- Hero Section (Premium Dark Contrast Slate with vibrant Orange Accents) -->
<div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-950 text-white py-20 px-4 overflow-hidden border-b border-golf-orange/20 shadow-lg">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#FF6B00_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute right-0 bottom-0 w-96 h-96 bg-golf-orange/10 rounded-full blur-3xl -mr-20 -mb-20"></div>
    <div class="absolute left-1/3 top-10 w-72 h-72 bg-orange-600/10 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
        <div class="md:w-3/5 text-left space-y-6">
            <div class="inline-flex items-center space-x-2 bg-golf-orange/10 border border-golf-orange/30 px-3.5 py-1.5 rounded-full text-xs font-bold text-golf-orange tracking-widest uppercase">
                <i class="fa-solid fa-circle-play text-red-500 animate-pulse"></i>
                <span>Pusat Informasi & Scoring Golf Indonesia</span>
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white leading-tight">
                Rasakan Sensasi Turnamen <span class="bg-gradient-to-r from-golf-orange to-orange-400 bg-clip-text text-transparent">Secara Nyata</span>
            </h1>
            <p class="text-slate-300 text-sm sm:text-md leading-relaxed max-w-xl">
                Pantau klasemen turnamen ongoing hole-by-hole, telusuri arsip pemenang turnamen bergengsi, dan pesan Buku Panduan Lapangan (Yardage Book) taktis Anda.
            </p>
            <div class="flex flex-wrap gap-4 pt-2">
                <a href="#ongoing" class="bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-golf-orange/20 text-sm flex items-center">
                    <i class="fa-solid fa-square-poll-horizontal mr-2"></i> Lihat Live Skor
                </a>
                <a href="{{ route('marketplace.index') }}" class="bg-slate-800 hover:bg-slate-700 border border-slate-700 px-6 py-3.5 rounded-xl transition-all text-sm font-semibold flex items-center text-white">
                    <i class="fa-solid fa-shop mr-2 text-golf-orange"></i> Buka Marketplace
                </a>
            </div>
        </div>
        
        <!-- Stats Card / Mascot -->
        <div class="md:w-2/5 w-full">
            <div class="premium-card p-6 shadow-2xl relative border border-slate-800 bg-slate-900/90 text-white">
                <div class="flex items-center justify-between mb-4 border-b border-slate-800 pb-3">
                    <span class="text-xs font-bold text-golf-orange uppercase tracking-wider">Liga Berjalan Terkini</span>
                    <span class="bg-red-500 text-white text-[9px] font-extrabold px-2 py-0.5 rounded-full uppercase animate-pulse">Live Update</span>
                </div>
                
                @if($ongoingEvents->count() > 0)
                    @foreach($ongoingEvents as $event)
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-bold text-white leading-tight">{{ $event->title }}</h3>
                                <p class="text-xs text-slate-400 mt-1"><i class="fa-solid fa-location-dot mr-1"></i> {{ $event->location }}</p>
                            </div>
                            <div class="bg-slate-850/80 rounded-2xl p-4 border border-slate-800 flex justify-between items-center">
                                <div>
                                    <span class="text-[10px] text-slate-400 block uppercase font-medium">Prizepool</span>
                                    <span class="text-md font-bold text-golf-orange">Rp{{ number_format($event->prizepool, 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('events.show', $event->id) }}" class="bg-golf-orange hover:bg-golf-orangedark text-white text-xs font-bold px-4 py-2 rounded-xl transition-all flex items-center">
                                    Pantau <i class="fa-solid fa-chevron-right ml-1.5 text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-6 text-slate-400">
                        <i class="fa-solid fa-mug-hot text-slate-500 text-3xl mb-2"></i>
                        <p class="text-xs">Saat ini tidak ada kompetisi live yang sedang berjalan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Tournaments Section (Premium Light White-Dominant View) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 space-y-16">
    
    <!-- 1. ONGOING EVENTS -->
    <section id="ongoing" class="scroll-mt-24">
        <div class="flex items-center space-x-3 mb-8">
            <span class="w-3.5 h-3.5 rounded-full bg-red-500 block animate-pulse"></span>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-wide uppercase">Turnamen <span class="text-red-500">Ongoing</span></h2>
        </div>
        
        @if($ongoingEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ongoingEvents as $event)
                    <div class="premium-card premium-card-hover p-6 flex flex-col justify-between h-72 border border-red-200/50">
                        <div class="absolute top-0 right-0 bg-red-500 text-white font-extrabold text-[9px] px-3.5 py-1.5 rounded-bl-2xl uppercase tracking-widest animate-pulse">
                            LIVE SCORING
                        </div>
                        <div class="space-y-3">
                            <span class="text-xs text-slate-500 font-medium block"><i class="fa-regular fa-calendar mr-1 text-golf-orange"></i> {{ $event->date->format('d M Y') }}</span>
                            <h3 class="text-xl font-bold text-slate-800 hover:text-golf-orange transition-colors leading-snug">
                                <a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-400 line-clamp-2">{{ $event->description }}</p>
                        </div>
                        
                        <div class="border-t border-slate-100 pt-4 mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase">Prizepool</span>
                                <span class="text-sm font-extrabold text-golf-orange">Rp{{ number_format($event->prizepool, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('events.show', $event->id) }}" class="bg-red-50 hover:bg-red-100 border border-red-200 text-red-500 text-xs font-bold px-4 py-2.5 rounded-xl transition-all flex items-center">
                                <i class="fa-solid fa-trophy mr-1.5"></i> Masuk Leaderboard
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-3xl p-10 text-center">
                <i class="fa-solid fa-flag-checkered text-slate-300 text-4xl mb-3"></i>
                <p class="text-slate-500 text-sm">Tidak ada turnamen yang sedang berjalan saat ini. Silakan cek bagian turnamen mendatang.</p>
            </div>
        @endif
    </section>

    <!-- 2. UPCOMING EVENTS -->
    <section>
        <div class="flex items-center space-x-3 mb-8 border-b border-slate-200 pb-4">
            <div class="bg-golf-orangelight p-1.5 rounded-lg text-golf-orange">
                <i class="fa-regular fa-calendar-plus text-lg"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-wide uppercase">Turnamen <span class="text-golf-orange">Mendatang</span></h2>
        </div>

        @if($upcomingEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($upcomingEvents as $event)
                    <div class="premium-card premium-card-hover p-6 flex flex-col justify-between h-72">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-slate-500 font-medium block"><i class="fa-regular fa-calendar mr-1 text-golf-orange"></i> {{ $event->date->format('d M Y') }}</span>
                                <span class="bg-orange-50 text-golf-orange border border-orange-200 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">REGISTRASI</span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 hover:text-golf-orange transition-colors leading-snug">
                                <a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-400 line-clamp-2"><i class="fa-solid fa-location-dot mr-1"></i> {{ $event->location }}</p>
                            <p class="text-xs text-slate-400 line-clamp-2 mt-1">{{ $event->description }}</p>
                        </div>
                        
                        <div class="border-t border-slate-100 pt-4 mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase">Prizepool</span>
                                <span class="text-sm font-extrabold text-golf-orange">Rp{{ number_format($event->prizepool, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('events.show', $event->id) }}" class="bg-slate-50 border border-slate-200 text-slate-600 hover:bg-golf-orange hover:text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all">
                                Detail Event
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-3xl p-10 text-center">
                <i class="fa-regular fa-folder-open text-slate-300 text-4xl mb-3"></i>
                <p class="text-slate-500 text-sm">Belum ada daftar turnamen mendatang yang diumumkan.</p>
            </div>
        @endif
    </section>

    <!-- 3. FINISHED EVENTS -->
    <section>
        <div class="flex items-center space-x-3 mb-8 border-b border-slate-200 pb-4">
            <div class="bg-golf-orangelight p-1.5 rounded-lg text-golf-orange">
                <i class="fa-solid fa-circle-check text-lg"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-wide uppercase">Hasil Turnamen <span class="text-slate-400">Selesai</span></h2>
        </div>

        @if($finishedEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($finishedEvents as $event)
                    @php
                        $leaderboard = $event->getLeaderboard();
                        $championName = (count($leaderboard) > 0) ? $leaderboard[0]['player']->name : 'N/A';
                        $championScore = (count($leaderboard) > 0) ? $leaderboard[0]['relative_score'] : 0;
                        $formattedScore = $championScore < 0 ? $championScore : ($championScore > 0 ? '+' . $championScore : 'E');
                    @endphp
                    <div class="premium-card premium-card-hover p-6 flex flex-col justify-between h-72">
                        <div class="space-y-3">
                            <span class="text-xs text-slate-500 font-medium block"><i class="fa-regular fa-calendar mr-1 text-golf-orange"></i> {{ $event->date->format('d M Y') }}</span>
                            <h3 class="text-xl font-bold text-slate-800 hover:text-golf-orange transition-colors leading-snug">
                                <a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-400"><i class="fa-solid fa-location-dot mr-1"></i> {{ $event->location }}</p>
                            
                            <!-- Highlight Winner -->
                            <div class="bg-golf-orangelight border border-golf-orange/20 rounded-xl p-3 flex items-center justify-between mt-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-crown text-golf-orange text-sm"></i>
                                    <div>
                                        <span class="text-[9px] text-slate-500 block uppercase leading-none">Juara 1</span>
                                        <span class="text-xs font-bold text-slate-800">{{ $championName }}</span>
                                    </div>
                                </div>
                                <span class="bg-golf-orange text-white font-extrabold text-[10px] px-2 py-1 rounded-lg">
                                    {{ $formattedScore }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="border-t border-slate-100 pt-4 mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase">Prizepool</span>
                                <span class="text-sm font-extrabold text-golf-orange">Rp{{ number_format($event->prizepool, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('events.show', $event->id) }}" class="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl transition-all">
                                Lihat Klasemen Akhir
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-3xl p-10 text-center">
                <i class="fa-solid fa-ban text-slate-300 text-4xl mb-3"></i>
                <p class="text-slate-500 text-sm">Belum ada turnamen selesai yang tercatat di sistem.</p>
            </div>
        @endif
    </section>

    <!-- GOLFERS DIRECTORY -->
    <section class="border-t border-slate-200 pt-16">
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="text-xs font-extrabold text-golf-orange uppercase tracking-widest">Apresiasi Pegolf Nasional</span>
            <h2 class="text-3xl font-extrabold text-slate-800 mt-2">Daftar Pemain Bintang</h2>
            <p class="text-sm text-slate-400 mt-2">Pegolf profesional yang terdaftar dan berkompetisi aktif di sirkuit Golf Indonesia.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($featuredPlayers as $player)
                <a href="{{ route('players.show', $player->id) }}" class="premium-card premium-card-hover p-5 block relative group">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-golf-orangelight rounded-2xl overflow-hidden flex-shrink-0 border border-golf-orange/20 group-hover:border-golf-orange transition-colors flex items-center justify-center text-golf-orange">
                            <i class="fa-solid fa-user-tie text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-800 group-hover:text-golf-orange transition-colors">{{ $player->name }}</h4>
                            <span class="text-xs text-slate-400 block mt-0.5"><i class="fa-solid fa-earth-asia mr-1"></i> {{ $player->country }}</span>
                            <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded-full text-slate-600 font-bold mt-1 inline-block uppercase">Tipe: {{ $player->hand === 'Right' ? 'Kanan' : 'Kiri' }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</div>
@endsection
