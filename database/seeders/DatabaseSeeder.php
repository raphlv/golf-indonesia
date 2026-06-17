<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Player;
use App\Models\Event;
use App\Models\EventPar;
use App\Models\EventScore;
use App\Models\YardageBook;
use App\Models\PeerListing;
use App\Models\YardageOrder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'name' => 'Admin Golf Indonesia',
            'email' => 'admin@golf.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'current_balance' => 5000000.00,
        ]);

        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'current_balance' => 1500000.00,
        ]);

        $user2 = User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'current_balance' => 800050.00,
        ]);

        // 2. Seed 25 Real Players
        $playersData = [
            [
                'name' => 'Naraajie Ramadhanputra',
                'country' => 'Indonesia',
                'bio' => 'Naraajie adalah salah satu pegolf profesional muda terbaik Indonesia saat ini dengan beberapa gelar juara sirkuit nasional.',
                'hand' => 'Right',
                'event1_target' => -5, // Winner of Event 1
                'event2_target' => -2, // Strong contender in Event 2
            ],
            [
                'name' => 'Jonathan Wijono',
                'country' => 'Indonesia',
                'bio' => 'Jonathan Wijono merupakan pegolf andalan Indonesia yang secara konsisten bersaing di turnamen Asian Development Tour.',
                'hand' => 'Right',
                'event1_target' => -2,
                'event2_target' => -1,
            ],
            [
                'name' => 'Danny Masrin',
                'country' => 'Indonesia',
                'bio' => 'Danny adalah pegolf veteran Indonesia berpengalaman tinggi yang sudah sering mewakili Indonesia di ajang internasional.',
                'hand' => 'Right',
                'event1_target' => 0,
                'event2_target' => 1,
            ],
            [
                'name' => 'Rory Hie',
                'country' => 'Indonesia',
                'bio' => 'Rory Hie adalah pegolf Indonesia pertama yang berhasil memenangkan turnamen sirkuit Asian Tour (Classic Golf & Country Club International Championship).',
                'hand' => 'Right',
                'event1_target' => -1,
                'event2_target' => 0,
            ],
            [
                'name' => 'Almay Rayhan Yagutah',
                'country' => 'Indonesia',
                'bio' => 'Pegolf profesional muda berbakat Indonesia yang mencetak prestasi luar biasa sejak level amatir.',
                'hand' => 'Right',
                'event1_target' => 2,
                'event2_target' => 1,
            ],
            [
                'name' => 'Kevin Caesario Akbar',
                'country' => 'Indonesia',
                'bio' => 'Kevin Akbar secara konsisten menjadi andalan Indonesia di kancah golf regional Asia Tenggara.',
                'hand' => 'Right',
                'event1_target' => 3,
                'event2_target' => 2,
            ],
            [
                'name' => 'George Gandranata',
                'country' => 'Indonesia',
                'bio' => 'George adalah pegolf senior Indonesia yang berpengalaman memenangkan turnamen di sirkuit Asian Development Tour.',
                'hand' => 'Right',
                'event1_target' => 1,
                'event2_target' => 3,
            ],
            [
                'name' => 'Syukrizal S',
                'country' => 'Indonesia',
                'bio' => 'Pegolf profesional asal Aceh yang memiliki reputasi tangguh di turnamen nasional Indonesia.',
                'hand' => 'Right',
                'event1_target' => 4,
                'event2_target' => 3,
            ],
            [
                'name' => 'Benny Kasiadi',
                'country' => 'Indonesia',
                'bio' => 'Putra dari legenda golf Indonesia Kasiadi, Benny meneruskan warisan prestasi golf keluarganya.',
                'hand' => 'Right',
                'event1_target' => 5,
                'event2_target' => 4,
            ],
            [
                'name' => 'Peter Gunawan',
                'country' => 'Indonesia',
                'bio' => 'Pegolf profesional Indonesia yang gigih bertanding di sirkuit PGA Tour Indonesia.',
                'hand' => 'Right',
                'event1_target' => 6,
                'event2_target' => 5,
            ],
            // International Players
            [
                'name' => 'Tiger Woods',
                'country' => 'United States',
                'bio' => 'Legenda hidup golf dunia dengan rekor 15 gelar major dan 82 kemenangan PGA Tour.',
                'hand' => 'Right',
                'event1_target' => 1,
                'event2_target' => 2,
            ],
            [
                'name' => 'Rory McIlroy',
                'country' => 'Northern Ireland',
                'bio' => 'Mantan pegolf nomor satu dunia, pemenang major turnamen sebanyak 4 kali.',
                'hand' => 'Right',
                'event1_target' => -3,
                'event2_target' => -4,
            ],
            [
                'name' => 'Justin Rose',
                'country' => 'England',
                'bio' => 'Pemenang US Open dan peraih medali emas Olimpiade asal Inggris dengan permainan yang sangat presisi.',
                'hand' => 'Right',
                'event1_target' => -2,
                'event2_target' => -3,
            ],
            [
                'name' => 'John Catlin',
                'country' => 'United States',
                'bio' => 'Pegolf tangguh asal Amerika Serikat yang memenangkan beberapa gelar bergengsi di Asian Tour.',
                'hand' => 'Right',
                'event1_target' => -4,
                'event2_target' => -2,
            ],
            [
                'name' => 'Taichi Kho',
                'country' => 'Hong Kong',
                'bio' => 'Pemenang medali emas Asian Games dan juara World City Championship asal Hong Kong.',
                'hand' => 'Right',
                'event1_target' => -1,
                'event2_target' => -2,
            ],
            [
                'name' => 'Jazz Janewattananond',
                'country' => 'Thailand',
                'bio' => 'Mantan juara Asian Tour Order of Merit asal Thailand dengan swing yang sangat mulus.',
                'hand' => 'Right',
                'event1_target' => -3,
                'event2_target' => -1,
            ],
            [
                'name' => 'Sadom Kaewkanjana',
                'country' => 'Thailand',
                'bio' => 'Pegolf muda Thailand pemegang rekor juara SMBC Singapore Open.',
                'hand' => 'Right',
                'event1_target' => -2,
                'event2_target' => -3,
            ],
            [
                'name' => 'Phachara Khongwatmai',
                'country' => 'Thailand',
                'bio' => 'Pemain berbakat Thailand yang mencetak sejarah sebagai pemenang turnamen profesional termuda pada usia 14 tahun.',
                'hand' => 'Right',
                'event1_target' => -1,
                'event2_target' => 0,
            ],
            [
                'name' => 'Gaganjeet Bhullar',
                'country' => 'India',
                'bio' => 'Pemenang gelar terbanyak di sirkuit Indonesia Open asal India dengan reputasi luar biasa.',
                'hand' => 'Right',
                'event1_target' => -2,
                'event2_target' => -1,
            ],
            [
                'name' => 'Shiv Kapur',
                'country' => 'India',
                'bio' => 'Pegolf veteran asal India dengan segudang pengalaman di European Tour dan Asian Tour.',
                'hand' => 'Right',
                'event1_target' => 1,
                'event2_target' => 1,
            ],
            [
                'name' => 'Travis Smyth',
                'country' => 'Australia',
                'bio' => 'Pegolf berjiwa dinamis asal Australia dengan pukulan panjang yang mengesankan.',
                'hand' => 'Right',
                'event1_target' => 0,
                'event2_target' => -1,
            ],
            [
                'name' => 'Scott Hend',
                'country' => 'Australia',
                'bio' => 'Pegolf veteran Australia dengan 10 kemenangan di sirkuit Asian Tour.',
                'hand' => 'Right',
                'event1_target' => 2,
                'event2_target' => 2,
            ],
            [
                'name' => 'Miguel Carballo',
                'country' => 'Argentina',
                'bio' => 'Pegolf tangguh asal Argentina yang meniti kesuksesan di kancah golf Asia.',
                'hand' => 'Right',
                'event1_target' => 3,
                'event2_target' => 2,
            ],
            [
                'name' => 'Lee Westwood',
                'country' => 'England',
                'bio' => 'Mantan pegolf nomor satu dunia asal Inggris dengan segudang gelar internasional.',
                'hand' => 'Right',
                'event1_target' => -2,
                'event2_target' => -2,
            ],
            [
                'name' => 'Gunn Charoenkul',
                'country' => 'Thailand',
                'bio' => 'Pegolf Thailand yang terkenal dengan akurasi pukulan green yang sangat tinggi.',
                'hand' => 'Right',
                'event1_target' => 0,
                'event2_target' => 0,
            ]
        ];

        $playerModels = [];
        foreach ($playersData as $index => $data) {
            $playerModels[] = Player::create([
                'name' => $data['name'],
                'photo' => 'player_' . strtolower(str_replace(' ', '_', $data['name'])) . '.jpg',
                'country' => $data['country'],
                'bio' => $data['bio'],
                'hand' => $data['hand'],
            ]);
        }

        // 3. Seed Events
        $event1 = Event::create([
            'title' => 'Indonesia Open 2026',
            'date' => '2026-05-15',
            'prizepool' => 5000000000.00,
            'location' => 'Pondok Indah Golf Course, Jakarta',
            'description' => 'Turnamen golf tertua dan paling bergengsi di Indonesia yang mempertemukan pegolf top tanah air dengan pemain internasional.',
            'organizer' => 'Persatuan Golf Indonesia (PGI)',
            'sponsorship' => 'Bank Mandiri, Telkom Indonesia, Pertamina',
            'status' => 'finished',
        ]);

        $event2 = Event::create([
            'title' => 'BNI Indonesian Masters 2026',
            'date' => '2026-06-01',
            'prizepool' => 7500000000.00,
            'location' => 'Royale Jakarta Golf Club, Jakarta',
            'description' => 'Turnamen bagian dari Asian Tour International Series dengan persaingan ketat dan siaran langsung global.',
            'organizer' => 'Asian Tour',
            'sponsorship' => 'BNI, Astra International, Sinarmas',
            'status' => 'ongoing',
        ]);

        $event3 = Event::create([
            'title' => 'Bali Golf Championship 2026',
            'date' => '2026-07-20',
            'prizepool' => 3000000000.00,
            'location' => 'Bali National Golf Club, Nusa Dua',
            'description' => 'Kompetisi golf eksklusif di pulau dewata dengan keindahan pemandangan pesisir pantai Bali Selatan.',
            'organizer' => 'Bali Golf Association',
            'sponsorship' => 'Wonderful Indonesia, Club Med, Bintang',
            'status' => 'upcoming',
        ]);

        // Attach all 25 players to Event 1 and Event 2
        $allPlayerIds = array_map(fn($p) => $p->id, $playerModels);
        $event1->players()->attach($allPlayerIds);
        $event2->players()->attach($allPlayerIds);

        // Attach 5 selected players to Event 3
        $event3->players()->attach(array_slice($allPlayerIds, 0, 8));

        // 4. Seed Pars for Event 1 & Event 2
        // Event 1 (Pondok Indah) Pars
        $event1Pars = [4, 4, 3, 4, 5, 4, 4, 3, 4, 4, 4, 3, 5, 4, 4, 4, 3, 5]; // standard 72
        foreach ($event1Pars as $index => $par) {
            EventPar::create([
                'event_id' => $event1->id,
                'hole_number' => $index + 1,
                'par_value' => $par
            ]);
        }

        // Event 2 (Royale Jakarta) Pars
        $event2Pars = [4, 5, 4, 3, 4, 4, 3, 4, 5, 4, 4, 3, 4, 5, 4, 3, 4, 5]; // standard 72
        foreach ($event2Pars as $index => $par) {
            EventPar::create([
                'event_id' => $event2->id,
                'hole_number' => $index + 1,
                'par_value' => $par
            ]);
        }

        // 5. Seed Scores for Event 1 (Finished - 18 holes complete)
        // Programmatic score generation to match exact skill targets!
        foreach ($playerModels as $pIdx => $player) {
            $target = $playersData[$pIdx]['event1_target'];
            $scores = $event1Pars; // Start equal to pars

            if ($target < 0) {
                // We need to create birdies! (Reduce strokes by 1 on random holes)
                $birdieHoles = (array) array_rand(range(0, 17), abs($target));
                foreach ($birdieHoles as $holeIdx) {
                    $scores[$holeIdx] -= 1;
                }
            } elseif ($target > 0) {
                // We need to create bogeys! (Increase strokes by 1 on random holes)
                $bogeyHoles = (array) array_rand(range(0, 17), $target);
                foreach ($bogeyHoles as $holeIdx) {
                    $scores[$holeIdx] += 1;
                }
            }

            // Insert into Database
            foreach ($scores as $holeIdx => $strokes) {
                EventScore::create([
                    'event_id' => $event1->id,
                    'player_id' => $player->id,
                    'hole_number' => $holeIdx + 1,
                    'strokes' => $strokes
                ]);
            }
        }

        // 6. Seed Scores for Event 2 (Ongoing - Holes 1-9 completed)
        foreach ($playerModels as $pIdx => $player) {
            $target = $playersData[$pIdx]['event2_target'];
            $scores = array_slice($event2Pars, 0, 9); // First 9 holes only

            // Distribute target over first 9 holes
            // We scale target because they only played 9 holes
            $halfTarget = intval(round($target / 2));
            
            if ($halfTarget < 0) {
                $birdieHoles = (array) array_rand(range(0, 8), min(abs($halfTarget), 4));
                foreach ($birdieHoles as $holeIdx) {
                    $scores[$holeIdx] -= 1;
                }
            } elseif ($halfTarget > 0) {
                $bogeyHoles = (array) array_rand(range(0, 8), min($halfTarget, 4));
                foreach ($bogeyHoles as $holeIdx) {
                    $scores[$holeIdx] += 1;
                }
            }

            // Insert into Database
            foreach ($scores as $holeIdx => $strokes) {
                EventScore::create([
                    'event_id' => $event2->id,
                    'player_id' => $player->id,
                    'hole_number' => $holeIdx + 1,
                    'strokes' => $strokes
                ]);
            }
        }

        // 7. Seed Yardage Books
        $book1 = YardageBook::create([
            'event_id' => $event1->id,
            'title' => 'Pondok Indah Golf Course Official Yardage Book',
            'description' => 'Panduan rute detail, jarak par, rintangan air, bunker, dan kontur green dari Pondok Indah Golf Course.',
            'cover_image' => 'book_pondok_indah.jpg',
            'price' => 250000.00,
            'stock' => 50,
        ]);

        $book2 = YardageBook::create([
            'event_id' => $event2->id,
            'title' => 'Royale Jakarta Golf Club Official Yardage Book',
            'description' => 'Buku panduan taktis hole 1-18 Royale Jakarta Golf Club lengkap dengan elevasi dan breakdown green.',
            'cover_image' => 'book_royale_jakarta.jpg',
            'price' => 300000.00,
            'stock' => 30,
        ]);

        $book3 = YardageBook::create([
            'event_id' => $event3->id,
            'title' => 'Bali National Golf Club Official Yardage Book',
            'description' => 'Buku petunjuk jarak lengkap untuk Bali National Golf Club dengan visual grafis 3D rintangan lapangan.',
            'cover_image' => 'book_bali_national.jpg',
            'price' => 280000.00,
            'stock' => 40,
        ]);

        // 8. Seed Peer Listings
        $listing = PeerListing::create([
            'seller_id' => $user1->id,
            'yardage_book_id' => $book1->id,
            'price' => 180000.00,
            'status' => 'active',
            'description' => 'Kondisi mulus 95%, coretan pensil tipis di hole 4 sudah dihapus bersih. Siap kirim se-Indonesia.',
        ]);

        // 9. Seed Orders
        YardageOrder::create([
            'user_id' => $user1->id,
            'yardage_book_id' => $book1->id,
            'quantity' => 1,
            'total_price' => 250000.00,
            'status' => 'completed',
            'type' => 'buy_new',
        ]);
    }
}
