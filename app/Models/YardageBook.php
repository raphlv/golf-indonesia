<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YardageBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'description',
        'cover_image',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function peerListings()
    {
        return $this->hasMany(PeerListing::class);
    }

    public function orders()
    {
        return $this->hasMany(YardageOrder::class);
    }
}
