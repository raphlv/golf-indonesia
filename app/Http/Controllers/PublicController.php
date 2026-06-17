<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Player;
use App\Models\EventScore;

class PublicController extends Controller
{
    public function index()
    {
        $ongoingEvents = Event::where('status', 'ongoing')->orderBy('date', 'desc')->get();
        $upcomingEvents = Event::where('status', 'upcoming')->orderBy('date', 'asc')->get();
        $finishedEvents = Event::where('status', 'finished')->orderBy('date', 'desc')->get();
        
        $featuredPlayers = Player::take(3)->get();

        return view('home', compact('ongoingEvents', 'upcomingEvents', 'finishedEvents', 'featuredPlayers'));
    }

    public function showEvent($id)
    {
        $event = Event::with(['players', 'pars', 'yardageBook'])->findOrFail($id);
        
        // Compute leaderboard
        $leaderboard = $event->getLeaderboard();
        
        // Find champion if finished
        $champion = null;
        if ($event->status === 'finished' && count($leaderboard) > 0) {
            $champion = $leaderboard[0];
        }

        return view('events.show', compact('event', 'leaderboard', 'champion'));
    }

    public function showPlayer($id)
    {
        $player = Player::findOrFail($id);
        
        // Get player's tournament history
        $participatedEvents = $player->events()->orderBy('date', 'desc')->get();
        
        $history = [];
        foreach ($participatedEvents as $event) {
            $leaderboard = $event->getLeaderboard();
            
            // Find player's position and details in the leaderboard
            $position = '-';
            $playerRecord = null;
            
            foreach ($leaderboard as $index => $row) {
                if ($row['player']->id === $player->id) {
                    $position = $index + 1;
                    $playerRecord = $row;
                    break;
                }
            }
            
            if ($playerRecord) {
                $history[] = [
                    'event' => $event,
                    'position' => $position,
                    'total_strokes' => $playerRecord['total_strokes'],
                    'relative_score' => $playerRecord['relative_score'],
                    'played_holes' => $playerRecord['played_holes'],
                    'finished' => $playerRecord['finished'],
                ];
            }
        }

        return view('players.show', compact('player', 'history'));
    }
}
