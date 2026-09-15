<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The four podcasts that lived as hard-coded filenames in the template,
     * so the tab keeps playing them the moment this runs.
     *
     * @var list<array{lang: string, order: int, title: string, guest: string|null, path: string}>
     */
    private const array EXISTING = [
        ['lang' => 'fr', 'order' => 1, 'title' => 'Cadre théorique', 'guest' => null, 'path' => 'theory.mp3'],
        ['lang' => 'fr', 'order' => 2, 'title' => 'Cadre pratique', 'guest' => null, 'path' => 'practice.mp3'],
        ['lang' => 'en', 'order' => 1, 'title' => 'Theoretical framework', 'guest' => null, 'path' => 'theoryEN.mp3'],
        ['lang' => 'en', 'order' => 2, 'title' => 'Practical framework', 'guest' => null, 'path' => 'practiceEN.mp3'],
    ];

    public function up(): void
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('lang', 2);
            $table->unsignedInteger('order');
            $table->string('title');
            $table->string('guest')->nullable();
            $table->string('duration')->nullable();
            $table->string('path');
            $table->timestamps();

            $table->index(['lang', 'order']);
        });

        $now = now();

        DB::table('podcasts')->insert(array_map(
            fn (array $podcast): array => [...$podcast, 'created_at' => $now, 'updated_at' => $now],
            self::EXISTING
        ));
    }

    public function down(): void
    {
        Schema::dropIfExists('podcasts');
    }
};
