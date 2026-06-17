@extends('layouts.app')

@section('title', 'Edit Profil Pemain')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 space-y-8">
    
    <!-- Title & Back link -->
    <div class="border-b border-slate-200 pb-4">
        <a href="{{ route('admin.players.index') }}" class="text-xs text-golf-orange hover:underline flex items-center space-x-1 mb-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Kelola Pegolf</span>
        </a>
        <h1 class="text-3xl font-extrabold text-slate-800">Edit <span class="text-golf-orange">Profil Pegolf</span></h1>
        <p class="text-sm text-slate-400 mt-1">Nama Pemain: <b>{{ $player->name }}</b></p>
    </div>

    <!-- Edit Form -->
    <div class="premium-card p-6 sm:p-8 shadow-xl bg-white border border-slate-100 relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-36 h-36 bg-golf-orangelight/40 rounded-full blur-2xl"></div>

        <form action="{{ route('admin.players.update', $player->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-semibold text-slate-650 uppercase tracking-wider mb-2">Nama Lengkap Pegolf</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $player->name) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 text-sm focus:outline-none focus:border-golf-orange"
                        placeholder="contoh: Naraajie Ramadhanputra">
                </div>

                <!-- Country -->
                <div>
                    <label for="country" class="block text-xs font-semibold text-slate-650 uppercase tracking-wider mb-2">Asal Negara</label>
                    <input type="text" name="country" id="country" required value="{{ old('country', $player->country) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 text-sm focus:outline-none focus:border-golf-orange"
                        placeholder="contoh: Indonesia">
                </div>

                <!-- Hand Preference -->
                <div>
                    <label for="hand" class="block text-xs font-semibold text-slate-650 uppercase tracking-wider mb-2">Tipe Tangan Utama (Hand)</label>
                    <select name="hand" id="hand" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 text-sm focus:outline-none focus:border-golf-orange">
                        <option value="Right" {{ old('hand', $player->hand) === 'Right' ? 'selected' : '' }}>Kanan (Right-Handed)</option>
                        <option value="Left" {{ old('hand', $player->hand) === 'Left' ? 'selected' : '' }}>Kiri (Left-Handed)</option>
                    </select>
                </div>

                <!-- Photo (Optional) -->
                <div class="sm:col-span-2">
                    <label for="photo_file" class="block text-xs font-semibold text-slate-650 uppercase tracking-wider mb-2">Foto Profil (Opsional - upload untuk mengganti)</label>
                    <input type="file" name="photo_file" id="photo_file" accept="image/*"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 text-sm focus:outline-none focus:border-golf-orange">
                    <span class="block text-[10px] text-slate-400 mt-1">Format: JPG, JPEG, PNG (Maks 2MB). Foto saat ini: <b>{{ $player->photo }}</b></span>
                </div>

                <!-- Bio -->
                <div class="sm:col-span-2">
                    <label for="bio" class="block text-xs font-semibold text-slate-650 uppercase tracking-wider mb-2">Biografi Pemain</label>
                    <textarea name="bio" id="bio" rows="4"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-800 text-sm focus:outline-none focus:border-golf-orange"
                        placeholder="Tuliskan biografi singkat mengenai pemain, karir, prestasi dll...">{{ old('bio', $player->bio) }}</textarea>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.players.index') }}" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 px-6 py-3 rounded-xl text-xs font-bold text-slate-600 transition-colors">
                    BATAL
                </a>
                <button type="submit" class="bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold px-8 py-3 rounded-xl transition-all shadow-md text-xs">
                    PERBARUI PROFIL
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
