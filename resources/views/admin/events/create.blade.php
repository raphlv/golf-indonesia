@extends('layouts.app')

@section('title', 'Buat Turnamen Baru')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 space-y-8">
    
    <!-- Title & Back Link -->
    <div class="border-b border-slate-200 pb-4">
        <a href="{{ route('admin.events.index') }}" class="text-xs text-golf-orange hover:underline flex items-center space-x-1 mb-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Kelola Turnamen</span>
        </a>
        <h1 class="text-3xl font-extrabold text-slate-800">Buat <span class="text-golf-orange">Turnamen Baru</span></h1>
        <p class="text-sm text-slate-400 mt-1">Menginisialisasi kompetisi turnamen profesional berserta buku panduan taktis lapangan resmi secara instan.</p>
    </div>

    <!-- Construction Form Card -->
    <div class="premium-card p-6 sm:p-8 shadow-xl bg-white border border-slate-100">
        <form action="{{ route('admin.events.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="sm:col-span-2">
                    <label for="title" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Nama / Judul Turnamen</label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                        placeholder="contoh: Indonesia Open 2026">
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Tanggal Penyelenggaraan</label>
                    <input type="date" name="date" id="date" required value="{{ old('date') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange">
                </div>

                <!-- Prizepool -->
                <div>
                    <label for="prizepool" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Prizepool Kontrak (Rupiah)</label>
                    <input type="number" name="prizepool" id="prizepool" required min="1000000" value="{{ old('prizepool', 1000000000) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange font-bold">
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Tempat / Lapangan</label>
                    <input type="text" name="location" id="location" required value="{{ old('location') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                        placeholder="contoh: Pondok Indah Golf Course, Jakarta">
                </div>

                <!-- Organizer -->
                <div>
                    <label for="organizer" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Penyelenggara Resmi (Organizer)</label>
                    <input type="text" name="organizer" id="organizer" required value="{{ old('organizer') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                        placeholder="contoh: Persatuan Golf Indonesia (PGI)">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Status Awal Liga</label>
                    <select name="status" id="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange">
                        <option value="upcoming">Mendatang (Upcoming)</option>
                        <option value="ongoing">Sedang Berjalan (Ongoing)</option>
                        <option value="finished">Selesai (Finished)</option>
                    </select>
                </div>

                <!-- Yardage Book Price -->
                <div>
                    <label for="yardage_price" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Harga Buku Yardage Resmi (Rupiah)</label>
                    <input type="number" name="yardage_price" id="yardage_price" required min="1000" value="{{ old('yardage_price', 250000) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange font-bold">
                </div>

                <!-- Sponsorship -->
                <div class="sm:col-span-2">
                    <label for="sponsorship" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Sponsorship Utama (Pisahkan dengan koma)</label>
                    <input type="text" name="sponsorship" id="sponsorship" value="{{ old('sponsorship') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                        placeholder="contoh: Bank Mandiri, Pertamina, Telkom Indonesia">
                </div>

                <!-- Description -->
                <div class="sm:col-span-2">
                    <label for="description" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Deskripsi Keterangan Event</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-850 text-sm focus:outline-none focus:border-golf-orange"
                        placeholder="Tuliskan keterangan detail, jadwal liga, babak penentu, dsb..."></textarea>
                </div>
            </div>

            <!-- Auto-Init Alert box -->
            <div class="bg-golf-orangelight/40 border border-golf-orange/20 p-4 rounded-2xl text-xs text-slate-600 space-y-1">
                <span class="block font-bold text-golf-orange text-[10px] uppercase tracking-wider mb-1"><i class="fa-solid fa-magic-wand-sparkles"></i> Otomatisasi Sistem Golf Indonesia</span>
                <p>1. Sistem akan secara otomatis menetapkan nilai <b>Par 4</b> sebagai target default untuk masing-masing ke-18 hole turnamen baru.</p>
                <p>2. Satu Buku Yardage Resmi berlisensi dengan kuantitas stok 50 pcs akan otomatis terbuat di bursa pasar.</p>
            </div>

            <div class="border-t border-slate-200 pt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.events.index') }}" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 px-6 py-3 rounded-xl text-xs font-bold text-slate-600 transition-colors">
                    BATAL
                </a>
                <button type="submit" class="bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold px-8 py-3 rounded-xl transition-all shadow-lg shadow-golf-orange/15 text-xs">
                    BUAT TURNAMEN
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
