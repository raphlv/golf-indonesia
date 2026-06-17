@extends('layouts.app')

@section('title', 'Masuk Akun')

@section('content')
<div class="max-w-md mx-auto my-16 px-4">
    <div class="premium-card p-8 shadow-xl relative overflow-hidden bg-white border border-slate-100">
        <!-- Decoration background glow -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-golf-orange/5 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-orange-500/5 rounded-full blur-2xl"></div>

        <div class="relative text-center mb-8">
            <h1 class="text-3xl font-extrabold text-slate-800">Selamat Datang <span class="text-golf-orange">Kembali</span></h1>
            <p class="text-sm text-slate-400 mt-2">Masuk untuk mengelola event atau berbelanja Buku Yardage.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-golf-orange text-slate-800 text-sm transition-colors" 
                        placeholder="contoh: admin@golf.id">
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
                        placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 bg-slate-50 border-slate-200 rounded text-golf-orange focus:ring-golf-orange">
                    <label for="remember" class="ml-2 block text-xs text-slate-600">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-golf-orange to-orange-500 hover:brightness-110 text-white font-extrabold py-3.5 rounded-xl transition-all shadow-lg shadow-golf-orange/10 text-sm">
                MASUK SEKARANG
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-slate-400 border-t border-slate-100 pt-6">
            <span>Belum punya akun? <a href="{{ route('register') }}" class="text-golf-orange font-semibold hover:underline">Daftar di sini</a></span>
        </div>

        <!-- Quick Demo Login Account Shortcuts -->
        <div class="mt-6 bg-golf-orangelight/40 border border-golf-orange/20 rounded-2xl p-4">
            <span class="block text-[10px] font-bold text-golf-orange tracking-widest uppercase text-center mb-3">Akun Demo (Klik untuk Isi Otomatis)</span>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <button type="button" onclick="fillDemo('admin@golf.id')" class="bg-white border border-slate-200 px-3 py-2 rounded-lg text-left text-slate-600 hover:border-golf-orange transition-colors">
                    <span class="font-bold text-slate-800 block"><i class="fa-solid fa-shield-halved mr-1 text-golf-orange"></i> Admin</span>
                    admin@golf.id
                </button>
                <button type="button" onclick="fillDemo('budi@gmail.com')" class="bg-white border border-slate-200 px-3 py-2 rounded-lg text-left text-slate-600 hover:border-golf-orange transition-colors">
                    <span class="font-bold text-slate-800 block"><i class="fa-solid fa-user mr-1 text-golf-orange"></i> User (Budi)</span>
                    budi@gmail.com
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function fillDemo(email) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password';
    }
</script>
@endsection
