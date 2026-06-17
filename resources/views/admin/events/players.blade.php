@extends('layouts.app')

@section('title', 'Daftar Peserta Turnamen')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 space-y-8">
    
    <!-- Title & Back Link -->
    <div class="border-b border-slate-200 pb-4">
        <a href="{{ route('admin.events.index') }}" class="text-xs text-golf-orange hover:underline flex items-center space-x-1 mb-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Kelola Turnamen</span>
        </a>
        <h1 class="text-3xl font-extrabold text-slate-800">Daftar Peserta <span class="text-golf-orange">Turnamen</span></h1>
        <p class="text-xs text-slate-400 mt-1">Pilihlah pegolf profesional yang berpartisipasi dan bersaing di turnamen: <b>{{ $event->title }}</b></p>
    </div>

    <!-- Players checklist card -->
    <div class="premium-card p-6 sm:p-8 shadow-xl bg-white border border-slate-100">
        <form action="{{ route('admin.events.players.store', $event->id) }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Pilih Pegolf yang Bertanding:</span>
                
                @if($players->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($players as $player)
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center justify-between">
                                <label for="player-{{ $player->id }}" class="flex items-center space-x-3 cursor-pointer w-full select-none">
                                    <input type="checkbox" name="player_ids[]" id="player-{{ $player->id }}" value="{{ $player->id }}"
                                        {{ $event->players->contains($player->id) ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-slate-350 text-golf-orange focus:ring-golf-orange">
                                    
                                    <div>
                                        <span class="text-sm font-bold text-slate-850 block">{{ $player->name }}</span>
                                        <span class="text-[10px] text-slate-400 block"><i class="fa-solid fa-earth-asia mr-1"></i> Negara: {{ $player->country }}</span>
                                    </div>
                                </label>
                                <span class="text-[9px] bg-white border border-slate-200 px-2.5 py-0.5 rounded-full text-slate-500 font-semibold uppercase">{{ $player->hand === 'Right' ? 'Right' : 'Left' }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 text-slate-400 text-xs">
                        <i class="fa-solid fa-users-slash text-3xl mb-2 text-slate-300"></i>
                        <p>Belum ada data pegolf profesional di database.</p>
                        <p class="text-[10px] text-slate-400 mt-1">Buat profil pegolf baru terlebih dahulu di menu Kelola Pegolf.</p>
                    </div>
                @endif
            </div>

            <div class="border-t border-slate-200 pt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.events.index') }}" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 px-6 py-3 rounded-xl text-xs font-bold text-slate-600 transition-colors">
                    BATAL
                </a>
                <button type="submit" class="bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold px-8 py-3 rounded-xl transition-all shadow-md text-xs">
                    SIMPAN DAFTAR PESERTA
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
