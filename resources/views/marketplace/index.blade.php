@extends('layouts.app')

@section('title', 'Bursa Yardage Book')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Title & Description -->
    <div class="border-b border-slate-200 pb-4">
        <h1 class="text-3xl font-extrabold text-slate-800">Bursa <span class="text-golf-orange">Yardage Book</span></h1>
        <p class="text-sm text-slate-400 mt-1">Dapatkan buku panduan taktis lapangan resmi atau lakukan transaksi jual-beli dan barter aman antar pemain.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Marketplace listings (Col span 2) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- 1. OFFICIAL YARDAGE SHOP -->
            <section class="space-y-4">
                <div class="flex items-center space-x-2">
                    <div class="bg-golf-orangelight p-1.5 rounded-lg text-golf-orange"><i class="fa-solid fa-store text-md"></i></div>
                    <h2 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Toko Buku Panduan Resmi</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($officialBooks as $book)
                        <div class="premium-card p-5 flex flex-col justify-between h-56 bg-white">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] bg-golf-orangelight border border-golf-orange/30 text-golf-orange font-bold px-2 py-0.5 rounded-full uppercase">Official</span>
                                    <span class="text-[10px] text-slate-400 font-semibold"><i class="fa-solid fa-box mr-1"></i> Stok: {{ $book->stock }}</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-800 line-clamp-2 leading-tight">{{ $book->title }}</h3>
                                <p class="text-xs text-slate-400 line-clamp-2">{{ $book->description }}</p>
                            </div>
                            
                            <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                                <div>
                                    <span class="text-[9px] text-slate-400 block uppercase">Harga Resmi</span>
                                    <span class="text-sm font-extrabold text-golf-orange">Rp{{ number_format($book->price, 0, ',', '.') }}</span>
                                </div>
                                <form action="{{ route('marketplace.buy_official', $book->id) }}" method="POST">
                                    @csrf
                                    @if($book->stock > 0)
                                        <button type="submit" class="bg-golf-orange hover:bg-golf-orangedark text-white font-extrabold text-xs px-3.5 py-2 rounded-xl transition-all shadow-md shadow-golf-orange/10">
                                            Beli Baru
                                        </button>
                                    @else
                                        <span class="bg-slate-200 text-slate-400 text-xs font-bold px-4 py-2 rounded-xl">Habis</span>
                                    @endif
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- 2. P2P ACTIVE LISTINGS -->
            <section class="space-y-4">
                <div class="flex items-center space-x-2">
                    <div class="bg-golf-orangelight p-1.5 rounded-lg text-golf-orange"><i class="fa-solid fa-users text-md"></i></div>
                    <h2 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Lapak Jual & Barter Pegolf (P2P)</h2>
                </div>

                @if($peerListings->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($peerListings as $listing)
                            <div class="premium-card p-5 flex flex-col justify-between h-72 bg-white relative border-orange-200/40">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[9px] bg-orange-50 border border-orange-200 text-golf-orange font-bold px-2.5 py-0.5 rounded-full uppercase"><i class="fa-solid fa-user-tag mr-1"></i> P2P Lapak</span>
                                        <span class="text-[9px] text-slate-400">Penjual: <b>{{ $listing->seller->name }}</b></span>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-800 line-clamp-2 leading-tight">{{ $listing->yardageBook->title }}</h3>
                                    <p class="text-xs text-slate-500 leading-snug italic">"{{ $listing->description ?: 'Tidak ada deskripsi penjual' }}"</p>
                                </div>

                                <div class="border-t border-slate-100 pt-3 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-[9px] text-slate-400 block uppercase">Harga Pas</span>
                                            <span class="text-base font-extrabold text-golf-orange">Rp{{ number_format($listing->price, 0, ',', '.') }}</span>
                                        </div>
                                        <form action="{{ route('marketplace.buy_p2p', $listing->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-golf-orange hover:bg-golf-orangedark text-white font-extrabold text-xs px-4 py-2 rounded-xl transition-all shadow-md shadow-golf-orange/10">
                                                BELI BUKU
                                            </button>
                                        </form>
                                    </div>

                                    <!-- BARTER OPTION -->
                                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 text-xs">
                                        <form action="{{ route('marketplace.trade_p2p', $listing->id) }}" method="POST" class="flex items-center justify-between gap-2">
                                            @csrf
                                            <div class="flex-grow">
                                                <select name="offered_book_id" required class="w-full bg-white border border-slate-350 rounded-lg px-2 py-1 text-[11px] text-slate-700 focus:outline-none focus:border-golf-orange">
                                                    <option value="" disabled selected>Pilih Buku Barter Anda</option>
                                                    @foreach($ownedBooks as $inv)
                                                        @if($inv['book']->id !== $listing->yardage_book_id)
                                                            <option value="{{ $inv['book']->id }}">{{ $inv['book']->title }} (Sisa: {{ $inv['qty'] }})</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white font-bold text-[10px] px-3 py-1.5 rounded-lg transition-all shrink-0">
                                                BARTER
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white border border-slate-200 rounded-3xl p-10 text-center text-slate-400">
                        <i class="fa-solid fa-users-slash text-4xl mb-3 text-slate-300"></i>
                        <p class="text-sm">Belum ada pegolf lain yang mendaftarkan lapak buku P2P di bursa.</p>
                    </div>
                @endif
            </section>
        </div>

        <!-- Sidebar forms (Col span 1) -->
        <div class="space-y-6">
            
            <!-- A. USER OWN INVENTORY -->
            <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 shadow-md">
                <h3 class="text-md font-bold text-slate-800 border-b border-slate-200 pb-3 mb-4 uppercase tracking-wider flex items-center">
                    <i class="fa-solid fa-book-bookmark text-golf-orange mr-2"></i> Inventori Buku Saya
                </h3>

                @if(count($ownedBooks) > 0)
                    <div class="space-y-3">
                        @foreach($ownedBooks as $inv)
                            <div class="bg-white border border-slate-200 rounded-2xl p-3.5 flex items-center justify-between">
                                <div class="space-y-0.5 pr-2">
                                    <h4 class="text-xs font-bold text-slate-800 truncate max-w-[150px]" title="{{ $inv['book']->title }}">{{ $inv['book']->title }}</h4>
                                    <span class="text-[10px] text-slate-400 block"><i class="fa-solid fa-bookmark text-golf-orange"></i> Lapangan: {{ $inv['book']->event->location }}</span>
                                </div>
                                <span class="bg-golf-orangelight text-golf-orange border border-golf-orange/20 font-black text-xs px-2.5 py-1 rounded-xl">Qty: {{ $inv['qty'] }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-slate-400 text-xs">
                        <i class="fa-solid fa-folder-closed text-2xl mb-2 text-slate-300"></i>
                        <p>Anda belum memiliki buku panduan terdaftar di inventori Anda.</p>
                        <p class="text-[10px] text-slate-400 mt-1">Beli baru melalui Toko Resmi terlebih dahulu.</p>
                    </div>
                @endif
            </div>

            @if(auth()->user() && auth()->user()->isAdmin())
                <!-- B. SELL/LIST YARDAGE BOOK P2P FORM -->
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 shadow-md">
                    <h3 class="text-md font-bold text-slate-800 border-b border-slate-200 pb-3 mb-4 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-tags text-golf-orange mr-2"></i> Jual Buku Saya (P2P)
                    </h3>

                    @if(count($ownedBooks) > 0)
                        <form action="{{ route('marketplace.list_p2p') }}" method="POST" class="space-y-4 text-xs">
                            @csrf
                            
                            <div>
                                <label for="yardage_book_id" class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Buku yang Ingin Dijual</label>
                                <select name="yardage_book_id" id="yardage_book_id" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-slate-700 focus:outline-none focus:border-golf-orange">
                                    @foreach($ownedBooks as $inv)
                                        <option value="{{ $inv['book']->id }}">{{ $inv['book']->title }} (Sisa: {{ $inv['qty'] }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="price" class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Harga Jual (Rupiah)</label>
                                <input type="number" name="price" id="price" required min="1000" placeholder="contoh: 150000"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 font-bold focus:outline-none focus:border-golf-orange">
                            </div>

                            <div>
                                <label for="description" class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Deskripsi Kondisi Buku</label>
                                <textarea name="description" id="description" rows="3" placeholder="Tuliskan keterangan mulus, coretan, pengiriman..."
                                    class="w-full bg-white border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:border-golf-orange"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-slate-800 hover:bg-slate-700 text-white font-extrabold py-3 rounded-xl transition-all shadow-md text-xs">
                                DAFTARKAN DI BURSA PASAR
                            </button>
                        </form>
                    @else
                        <div class="text-center py-6 text-slate-400 text-xs">
                            <p>Beli buku panduan terlebih dahulu untuk bisa dipasarkan kembali.</p>
                        </div>
                    @endif
                </div>

                <!-- C. USER ACTIVE LISTINGS LIST -->
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 shadow-md">
                    <h3 class="text-md font-bold text-slate-800 border-b border-slate-200 pb-3 mb-4 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-list-check text-golf-orange mr-2"></i> Lapak Aktif Saya
                    </h3>

                    @if($myListings->count() > 0)
                        <div class="space-y-3">
                            @foreach($myListings as $listing)
                                <div class="bg-white border border-slate-200 rounded-2xl p-3 flex flex-col justify-between gap-2 text-[11px]">
                                    <div class="space-y-1">
                                        <h4 class="font-bold text-slate-800 truncate" title="{{ $listing->yardageBook->title }}">{{ $listing->yardageBook->title }}</h4>
                                        <div class="flex justify-between text-[10px] text-slate-400">
                                            <span>Harga: <b>Rp{{ number_format($listing->price, 0, ',', '.') }}</b></span>
                                            <span>Status: 
                                                @if($listing->status === 'active')
                                                    <span class="text-golf-orange font-bold">Aktif Dipasarkan</span>
                                                @elseif($listing->status === 'sold')
                                                    <span class="text-green-600 font-bold">Terjual</span>
                                                @else
                                                    <span class="text-slate-400 font-bold">Batal</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-slate-400 text-xs">
                            <p class="text-[10px]">Anda belum memasang lapak jualan di bursa.</p>
                        </div>
                    @endif
                </div>
            @else
                <!-- Bursa Ketentuan Notice for Regular Users -->
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 shadow-md text-xs text-slate-500 space-y-2">
                    <span class="block font-bold text-golf-orange text-[10px] uppercase tracking-wider"><i class="fa-solid fa-circle-info"></i> Ketentuan Bursa Jual</span>
                    <p class="leading-relaxed">Hanya Administrator yang diperbolehkan menjual atau mendaftarkan lapak buku yardage baru di bursa pasar. Sebagai user, Anda diperbolehkan membeli buku panduan resmi atau menukarkan/barter buku milik Anda.</p>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection
