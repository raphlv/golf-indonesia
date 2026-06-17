@extends('layouts.app')

@section('title', 'Kelola Pegolf')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Title & Create Button -->
    <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-xs text-golf-orange hover:underline flex items-center space-x-1 mb-1">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Panel Admin</span>
            </a>
            <h1 class="text-3xl font-extrabold text-slate-800">Kelola <span class="text-golf-orange">Pegolf Bintang</span></h1>
            <p class="text-sm text-slate-400 mt-1">Daftar pegolf profesional terdaftar di dalam sistem sirkuit Golf Indonesia.</p>
        </div>
        
        <div>
            <a href="{{ route('admin.players.create') }}" class="bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold text-xs px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-golf-orange/15 flex items-center">
                <i class="fa-solid fa-user-plus mr-2 text-sm"></i> TAMBAH PEGOLF BARU
            </a>
        </div>
    </div>

    <!-- Players Table Card -->
    <div class="premium-card p-6 shadow-xl bg-white border border-slate-100">
        <div class="overflow-x-auto rounded-2xl border border-slate-200">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Pegolf</th>
                        <th scope="col" class="px-6 py-4 font-bold">Asal Negara</th>
                        <th scope="col" class="px-6 py-4 text-center font-bold">Tangan Utama</th>
                        <th scope="col" class="px-6 py-4 font-bold">Deskripsi Biografi</th>
                        <th scope="col" class="px-6 py-4 text-center font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($players->count() > 0)
                        @foreach($players as $player)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-800 text-base">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-xl bg-golf-orangelight text-golf-orange flex items-center justify-center text-xs font-black">
                                            {{ substr($player->name, 0, 1) }}
                                        </div>
                                        <span>{{ $player->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-650 font-medium">
                                    {{ $player->country }}
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-slate-700 uppercase text-xs">
                                    {{ $player->hand === 'Right' ? 'Right' : 'Left' }}
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-xs max-w-sm truncate" title="{{ $player->bio }}">
                                    {{ $player->bio ?: '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.players.edit', $player->id) }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold px-3 py-1.5 rounded-lg transition-all">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.players.delete', $player->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil pemain ini secara permanen?')">
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
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 bg-white">
                                <i class="fa-solid fa-users-slash text-3xl mb-2 text-slate-200"></i>
                                <p>Belum ada data pegolf profesional yang terdaftar.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
