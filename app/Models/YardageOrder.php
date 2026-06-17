<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YardageOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'yardage_book_id',
        'quantity',
        'total_price',
        'status', // 'pending', 'completed'
        'type', // 'buy_new', 'buy_peer', 'trade'
        'peer_listing_id',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function yardageBook()
    {
        return $this->belongsTo(YardageBook::class);
    }

    public function peerListing()
    {
        return $this->belongsTo(PeerListing::class);
    }
}
