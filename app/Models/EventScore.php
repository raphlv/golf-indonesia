<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'player_id',
        'hole_number',
        'strokes',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
