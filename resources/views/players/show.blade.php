@extends('layouts.app')

@section('title', 'Profil Pemain - ' . $player->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Breadcrumbs -->
    <div>
        <a href="{{ route('home') }}" class="text-xs text-golf-orange hover:underline flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Player Bio Card -->
        <div class="space-y-6">
            <div class="premium-card p-6 text-center relative overflow-hidden shadow-xl bg-white">
                <!-- Background glow -->
                <div class="absolute -top-12 -right-12 w-28 h-28 bg-golf-orangelight/40 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-12 -left-12 w-28 h-28 bg-orange-100/10 rounded-full blur-2xl"></div>

                <div class="relative space-y-4">
                    <!-- Avatar box -->
                    <div class="w-32 h-32 bg-gradient-to-tr from-golf-orangelight to-orange-100 rounded-3xl mx-auto border-2 border-golf-orange flex items-center justify-center text-golf-orange shadow-md">
                        <i class="fa-solid fa-user-tie text-5xl"></i>
                    </div>

                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-800 leading-tight">{{ $player->name }}</h2>
                        <span class="text-xs text-golf-orange font-bold block mt-1"><i class="fa-solid fa-earth-asia"></i> {{ $player->country }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 bg-slate-50 border border-slate-200 p-3 rounded-2xl text-xs">
                        <div class="text-left border-r border-slate-200 pr-2">
                            <span class="text-[10px] text-slate-400 block uppercase font-bold">Pref. Hand</span>
                            <span class="font-bold text-slate-700">{{ $player->hand === 'Right' ? 'Kanan (Right)' : 'Kiri (Left)' }}</span>
                        </div>
                        <div class="text-left pl-2">
                            <span class="text-[10px] text-slate-400 block uppercase font-bold">Partisipasi</span>
                            <span class="font-bold text-slate-700">{{ count($history) }} Event</span>
                        </div>
                    </div>

                    @if($player->bio)
                        <div class="text-left border-t border-slate-100 pt-4 mt-4">
                            <span class="text-[10px] font-bold text-golf-orange uppercase tracking-wider block mb-1">Biografi Singkat</span>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $player->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Player Tournament History -->
        <div class="md:col-span-2 space-y-6">
            <div class="premium-card p-6 shadow-xl bg-white">
                <h2 class="text-xl font-extrabold text-slate-800 mb-6 uppercase tracking-wide border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-timeline text-golf-orange mr-2"></i> Riwayat Kompetisi & Hasil Skor
                </h2>

                @if(count($history) > 0)
                    <div class="space-y-4">
                        @foreach($history as $item)
                            @php
                                $scoreVal = $item['relative_score'];
                                if ($scoreVal < 0) {
                                    $scoreBadge = 'bg-golf-orangelight text-golf-orange border border-golf-orange/30 font-extrabold';
                                    $scoreText = $scoreVal;
                                } elseif ($scoreVal > 0) {
                                    $scoreBadge = 'bg-red-50 text-red-500 border border-red-200 font-bold';
                                    $scoreText = '+' . $scoreVal;
                                } else {
                                    $scoreBadge = 'bg-slate-100 text-slate-600 border border-slate-200';
                                    $scoreText = 'E';
                                }
                            @endphp
                            <div class="bg-slate-50 border border-slate-200 hover:border-golf-orange/30 rounded-2xl p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-all duration-300">
                                <div class="space-y-1">
                                    <div class="flex items-center space-x-2">
                                        <!-- Event Status Indicator -->
                                        @if($item['event']->status === 'ongoing')
                                            <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse block" title="Sedang Berjalan"></span>
                                        @endif
                                        <h3 class="text-base font-bold text-slate-800 hover:text-golf-orange transition-colors">
                                            <a href="{{ route('events.show', $item['event']->id) }}">{{ $item['event']->title }}</a>
                                        </h3>
                                    </div>
                                    <p class="text-xs text-slate-400"><i class="fa-solid fa-location-dot mr-1"></i> {{ $item['event']->location }} | {{ $item['event']->date->format('d M Y') }}</p>
                                </div>

                                <div class="flex flex-wrap items-center gap-4 text-xs">
                                    <div class="text-center bg-white px-3 py-1.5 rounded-xl border border-slate-200 min-w-[70px]">
                                        <span class="text-[9px] text-slate-400 block uppercase font-medium">Peringkat</span>
                                        <span class="font-bold text-slate-700">#{{ $item['position'] }}</span>
                                    </div>
                                    <div class="text-center bg-white px-3 py-1.5 rounded-xl border border-slate-200 min-w-[70px]">
                                        <span class="text-[9px] text-slate-400 block uppercase font-medium">Strokes</span>
                                        <span class="font-bold text-slate-700">{{ $item['total_strokes'] }}</span>
                                    </div>
                                    <div class="text-center bg-white px-3 py-1.5 rounded-xl border border-slate-200 min-w-[70px]">
                                        <span class="text-[9px] text-slate-400 block uppercase font-medium">Holes</span>
                                        <span class="font-bold text-slate-700">{{ $item['played_holes'] }}/18</span>
                                    </div>
                                    <div class="min-w-[50px] text-center">
                                        <span class="inline-block px-3 py-1.5 rounded-xl {{ $scoreBadge }} text-xs">
                                            {{ $scoreText }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 text-slate-400">
                        <i class="fa-solid fa-circle-info text-3xl mb-2 text-slate-200"></i>
                        <p>Pemain ini belum memiliki catatan kompetisi resmi.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
