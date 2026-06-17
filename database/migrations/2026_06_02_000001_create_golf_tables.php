<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Players Table
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('country')->default('Indonesia');
            $table->text('bio')->nullable();
            $table->enum('hand', ['Left', 'Right'])->default('Right');
            $table->timestamps();
        });

        // 2. Events Table
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->decimal('prizepool', 15, 2);
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('organizer');
            $table->text('sponsorship')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'finished'])->default('upcoming');
            $table->timestamps();
        });

        // 3. Event Players Pivot Table
        Schema::create('event_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->timestamps();
        });

        // 4. Event Pars Table (Set target Par for each of the 18 holes)
        Schema::create('event_pars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->integer('hole_number');
            $table->integer('par_value')->default(4);
            $table->timestamps();

            $table->unique(['event_id', 'hole_number']);
        });

        // 5. Event Scores Table (Store strokes for each player per hole)
        Schema::create('event_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->integer('hole_number');
            $table->integer('strokes');
            $table->timestamps();

            $table->unique(['event_id', 'player_id', 'hole_number']);
        });

        // 6. Yardage Books Table
        Schema::create('yardage_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->decimal('price', 15, 2)->default(0.00);
            $table->integer('stock')->default(0);
            $table->timestamps();
        });

        // 7. Peer Listings Table (P2P yardage book marketplace listings)
        Schema::create('peer_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('yardage_book_id')->constrained('yardage_books')->onDelete('cascade');
            $table->decimal('price', 15, 2);
            $table->enum('status', ['active', 'sold', 'cancelled'])->default('active');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 8. Yardage Orders Table (Official purchases & P2P transactions)
        Schema::create('yardage_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('yardage_book_id')->constrained('yardage_books')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 15, 2);
            $table->enum('status', ['pending', 'completed'])->default('completed');
            $table->enum('type', ['buy_new', 'buy_peer', 'trade'])->default('buy_new');
            $table->foreignId('peer_listing_id')->nullable()->constrained('peer_listings')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yardage_orders');
        Schema::dropIfExists('peer_listings');
        Schema::dropIfExists('yardage_books');
        Schema::dropIfExists('event_scores');
        Schema::dropIfExists('event_pars');
        Schema::dropIfExists('event_players');
        Schema::dropIfExists('events');
        Schema::dropIfExists('players');
    }
};
