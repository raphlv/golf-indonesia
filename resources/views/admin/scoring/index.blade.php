@extends('layouts.app')

@section('title', 'Live Scoring Editor - ' . $event->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Title & Back Link -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <a href="{{ route('admin.events.index') }}" class="text-xs text-golf-orange hover:underline flex items-center space-x-1 mb-1">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Kelola Turnamen</span>
            </a>
            <h1 class="text-3xl font-extrabold text-slate-800">Live <span class="text-golf-orange">Scoring Editor</span></h1>
            <p class="text-xs text-slate-400 mt-1">Turnamen: <b>{{ $event->title }}</b> | Lapangan: {{ $event->location }}</p>
        </div>
        <div class="flex items-center space-x-2 bg-red-50 border border-red-200 px-3.5 py-1.5 rounded-full">
            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
            <span class="text-[10px] font-black text-red-500 uppercase tracking-widest">Live Scoring Active</span>
        </div>
    </div>

    <!-- Live Scoring Sheet -->
    <div class="premium-card p-6 shadow-xl bg-white border border-slate-100">
        <div class="mb-6 bg-golf-orangelight/40 border border-golf-orange/20 p-4 rounded-2xl text-xs text-slate-600 space-y-1">
            <h4 class="font-bold text-slate-800 uppercase text-[10px] tracking-wider mb-2"><i class="fa-solid fa-circle-info text-golf-orange"></i> Panduan Pengisian Live Score</h4>
            <p>1. Masukkan jumlah pukulan (strokes) pada masing-masing kolom hole (Hole 1 s.d 18).</p>
            <p>2. Kosongkan kolom jika pemain belum bermain di hole tersebut.</p>
            <p>3. Angka yang Anda masukkan akan langsung mengkalkulasi leaderboard total secara otomatis di halaman publik.</p>
        </div>

        @if($players->count() > 0)
            <form action="{{ route('admin.events.scoring.update', $event->id) }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="overflow-x-auto rounded-2xl border border-slate-200">
                    <table class="w-full text-center text-xs">
                        <thead class="bg-slate-50 text-slate-700 uppercase font-bold border-b border-slate-200">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-left min-w-[200px] border-r border-slate-200">Nama Pemain</th>
                                <th scope="col" class="px-2 py-4 border-r border-slate-200">Hole</th>
                                @for($i = 1; $i <= 18; $i++)
                                    <th scope="col" class="px-2 py-4 border-r border-slate-200 min-w-[50px]">{{ $i }}</th>
                                @endfor
                                <th scope="col" class="px-4 py-4 bg-golf-orangelight/30 text-golf-orange font-black">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($players as $player)
                                @php
                                    $playerScores = $scores->get($player->id) ?? collect();
                                @endphp
                                <!-- 1. Target Par Reference Row -->
                                <tr class="bg-slate-50/50 text-slate-400 border-b border-slate-200/50">
                                    <td rowspan="2" class="px-4 py-3 text-left font-bold text-slate-800 border-r border-slate-200 bg-slate-50/50">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 rounded-lg bg-golf-orange text-white flex items-center justify-center text-[10px] font-bold">{{ substr($player->name, 0, 1) }}</div>
                                            <span class="truncate block max-w-[150px]" title="{{ $player->name }}">{{ $player->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 border-r border-slate-200 uppercase text-[9px] font-bold text-slate-500">Par</td>
                                    @php $totalPar = 0; @endphp
                                    @for($i = 1; $i <= 18; $i++)
                                        @php 
                                            $par = $pars[$i] ?? 4; 
                                            $totalPar += $par;
                                        @endphp
                                        <td class="px-2 py-2 border-r border-slate-200 text-slate-500 font-bold bg-slate-50/30">{{ $par }}</td>
                                    @endfor
                                    <td class="px-4 py-2 bg-golf-orangelight/10 text-golf-orange/80 font-bold border-t border-slate-200/50">{{ $totalPar }}</td>
                                </tr>

                                <!-- 2. Strokes Input Row -->
                                <tr class="border-b border-slate-200">
                                    <td class="px-2 py-3 border-r border-slate-200 uppercase text-[9px] font-bold text-slate-400">Score</td>
                                    @php $totalStrokes = 0; @endphp
                                    @for($i = 1; $i <= 18; $i++)
                                        @php
                                            $strokes = $playerScores->firstWhere('hole_number', $i)->strokes ?? '';
                                            if ($strokes) $totalStrokes += intval($strokes);
                                        @endphp
                                        <td class="px-1.5 py-2.5 border-r border-slate-200">
                                            <input type="number" name="scores[{{ $player->id }}][{{ $i }}]" min="1" max="15" value="{{ $strokes }}"
                                                class="w-10 bg-slate-55 border border-slate-300 rounded-md py-1 text-center font-bold text-slate-800 focus:outline-none focus:border-golf-orange text-xs">
                                        </td>
                                    @endfor
                                    <td class="px-4 py-3 font-black text-slate-800 text-sm bg-golf-orangelight/40 border-b border-slate-200">
                                        <span id="tot-{{ $player->id }}">{{ $totalStrokes ?: '-' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 pt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.events.index') }}" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 px-6 py-3 rounded-xl text-xs font-bold text-slate-650 transition-colors">
                        KEMBALI
                    </a>
                    <button type="submit" class="bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold px-8 py-3 rounded-xl transition-all shadow-md text-xs flex items-center">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> SIMPAN KLASEMEN SKOR
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-10 text-slate-400">
                <i class="fa-solid fa-users-slash text-4xl mb-3 text-slate-200"></i>
                <p>Belum ada pemain yang didaftarkan ke turnamen ini.</p>
                <p class="text-xs text-slate-400 mt-1">Daftarkan pemain terlebih dahulu melalui halaman Daftar Peserta.</p>
                <a href="{{ route('admin.events.players', $event->id) }}" class="inline-block mt-4 bg-golf-orange text-white font-extrabold text-xs px-4 py-2 rounded-xl transition-all">
                    Daftarkan Pemain Sekarang
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
