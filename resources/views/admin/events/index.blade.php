@extends('layouts.app')

@section('title', 'Kelola Turnamen')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Title & Create Button -->
    <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-xs text-golf-orange hover:underline flex items-center space-x-1 mb-1">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Panel Admin</span>
            </a>
            <h1 class="text-3xl font-extrabold text-slate-800">Kelola <span class="text-golf-orange">Turnamen Golf</span></h1>
            <p class="text-sm text-slate-400 mt-1">Daftar turnamen golf nasional yang berjalan, mendatang, dan telah selesai.</p>
        </div>
        
        <div>
            <a href="{{ route('admin.events.create') }}" class="bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold text-xs px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-golf-orange/15 flex items-center">
                <i class="fa-solid fa-calendar-plus mr-2 text-sm"></i> BUAT TURNAMEN BARU
            </a>
        </div>
    </div>

    <!-- Events List Table (White dominant card & clean table header) -->
    <div class="premium-card p-6 shadow-xl bg-white">
        <div class="overflow-x-auto rounded-2xl border border-slate-200">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Judul Turnamen & Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-bold">Tempat (Lapangan)</th>
                        <th scope="col" class="px-6 py-4 text-center font-bold">Prizepool</th>
                        <th scope="col" class="px-6 py-4 text-center font-bold">Status</th>
                        <th scope="col" class="px-6 py-4 text-center font-bold">Fungsionalitas Liga</th>
                        <th scope="col" class="px-6 py-4 text-center font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($events->count() > 0)
                        @foreach($events as $event)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="block text-slate-800 font-bold text-base">{{ $event->title }}</span>
                                    <span class="block text-[11px] text-slate-400 mt-0.5"><i class="fa-regular fa-calendar text-golf-orange mr-1"></i> Tanggal: {{ $event->date->format('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-700 font-medium block">{{ $event->location }}</span>
                                    <span class="text-[10px] text-slate-400 block mt-0.5"><i class="fa-solid fa-sitemap mr-1"></i> Penyelenggara: {{ $event->organizer }}</span>
                                </td>
                                <td class="px-6 py-4 text-center font-extrabold text-slate-800">
                                    Rp{{ number_format($event->prizepool, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($event->status === 'ongoing')
                                        <span class="bg-red-50 text-red-500 border border-red-200 text-[9px] font-extrabold px-2.5 py-1 rounded-full uppercase animate-pulse">Ongoing</span>
                                    @elseif($event->status === 'finished')
                                        <span class="bg-slate-100 text-slate-600 border border-slate-200 text-[9px] font-bold px-2.5 py-1 rounded-full uppercase">Finished</span>
                                    @else
                                        <span class="bg-orange-50 text-golf-orange border border-orange-200 text-[9px] font-bold px-2.5 py-1 rounded-full uppercase">Upcoming</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Assign Players Button -->
                                        <a href="{{ route('admin.events.players', $event->id) }}" class="bg-slate-50 hover:bg-golf-orangelight/40 border border-slate-200 text-slate-600 hover:text-golf-orange text-xs font-bold px-3 py-1.5 rounded-lg transition-all" title="Daftarkan Peserta">
                                            <i class="fa-solid fa-user-plus mr-1"></i> Peserta
                                        </a>
                                        
                                        <!-- Live Score Grid Button (Only for ongoing and finished) -->
                                        @if($event->status !== 'upcoming')
                                            <a href="{{ route('admin.events.scoring', $event->id) }}" class="bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 text-xs font-bold px-3 py-1.5 rounded-lg transition-all animate-pulse" title="Input Klasemen Skor">
                                                <i class="fa-solid fa-square-poll-horizontal mr-1"></i> Live Score
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold px-3 py-1.5 rounded-lg transition-all">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.events.delete', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus turnamen ini secara permanen?')">
                                            @csrf
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 border border-red-200 text-red-500 text-xs font-bold px-3 py-1.5 rounded-lg transition-all">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 bg-white">
                                <i class="fa-solid fa-calendar-times text-3xl mb-2 text-slate-200"></i>
                                <p>Belum ada turnamen yang terdaftar di database.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
