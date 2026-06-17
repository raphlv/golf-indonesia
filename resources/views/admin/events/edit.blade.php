@extends('layouts.app')

@section('title', 'Edit Turnamen')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Title & Back Link -->
    <div class="border-b border-slate-200 pb-4">
        <a href="{{ route('admin.events.index') }}" class="text-xs text-golf-orange hover:underline flex items-center space-x-1 mb-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Kelola Turnamen</span>
        </a>
        <h1 class="text-3xl font-extrabold text-slate-800">Edit <span class="text-golf-orange">Turnamen Golf</span></h1>
        <p class="text-sm text-slate-400 mt-1">Mengubah spesifikasi event dan mengkonfigurasi nilai Par hole-by-hole untuk lapangan.</p>
    </div>

    <!-- Edit Constructor Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Details Editor (Col span 2) -->
        <div class="lg:col-span-2">
            <div class="premium-card p-6 sm:p-8 shadow-xl bg-white border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-3 mb-6 uppercase tracking-wider">Spesifikasi Detail Event</h3>
                
                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="sm:col-span-2">
                            <label for="title" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Nama / Judul Turnamen</label>
                            <input type="text" name="title" id="title" required value="{{ old('title', $event->title) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                                placeholder="contoh: Indonesia Open 2026">
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Tanggal Penyelenggaraan</label>
                            <input type="date" name="date" id="date" required value="{{ old('date', $event->date->format('Y-m-d')) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange">
                        </div>

                        <!-- Prizepool -->
                        <div>
                            <label for="prizepool" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Prizepool Kontrak (Rupiah)</label>
                            <input type="number" name="prizepool" id="prizepool" required min="1000000" value="{{ old('prizepool', $event->prizepool) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange font-bold">
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Tempat / Lapangan</label>
                            <input type="text" name="location" id="location" required value="{{ old('location', $event->location) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                                placeholder="contoh: Pondok Indah Golf Course, Jakarta">
                        </div>

                        <!-- Organizer -->
                        <div>
                            <label for="organizer" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Penyelenggara Resmi (Organizer)</label>
                            <input type="text" name="organizer" id="organizer" required value="{{ old('organizer', $event->organizer) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                                placeholder="contoh: Persatuan Golf Indonesia (PGI)">
                        </div>

                        <!-- Status -->
                        <div class="sm:col-span-2">
                            <label for="status" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Status Liga Terkini</label>
                            <select name="status" id="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange">
                                <option value="upcoming" {{ old('status', $event->status) === 'upcoming' ? 'selected' : '' }}>Mendatang (Upcoming)</option>
                                <option value="ongoing" {{ old('status', $event->status) === 'ongoing' ? 'selected' : '' }}>Sedang Berjalan (Ongoing)</option>
                                <option value="finished" {{ old('status', $event->status) === 'finished' ? 'selected' : '' }}>Selesai (Finished)</option>
                            </select>
                        </div>

                        <!-- Sponsorship -->
                        <div class="sm:col-span-2">
                            <label for="sponsorship" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Sponsorship Utama (Pisahkan dengan koma)</label>
                            <input type="text" name="sponsorship" id="sponsorship" value="{{ old('sponsorship', $event->sponsorship) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                                placeholder="contoh: Bank Mandiri, Pertamina, Telkom Indonesia">
                        </div>

                        <!-- Description -->
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Deskripsi Keterangan Event</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                                placeholder="Tuliskan keterangan detail..."></textarea>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.events.index') }}" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 px-6 py-3 rounded-xl text-xs font-bold text-slate-600 transition-colors">
                            BATAL
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold px-8 py-3 rounded-xl transition-all shadow-md text-xs">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 18-Hole Par Configurator (Col span 1) -->
        <div class="space-y-6">
            <div class="premium-card p-6 shadow-xl bg-white border border-slate-100">
                <h3 class="text-md font-bold text-slate-800 border-b border-slate-200 pb-3 mb-4 uppercase tracking-wider flex items-center">
                    <i class="fa-solid fa-flag-checkered text-golf-orange mr-2"></i> Konfigurasi Par Lapangan
                </h3>

                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Pass basic info as hidden to keep them from overwriting -->
                    <input type="hidden" name="title" value="{{ $event->title }}">
                    <input type="hidden" name="date" value="{{ $event->date->format('Y-m-d') }}">
                    <input type="hidden" name="prizepool" value="{{ $event->prizepool }}">
                    <input type="hidden" name="location" value="{{ $event->location }}">
                    <input type="hidden" name="organizer" value="{{ $event->organizer }}">
                    <input type="hidden" name="status" value="{{ $event->status }}">
                    
                    <div class="bg-slate-50 border border-slate-200 p-3 rounded-2xl text-[10px] text-slate-500 mb-2 leading-relaxed">
                        Tentukan target pukulan (Par) standar (umumnya bernilai 3, 4, atau 5) untuk tiap-tiap hole dari 1 s.d 18.
                    </div>

                    <!-- 18 Holes Input Grid -->
                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                        @for($h = 1; $h <= 18; $h++)
                            @php $par = $pars[$h] ?? 4; @endphp
                            <div class="bg-slate-50 border border-slate-200 p-2 rounded-xl text-center">
                                <label for="par-{{ $h }}" class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Hole {{ $h }}</label>
                                <input type="number" name="pars[{{ $h }}]" id="par-{{ $h }}" min="3" max="5" value="{{ $par }}" required
                                    class="w-10 bg-white border border-slate-200 rounded-lg text-center font-bold text-slate-800 focus:outline-none focus:border-golf-orange text-xs py-1">
                            </div>
                        @endfor
                    </div>

                    <button type="submit" class="w-full bg-slate-850 hover:bg-slate-800 text-white font-extrabold py-3 rounded-xl transition-all shadow-md text-xs mt-4">
                        PERBARUI PAR LAPANGAN
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
