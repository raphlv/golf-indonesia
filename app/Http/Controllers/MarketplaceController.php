<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YardageBook;
use App\Models\PeerListing;
use App\Models\YardageOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarketplaceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Official Books
        $officialBooks = YardageBook::with('event')->get();
        
        // Active Peer-to-Peer Listings
        $peerListings = PeerListing::with(['seller', 'yardageBook.event'])
            ->where('status', 'active')
            ->where('seller_id', '!=', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // User's own listings
        $myListings = PeerListing::with('yardageBook.event')
            ->where('seller_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Books Owned by User (based on completed orders and active listings)
        // A simple query to get books they have purchased
        $completedOrders = YardageOrder::with('yardageBook')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->get();
            
        // Let's count how many they bought and how many they sold/listed
        // Bought:
        $boughtCounts = [];
        foreach ($completedOrders as $order) {
            $bookId = $order->yardage_book_id;
            $boughtCounts[$bookId] = ($boughtCounts[$bookId] ?? 0) + $order->quantity;
        }
        
        // Sold (P2P listings where they are the seller and status is 'sold')
        $soldListings = PeerListing::where('seller_id', $user->id)
            ->where('status', 'sold')
            ->get();
            
        $soldCounts = [];
        foreach ($soldListings as $listing) {
            $bookId = $listing->yardage_book_id;
            $soldCounts[$bookId] = ($soldCounts[$bookId] ?? 0) + 1;
        }

        // Active listings (currently locked in marketplace)
        $activeListings = PeerListing::where('seller_id', $user->id)
            ->where('status', 'active')
            ->get();
            
        $activeCounts = [];
        foreach ($activeListings as $listing) {
            $bookId = $listing->yardage_book_id;
            $activeCounts[$bookId] = ($activeCounts[$bookId] ?? 0) + 1;
        }

        // Compute current inventory
        $ownedBooks = [];
        foreach ($boughtCounts as $bookId => $count) {
            $sold = $soldCounts[$bookId] ?? 0;
            $active = $activeCounts[$bookId] ?? 0;
            $available = $count - $sold - $active;
            
            if ($available > 0) {
                $book = YardageBook::with('event')->find($bookId);
                if ($book) {
                    $ownedBooks[] = [
                        'book' => $book,
                        'qty' => $available
                    ];
                }
            }
        }

        return view('marketplace.index', compact('officialBooks', 'peerListings', 'myListings', 'ownedBooks'));
    }

    public function buyOfficial(Request $request, $id)
    {
        $user = Auth::user();
        $book = YardageBook::findOrFail($id);

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku panduan ini sudah habis.');
        }

        if ($user->current_balance < $book->price) {
            return back()->with('error', 'Saldo Anda tidak mencukupi untuk melakukan pembelian ini.');
        }

        DB::transaction(function () use ($user, $book) {
            // Deduct balance
            $user->current_balance -= $book->price;
            $user->save();

            // Deduct stock
            $book->stock -= 1;
            $book->save();

            // Create Order
            YardageOrder::create([
                'user_id' => $user->id,
                'yardage_book_id' => $book->id,
                'quantity' => 1,
                'total_price' => $book->price,
                'status' => 'completed',
                'type' => 'buy_new',
            ]);
        });

        return redirect()->route('marketplace.index')->with('success', 'Pembelian Berhasil! Buku panduan ' . $book->title . ' telah ditambahkan ke koleksi Anda.');
    }

    public function listP2P(Request $request)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            return back()->with('error', 'Akses ditolak. Hanya Administrator yang diperbolehkan menjual buku di bursa pasar.');
        }

        $request->validate([
            'yardage_book_id' => 'required|exists:yardage_books,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Check if user owns the book
        $completedOrders = YardageOrder::where('user_id', $user->id)
            ->where('yardage_book_id', $request->yardage_book_id)
            ->where('status', 'completed')
            ->count();
            
        $sold = PeerListing::where('seller_id', $user->id)
            ->where('yardage_book_id', $request->yardage_book_id)
            ->where('status', 'sold')
            ->count();
            
        $active = PeerListing::where('seller_id', $user->id)
            ->where('yardage_book_id', $request->yardage_book_id)
            ->where('status', 'active')
            ->count();

        $owned = $completedOrders - $sold - $active;

        if ($owned <= 0) {
            return back()->with('error', 'Anda tidak memiliki buku panduan ini dalam koleksi Anda untuk dijual.');
        }

        PeerListing::create([
            'seller_id' => $user->id,
            'yardage_book_id' => $request->yardage_book_id,
            'price' => $request->price,
            'status' => 'active',
            'description' => $request->description,
        ]);

        return redirect()->route('marketplace.index')->with('success', 'Buku panduan berhasil dipasang di bursa pasar P2P.');
    }

    public function buyP2P($id)
    {
        $buyer = Auth::user();
        $listing = PeerListing::with('seller')->findOrFail($id);

        if ($listing->status !== 'active') {
            return back()->with('error', 'Lapak jualan ini sudah tidak aktif atau sudah terjual.');
        }

        if ($listing->seller_id === $buyer->id) {
            return back()->with('error', 'Anda tidak bisa membeli buku dari lapak Anda sendiri.');
        }

        if ($buyer->current_balance < $listing->price) {
            return back()->with('error', 'Saldo Anda tidak mencukupi untuk melakukan pembelian P2P ini.');
        }

        DB::transaction(function () use ($buyer, $listing) {
            $seller = $listing->seller;

            // Deduct buyer
            $buyer->current_balance -= $listing->price;
            $buyer->save();

            // Add to seller
            $seller->current_balance += $listing->price;
            $seller->save();

            // Close Listing
            $listing->status = 'sold';
            $listing->save();

            // Create Order
            YardageOrder::create([
                'user_id' => $buyer->id,
                'yardage_book_id' => $listing->yardage_book_id,
                'quantity' => 1,
                'total_price' => $listing->price,
                'status' => 'completed',
                'type' => 'buy_peer',
                'peer_listing_id' => $listing->id,
            ]);
        });

        return redirect()->route('marketplace.index')->with('success', 'Transaksi P2P Sukses! Anda membeli buku panduan seharga Rp' . number_format($listing->price, 0, ',', '.') . ' dari ' . $listing->seller->name);
    }

    public function tradeP2P(Request $request, $id)
    {
        $user = Auth::user();
        $listing = PeerListing::with('seller')->findOrFail($id);
        
        $request->validate([
            'offered_book_id' => 'required|exists:yardage_books,id',
        ]);

        if ($listing->status !== 'active') {
            return back()->with('error', 'Lapak barter ini sudah tidak aktif.');
        }

        if ($listing->seller_id === $user->id) {
            return back()->with('error', 'Anda tidak bisa barter dengan lapak Anda sendiri.');
        }

        // Verify user owns the offered book
        $completedOrders = YardageOrder::where('user_id', $user->id)
            ->where('yardage_book_id', $request->offered_book_id)
            ->where('status', 'completed')
            ->count();
            
        $sold = PeerListing::where('seller_id', $user->id)
            ->where('yardage_book_id', $request->offered_book_id)
            ->where('status', 'sold')
            ->count();
            
        $active = PeerListing::where('seller_id', $user->id)
            ->where('yardage_book_id', $request->offered_book_id)
            ->where('status', 'active')
            ->count();

        $owned = $completedOrders - $sold - $active;

        if ($owned <= 0) {
            return back()->with('error', 'Anda tidak memiliki buku penawaran ini di inventori Anda.');
        }

        // Perform Trade Swap
        DB::transaction(function () use ($user, $listing, $request) {
            $seller = $listing->seller;
            $buyerBookId = $request->offered_book_id; // Book user is giving
            $sellerBookId = $listing->yardage_book_id; // Book user is receiving

            // 1. Mark listing as sold
            $listing->status = 'sold';
            $listing->save();

            // 2. Create order for user receiving seller's book
            YardageOrder::create([
                'user_id' => $user->id,
                'yardage_book_id' => $sellerBookId,
                'quantity' => 1,
                'total_price' => 0, // Barter
                'status' => 'completed',
                'type' => 'trade',
                'peer_listing_id' => $listing->id,
            ]);

            // 3. Create order for seller receiving user's book
            YardageOrder::create([
                'user_id' => $seller->id,
                'yardage_book_id' => $buyerBookId,
                'quantity' => 1,
                'total_price' => 0, // Barter
                'status' => 'completed',
                'type' => 'trade',
                'peer_listing_id' => $listing->id,
            ]);
        });

        return redirect()->route('marketplace.index')->with('success', 'Barter Sukses! Anda menukar buku panduan Anda dengan buku panduan milik ' . $listing->seller->name);
    }
}
