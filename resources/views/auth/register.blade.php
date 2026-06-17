@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="max-w-md mx-auto my-16 px-4">
    <div class="premium-card p-8 shadow-xl relative overflow-hidden bg-white border border-slate-100">
        <!-- Decoration background glow -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-golf-orange/5 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-orange-500/5 rounded-full blur-2xl"></div>

        <div class="relative text-center mb-8">
            <h1 class="text-3xl font-extrabold text-slate-800">Buat Akun <span class="text-golf-orange">Baru</span></h1>
            <p class="text-sm text-slate-400 mt-2">Dapatkan saldo gratis Rp1.000.000 untuk transaksi Buku Yardage setelah mendaftar.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-golf-orange text-slate-800 text-sm transition-colors" 
                        placeholder="contoh: Budi Santoso">
                </div>
                @error('name')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-golf-orange text-slate-800 text-sm transition-colors" 
                        placeholder="contoh: budi@gmail.com">
                </div>
                @error('email')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="password" required
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-golf-orange text-slate-800 text-sm transition-colors" 
                        placeholder="Minimal 6 karakter">
                </div>
                @error('password')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-golf-orange text-slate-800 text-sm transition-colors" 
                        placeholder="Ulangi kata sandi">
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold py-3.5 rounded-xl transition-all shadow-lg shadow-golf-orange/10 text-sm">
                DAFTAR SEKARANG
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-slate-400 border-t border-slate-100 pt-6">
            <span>Sudah memiliki akun? <a href="{{ route('login') }}" class="text-golf-orange font-semibold hover:underline">Masuk di sini</a></span>
        </div>
    </div>
</div>
@endsection
