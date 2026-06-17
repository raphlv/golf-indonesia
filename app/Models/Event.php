<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'prizepool',
        'location',
        'description',
        'organizer',
        'sponsorship',
        'status', // 'upcoming', 'ongoing', 'finished'
    ];

    protected $casts = [
        'date' => 'date',
        'prizepool' => 'decimal:2',
    ];

    public function players()
    {
        return $this->belongsToMany(Player::class, 'event_players');
    }

    public function pars()
    {
        return $this->hasMany(EventPar::class);
    }

    public function scores()
    {
        return $this->hasMany(EventScore::class);
    }

    public function yardageBook()
    {
        return $this->hasOne(YardageBook::class);
    }

    /**
     * Compute leaderboard for the event.
     */
    public function getLeaderboard()
    {
        $pars = $this->pars->pluck('par_value', 'hole_number')->all();
        // If pars are not fully initialized (we need 1-18), assume default par 4 for empty holes
        for ($i = 1; $i <= 18; $i++) {
            if (!isset($pars[$i])) {
                $pars[$i] = 4;
            }
        }
        
        $totalCoursePar = array_sum($pars);

        $players = $this->players;
        $scoresGrouped = $this->scores->groupBy('player_id');

        $leaderboard = [];

        foreach ($players as $player) {
            $playerScores = $scoresGrouped->get($player->id) ?? collect();
            $strokesCount = 0;
            $playedHolesCount = 0;
            $totalParPlayed = 0;
            
            $holeDetails = [];

            for ($i = 1; $i <= 18; $i++) {
                $score = $playerScores->firstWhere('hole_number', $i);
                $holePar = $pars[$i];
                if ($score) {
                    $strokes = $score->strokes;
                    $diff = $strokes - $holePar;
                    $strokesCount += $strokes;
                    $playedHolesCount++;
                    $totalParPlayed += $holePar;
                    $holeDetails[$i] = [
                        'strokes' => $strokes,
                        'par' => $holePar,
                        'diff' => $diff
                    ];
                } else {
                    $holeDetails[$i] = [
                        'strokes' => null,
                        'par' => $holePar,
                        'diff' => null
                    ];
                }
            }

            $relativeScore = $playedHolesCount > 0 ? ($strokesCount - $totalParPlayed) : 0;

            $leaderboard[] = [
                'player' => $player,
                'total_strokes' => $strokesCount,
                'played_holes' => $playedHolesCount,
                'relative_score' => $relativeScore, // e.g. -3, 0 (E), +2
                'hole_details' => $holeDetails,
                'finished' => $playedHolesCount === 18,
            ];
        }

        // Sort leaderboard: lowest relative score first, then by holes played (more holes played is further along), then by name
        usort($leaderboard, function ($a, $b) {
            // If one player has not played any hole, they are ranked lower
            if ($a['played_holes'] == 0 && $b['played_holes'] > 0) return 1;
            if ($b['played_holes'] == 0 && $a['played_holes'] > 0) return -1;
            if ($a['played_holes'] == 0 && $b['played_holes'] == 0) {
                return strcmp($a['player']->name, $b['player']->name);
            }

            if ($a['relative_score'] != $b['relative_score']) {
                return $a['relative_score'] <=> $b['relative_score'];
            }
            
            // If score is tied, player who completed more holes is ranked higher (or lower, let's keep it simple: tie by name)
            return strcmp($a['player']->name, $b['player']->name);
        });

        return $leaderboard;
    }
}
