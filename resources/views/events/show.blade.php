@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Breadcrumbs & Navigation Back -->
    <div>
        <a href="{{ route('home') }}" class="text-xs text-golf-orange hover:underline flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Event</span>
        </a>
    </div>

    <!-- Event Banner (Light premium style with elegant orange background glows) -->
    <div class="premium-card p-6 sm:p-8 relative overflow-hidden bg-white border border-slate-100 shadow-md">
        <!-- Banner Background Glow -->
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-golf-orangelight/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-orange-100/20 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-4">
                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Status Badge -->
                    @if($event->status === 'ongoing')
                        <span class="bg-red-50 text-red-500 border border-red-200 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider animate-pulse flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 inline-block"></span>
                            Live Scoring
                        </span>
                    @elseif($event->status === 'finished')
                        <span class="bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            Selesai
                        </span>
                    @else
                        <span class="bg-golf-orangelight border border-golf-orange/30 text-golf-orange text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            Mendatang
                        </span>
                    @endif
                    
                    <span class="text-xs text-slate-400 font-medium"><i class="fa-solid fa-calendar mr-1 text-golf-orange"></i> {{ $event->date->format('d M Y') }}</span>
                </div>

                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-800 leading-tight">{{ $event->title }}</h1>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-2 gap-x-6 text-sm text-slate-600">
                    <p><i class="fa-solid fa-location-dot mr-2 text-golf-orange"></i> {{ $event->location }}</p>
                    <p><i class="fa-solid fa-building-shield mr-2 text-golf-orange"></i> {{ $event->organizer }}</p>
                    <p><i class="fa-solid fa-dollar-sign mr-2 text-golf-orange"></i> Prizepool: <span class="text-golf-orange font-bold">Rp{{ number_format($event->prizepool, 0, ',', '.') }}</span></p>
                </div>
            </div>

            <!-- Action panel (e.g. for yardage book) -->
            @if($event->yardageBook)
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 md:w-80 flex-shrink-0 text-center space-y-3 shadow-inner">
                    <span class="text-[10px] font-bold text-golf-orange tracking-widest uppercase block">Buku Panduan Lapangan Resmi</span>
                    <h4 class="text-xs font-semibold text-slate-700 truncate px-2">{{ $event->yardageBook->title }}</h4>
                    <div class="flex items-center justify-center space-x-2">
                        <span class="text-xs text-slate-400 line-through">Rp350.000</span>
                        <span class="text-sm font-extrabold text-golf-orange">Rp{{ number_format($event->yardageBook->price, 0, ',', '.') }}</span>
                    </div>
                    
                    @auth
                        @if($event->yardageBook->stock > 0)
                            <form action="{{ route('marketplace.buy_official', $event->yardageBook->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-golf-orange hover:bg-golf-orangedark text-white font-extrabold text-xs py-2.5 rounded-xl transition-all flex items-center justify-center shadow-md shadow-golf-orange/10">
                                    <i class="fa-solid fa-cart-shopping mr-1.5"></i> PESAN SEKARANG (Stok: {{ $event->yardageBook->stock }})
                                </button>
                            </form>
                        @else
                            <span class="block bg-slate-200 text-slate-400 text-xs font-bold py-2 rounded-xl">STOK HABIS</span>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold py-2 rounded-xl transition-all">
                            LOG IN UNTUK MEMESAN
                        </a>
                    @endauth
                </div>
            @endif
        </div>

        @if($event->description)
            <div class="border-t border-slate-100 mt-6 pt-4">
                <h3 class="text-xs font-bold text-golf-orange uppercase tracking-wider mb-1">Deskripsi Event</h3>
                <p class="text-xs text-slate-500 leading-relaxed">{{ $event->description }}</p>
            </div>
        @endif

        @if($event->sponsorship)
            <div class="border-t border-slate-100 mt-4 pt-4">
                <h3 class="text-xs font-bold text-golf-orange uppercase tracking-wider mb-2">Sponsor Resmi</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $event->sponsorship) as $sponsor)
                        <span class="bg-slate-50 border border-slate-200 text-slate-600 text-[10px] px-3 py-1 rounded-lg">
                            <i class="fa-solid fa-handshake-angle text-golf-orange mr-1"></i> {{ trim($sponsor) }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- MAIN EVENT INTERFACE CONDITIONAL -->

    @if($event->status === 'upcoming')
        <!-- UPCOMING STATE: SHOW PLAYERS REGISTERED -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <div class="premium-card p-6 shadow-xl">
                    <h2 class="text-xl font-extrabold text-slate-800 mb-6 uppercase tracking-wide border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-users text-golf-orange mr-2"></i> Daftar Peserta Terdaftar
                    </h2>
                    
                    @if($event->players->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($event->players as $player)
                                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-golf-orangelight flex items-center justify-center text-golf-orange text-sm font-bold">
                                            {{ substr($player->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800"><a href="{{ route('players.show', $player->id) }}" class="hover:text-golf-orange transition-colors">{{ $player->name }}</a></h4>
                                            <span class="text-[10px] text-slate-400 block"><i class="fa-solid fa-earth-asia mr-1"></i> {{ $player->country }}</span>
                                        </div>
                                    </div>
                                    <span class="text-[9px] bg-white border border-slate-200 px-2.5 py-0.5 rounded-full text-slate-600 font-semibold uppercase">{{ $player->hand === 'Right' ? 'Right' : 'Left' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <i class="fa-solid fa-circle-question text-slate-300 text-4xl mb-3"></i>
                            <p class="text-slate-500 text-sm">Pendaftaran peserta sedang diproses atau belum diumumkan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <div class="premium-card p-6">
                    <h3 class="text-md font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4 uppercase">Informasi Kompetisi</h3>
                    <ul class="space-y-3 text-xs text-slate-600">
                        <li class="flex justify-between">
                            <span class="text-slate-400">Kategori:</span>
                            <span class="font-bold text-slate-800">Professional Men's</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-slate-400">Tipe Scoring:</span>
                            <span class="font-bold text-slate-800">Stroke Play (18 Holes)</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-slate-400">Batas Peserta:</span>
                            <span class="font-bold text-slate-800">120 Pegolf</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    @else
        <!-- ONGOING & FINISHED STATE: LEADERBOARD -->
        
        <!-- Showcase Champion if Finished -->
        @if($event->status === 'finished' && $champion)
            <div class="bg-gradient-to-r from-white via-slate-50 to-white rounded-3xl p-6 sm:p-8 border-2 border-golf-orange shadow-xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-golf-orange/5 rounded-full blur-2xl"></div>
                <div class="absolute right-6 top-6 text-golf-orange text-6xl opacity-10">
                    <i class="fa-solid fa-trophy animate-bounce"></i>
                </div>
                
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-20 h-20 bg-golf-orange rounded-3xl flex items-center justify-center text-white font-black text-4xl shadow-lg shadow-golf-orange/20 flex-shrink-0">
                        <i class="fa-solid fa-crown text-3xl"></i>
                    </div>
                    <div class="space-y-2 text-center md:text-left">
                        <span class="text-[10px] font-black text-golf-orange tracking-widest uppercase block"><i class="fa-solid fa-star"></i> SANG JUARA (CHAMPION) <i class="fa-solid fa-star"></i></span>
                        <h2 class="text-3xl font-extrabold text-slate-800"><a href="{{ route('players.show', $champion['player']->id) }}" class="hover:underline hover:text-golf-orange transition-all">{{ $champion['player']->name }}</a></h2>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-4 gap-y-1 text-xs text-slate-500">
                            <span><i class="fa-solid fa-earth-asia mr-1"></i> Negara: {{ $champion['player']->country }}</span>
                            <span><i class="fa-solid fa-golf-ball-tee mr-1"></i> Total Pukulan: <span class="font-bold text-slate-800">{{ $champion['total_strokes'] }}</span></span>
                            <span><i class="fa-solid fa-flag-checkered mr-1"></i> Hasil Akhir: <span class="font-bold text-golf-orange">{{ $champion['relative_score'] < 0 ? $champion['relative_score'] : ($champion['relative_score'] > 0 ? '+' . $champion['relative_score'] : 'E') }}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Leaderboard Table -->
        <div class="premium-card p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                <h2 class="text-xl font-extrabold text-slate-800 uppercase tracking-wide flex items-center">
                    <i class="fa-solid fa-trophy text-golf-orange mr-2.5"></i> 
                    {{ $event->status === 'ongoing' ? 'Live Standings Leaderboard' : 'Klasemen Akhir Turnamen' }}
                </h2>
                
                @if($event->status === 'ongoing')
                    <span class="flex items-center space-x-1 text-xs font-bold text-red-500 bg-red-50 border border-red-200 px-3 py-1 rounded-full uppercase animate-pulse">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        <span>Live</span>
                    </span>
                @else
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full uppercase border border-slate-200">
                        Final
                    </span>
                @endif
            </div>

            <!-- Table Standings -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border border-slate-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-center font-bold">Pos</th>
                            <th scope="col" class="px-6 py-4 font-bold">Nama Pemain</th>
                            <th scope="col" class="px-6 py-4 text-center font-bold">Negara</th>
                            <th scope="col" class="px-6 py-4 text-center font-bold">Hole Dimainkan</th>
                            <th scope="col" class="px-6 py-4 text-center font-bold">Total Strokes</th>
                            <th scope="col" class="px-6 py-4 text-center font-bold">Skor (To Par)</th>
                            <th scope="col" class="px-6 py-4 text-center font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($leaderboard) > 0)
                            @foreach($leaderboard as $index => $row)
                                @php
                                    $pos = $index + 1;
                                    $scoreValue = $row['relative_score'];
                                    
                                    if ($scoreValue < 0) {
                                        $scoreText = $scoreValue;
                                        $scoreBadgeStyle = 'bg-golf-orangelight text-golf-orange border border-golf-orange/30 font-extrabold';
                                    } elseif ($scoreValue > 0) {
                                        $scoreText = '+' . $scoreValue;
                                        $scoreBadgeStyle = 'bg-red-50 text-red-500 border border-red-200 font-bold';
                                    } else {
                                        $scoreText = 'E';
                                        $scoreBadgeStyle = 'bg-slate-100 text-slate-600 border border-slate-200';
                                    }
                                @endphp
                                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-center font-bold text-slate-800">
                                        @if($event->status === 'finished' && $pos === 1)
                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-golf-orange text-white rounded-full"><i class="fa-solid fa-crown text-[10px]"></i></span>
                                        @else
                                            {{ $pos }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-800">
                                        <a href="{{ route('players.show', $row['player']->id) }}" class="hover:text-golf-orange transition-colors flex items-center">
                                            <i class="fa-solid fa-user text-slate-400 mr-2"></i>
                                            {{ $row['player']->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center text-xs text-slate-400">{{ $row['player']->country }}</td>
                                    <td class="px-6 py-4 text-center font-semibold text-slate-700">{{ $row['played_holes'] }} / 18</td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-800">{{ $row['total_strokes'] }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-3 py-1 rounded-xl text-xs {{ $scoreBadgeStyle }}">
                                            {{ $scoreText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button onclick="toggleCard({{ $row['player']->id }})" class="bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm transition-all flex items-center justify-center mx-auto">
                                            <i class="fa-solid fa-table-list mr-1 text-golf-orange"></i> Kartu Skor
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Hidden Expandable Score Card Row -->
                                <tr id="card-row-{{ $row['player']->id }}" class="hidden bg-slate-50/50 border-b border-slate-100">
                                    <td colspan="7" class="px-6 py-5">
                                        <div class="space-y-4 max-w-4xl mx-auto">
                                            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                                                <h4 class="text-xs font-bold text-golf-orange uppercase tracking-wider">Kartu Skor Hole-by-Hole: {{ $row['player']->name }}</h4>
                                                <span class="text-[10px] text-slate-500 font-medium">Total strokes: {{ $row['total_strokes'] }} | Par: {{ $scoreText }}</span>
                                            </div>

                                            <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
                                                <table class="w-full text-center text-xs">
                                                    <!-- Hole Header -->
                                                    <tr class="bg-slate-100 text-slate-700 border-b border-slate-200 font-bold">
                                                        <td class="px-2 py-2.5 border-r border-slate-200">Hole</td>
                                                        @for($h = 1; $h <= 9; $h++)
                                                            <td class="px-2 py-2.5 border-r border-slate-200">{{ $h }}</td>
                                                        @endfor
                                                        <td class="px-3 py-2.5 bg-golf-orangelight/30 border-r border-slate-200 font-black text-golf-orange">OUT</td>
                                                        @for($h = 10; $h <= 18; $h++)
                                                            <td class="px-2 py-2.5 border-r border-slate-200">{{ $h }}</td>
                                                        @endfor
                                                        <td class="px-3 py-2.5 bg-golf-orangelight/30 border-r border-slate-200 font-black text-golf-orange">IN</td>
                                                        <td class="px-3 py-2.5 bg-golf-orange text-white font-black">TOT</td>
                                                    </tr>
                                                    
                                                    <!-- Par Row -->
                                                    <tr class="text-slate-500 border-b border-slate-100">
                                                        <td class="px-2 py-2 border-r border-slate-200 font-bold uppercase text-[10px]">Par</td>
                                                        @php $outPar = 0; $inPar = 0; @endphp
                                                        @for($h = 1; $h <= 9; $h++)
                                                            @php $p = $row['hole_details'][$h]['par'] ?? 4; $outPar += $p; @endphp
                                                            <td class="px-2 py-2 border-r border-slate-200">{{ $p }}</td>
                                                        @endfor
                                                        <td class="px-3 py-2 bg-slate-50 border-r border-slate-200 font-bold text-slate-700">{{ $outPar }}</td>
                                                        @for($h = 10; $h <= 18; $h++)
                                                            @php $p = $row['hole_details'][$h]['par'] ?? 4; $inPar += $p; @endphp
                                                            <td class="px-2 py-2 border-r border-slate-200">{{ $p }}</td>
                                                        @endfor
                                                        <td class="px-3 py-2 bg-slate-50 border-r border-slate-200 font-bold text-slate-700">{{ $inPar }}</td>
                                                        <td class="px-3 py-2 bg-orange-50 font-bold text-golf-orange">{{ $outPar + $inPar }}</td>
                                                    </tr>

                                                    <!-- Strokes Row -->
                                                    <tr class="text-slate-800 font-bold">
                                                        <td class="px-2 py-2 border-r border-slate-200 text-[10px] text-slate-400">Strokes</td>
                                                        @php $outStrokes = 0; $inStrokes = 0; @endphp
                                                        @for($h = 1; $h <= 9; $h++)
                                                            @php 
                                                                $st = $row['hole_details'][$h]['strokes']; 
                                                                $outStrokes += $st ?? 0;
                                                                $diff = $row['hole_details'][$h]['diff'];
                                                                $cellClass = '';
                                                                if (!is_null($diff)) {
                                                                    if ($diff < 0) $cellClass = 'text-golf-orange font-extrabold bg-golf-orangelight/40';
                                                                    if ($diff > 0) $cellClass = 'text-red-500 bg-red-50';
                                                                }
                                                            @endphp
                                                            <td class="px-2 py-2 border-r border-slate-200 {{ $cellClass }}">{{ $st ?? '-' }}</td>
                                                        @endfor
                                                        <td class="px-3 py-2 bg-slate-50 border-r border-slate-200 text-slate-800 font-black">{{ $outStrokes ?: '-' }}</td>
                                                        @for($h = 10; $h <= 18; $h++)
                                                            @php 
                                                                $st = $row['hole_details'][$h]['strokes']; 
                                                                $inStrokes += $st ?? 0;
                                                                $diff = $row['hole_details'][$h]['diff'];
                                                                $cellClass = '';
                                                                if (!is_null($diff)) {
                                                                    if ($diff < 0) $cellClass = 'text-golf-orange font-extrabold bg-golf-orangelight/40';
                                                                    if ($diff > 0) $cellClass = 'text-red-500 bg-red-50';
                                                                }
                                                            @endphp
                                                            <td class="px-2 py-2 border-r border-slate-200 {{ $cellClass }}">{{ $st ?? '-' }}</td>
                                                        @endfor
                                                        <td class="px-3 py-2 bg-slate-50 border-r border-slate-200 text-slate-800 font-black">{{ $inStrokes ?: '-' }}</td>
                                                        <td class="px-3 py-2 bg-orange-100 text-golf-orange font-black">{{ $outStrokes + $inStrokes ?: '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="flex items-center space-x-4 text-[10px] text-slate-400 pl-2">
                                                <span>Keterangan Warna:</span>
                                                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded bg-golf-orangelight border border-golf-orange/30 mr-1.5 inline-block"></span> Birdie/Eagle (Di bawah Par)</span>
                                                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded bg-red-50 border border-red-200 mr-1.5 inline-block"></span> Bogey/Lebih (Di atas Par)</span>
                                                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded bg-slate-100 mr-1.5 inline-block"></span> Par (Sesuai Target)</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-slate-400">
                                    <i class="fa-solid fa-circle-info text-3xl mb-2 text-slate-200"></i>
                                    <p>Belum ada skor yang dimasukkan untuk peserta di turnamen ini.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script>
    function toggleCard(playerId) {
        const row = document.getElementById(`card-row-${playerId}`);
        if(row.classList.contains('hidden')) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    }
</script>
@endsection
