<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'country',
        'bio',
        'hand',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_players');
    }

    public function scores()
    {
        return $this->hasMany(EventScore::class);
    }
}
