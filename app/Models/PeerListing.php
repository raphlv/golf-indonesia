<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'yardage_book_id',
        'price',
        'status', // 'active', 'sold', 'cancelled'
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function yardageBook()
    {
        return $this->belongsTo(YardageBook::class);
    }

    public function order()
    {
        return $this->hasOne(YardageOrder::class);
    }
}
