<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Player;
use App\Models\EventPar;
use App\Models\EventScore;
use App\Models\YardageBook;
use App\Models\YardageOrder;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        // Universal inline admin check using controller middleware
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->isAdmin()) {
                abort(403, 'Akses ditolak. Halaman khusus Administrator.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $totalEvents = Event::count();
        $totalPlayers = Player::count();
        $totalOrders = YardageOrder::count();
        $totalRevenue = YardageOrder::sum('total_price');

        $recentEvents = Event::orderBy('date', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('totalEvents', 'totalPlayers', 'totalOrders', 'totalRevenue', 'recentEvents'));
    }

    // --------------------------------------------------------
    // EVENT CRUD
    // --------------------------------------------------------

    public function events()
    {
        $events = Event::orderBy('date', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    public function createEvent()
    {
        return view('admin.events.create');
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'prizepool' => 'required|numeric|min:0',
            'organizer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sponsorship' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,finished',
            // Yardage book optional fields
            'book_price' => 'nullable|numeric|min:0',
            'book_stock' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $event = Event::create($request->only([
                'title', 'date', 'location', 'prizepool', 'organizer', 'description', 'sponsorship', 'status'
            ]));

            // Auto-initialize standard Par 4 for all 18 holes
            for ($i = 1; $i <= 18; $i++) {
                EventPar::create([
                    'event_id' => $event->id,
                    'hole_number' => $i,
                    'par_value' => 4, // Default par 4
                ]);
            }

            // Create official yardage book if price/stock are provided
            $price = $request->book_price ?? 200000;
            $stock = $request->book_stock ?? 50;

            YardageBook::create([
                'event_id' => $event->id,
                'title' => $event->title . ' Official Yardage Book',
                'description' => 'Buku panduan taktis resmi untuk lapangan di event ' . $event->title,
                'price' => $price,
                'stock' => $stock,
                'cover_image' => 'book_default.jpg'
            ]);
        });

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan dan Par lapangan serta Buku Yardage telah diinisialisasi.');
    }

    public function editEvent($id)
    {
        $event = Event::with('pars')->findOrFail($id);
        $pars = $event->pars->sortBy('hole_number');
        return view('admin.events.edit', compact('event', 'pars'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'prizepool' => 'required|numeric|min:0',
            'organizer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sponsorship' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,finished',
            'pars' => 'required|array|size:18',
            'pars.*' => 'required|integer|min:3|max:5',
        ]);

        DB::transaction(function () use ($request, $event) {
            $event->update($request->only([
                'title', 'date', 'location', 'prizepool', 'organizer', 'description', 'sponsorship', 'status'
            ]));

            // Update pars
            foreach ($request->pars as $holeNumber => $parValue) {
                EventPar::updateOrCreate(
                    ['event_id' => $event->id, 'hole_number' => $holeNumber],
                    ['par_value' => $parValue]
                );
            }
        });

        return redirect()->route('admin.events.index')->with('success', 'Event dan Par lapangan berhasil diperbarui.');
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

    // --------------------------------------------------------
    // REGISTRATION OF PLAYERS TO EVENTS
    // --------------------------------------------------------

    public function eventPlayers($id)
    {
        $event = Event::with('players')->findOrFail($id);
        $players = Player::orderBy('name', 'asc')->get();
        $assignedPlayerIds = $event->players->pluck('id')->toArray();

        return view('admin.events.players', compact('event', 'players', 'assignedPlayerIds'));
    }

    public function storeEventPlayers(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $playerIds = $request->player_ids ?? [];

        $event->players()->sync($playerIds);

        return redirect()->route('admin.events.index')->with('success', 'Daftar peserta event berhasil diperbarui.');
    }

    // --------------------------------------------------------
    // LIVE SCORING INPUT
    // --------------------------------------------------------

    public function scoring($id)
    {
        $event = Event::with(['players', 'pars'])->findOrFail($id);
        
        if ($event->status === 'upcoming') {
            return redirect()->route('admin.events.index')->with('error', 'Scoring hanya bisa dimasukkan untuk event yang sedang Berjalan (Ongoing) atau Selesai (Finished).');
        }

        $pars = $event->pars->sortBy('hole_number')->pluck('par_value', 'hole_number')->all();
        $players = $event->players;

        // Fetch scores for this event
        $scores = EventScore::where('event_id', $event->id)->get()->groupBy('player_id');

        return view('admin.scoring.index', compact('event', 'players', 'pars', 'scores'));
    }

    public function updateScoring(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        
        $request->validate([
            'scores' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $event) {
            foreach ($request->scores as $playerId => $holeScores) {
                foreach ($holeScores as $holeNumber => $strokes) {
                    if (is_null($strokes) || $strokes === '') {
                        // Delete score if cleared
                        EventScore::where('event_id', $event->id)
                            ->where('player_id', $playerId)
                            ->where('hole_number', $holeNumber)
                            ->delete();
                    } else {
                        // Save score
                        EventScore::updateOrCreate(
                            [
                                'event_id' => $event->id,
                                'player_id' => $playerId,
                                'hole_number' => $holeNumber
                            ],
                            [
                                'strokes' => intval($strokes)
                            ]
                        );
                    }
                }
            }
        });

        return back()->with('success', 'Skor live berhasil diperbarui.');
    }

    // --------------------------------------------------------
    // PLAYER CRUD
    // --------------------------------------------------------

    public function players()
    {
        $players = Player::orderBy('name', 'asc')->get();
        return view('admin.players.index', compact('players'));
    }

    public function createPlayer()
    {
        return view('admin.players.create');
    }

    public function storePlayer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'hand' => 'required|in:Left,Right',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoName = 'player_default.jpg';
        if ($request->hasFile('photo_file')) {
            $photoFile = $request->file('photo_file');
            $photoName = 'player_' . time() . '.' . $photoFile->getClientOriginalExtension();
            $photoFile->move(public_path('images/players'), $photoName);
        }

        Player::create([
            'name' => $request->name,
            'country' => $request->country,
            'bio' => $request->bio,
            'hand' => $request->hand,
            'photo' => $photoName
        ]);

        return redirect()->route('admin.players.index')->with('success', 'Profil pemain berhasil ditambahkan.');
    }

    public function editPlayer($id)
    {
        $player = Player::findOrFail($id);
        return view('admin.players.edit', compact('player'));
    }

    public function updatePlayer(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'hand' => 'required|in:Left,Right',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'country', 'bio', 'hand']);

        if ($request->hasFile('photo_file')) {
            $photoFile = $request->file('photo_file');
            $photoName = 'player_' . time() . '.' . $photoFile->getClientOriginalExtension();
            $photoFile->move(public_path('images/players'), $photoName);
            $data['photo'] = $photoName;
        }

        $player->update($data);

        return redirect()->route('admin.players.index')->with('success', 'Profil pemain berhasil diperbarui.');
    }

    public function deletePlayer($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();

        return redirect()->route('admin.players.index')->with('success', 'Profil pemain berhasil dihapus.');
    }
}
