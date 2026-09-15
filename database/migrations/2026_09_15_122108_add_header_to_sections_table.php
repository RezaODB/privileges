<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->string('number')->nullable()->after('slug');
            $table->string('subtitle_fr')->nullable()->after('title_en');
            $table->string('subtitle_en')->nullable()->after('subtitle_fr');
            $table->text('intro_fr')->nullable()->after('subtitle_en');
            $table->text('intro_en')->nullable()->after('intro_fr');
            $table->text('quote_fr')->nullable()->after('intro_en');
            $table->text('quote_en')->nullable()->after('quote_fr');
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn([
                'number',
                'subtitle_fr',
                'subtitle_en',
                'intro_fr',
                'intro_en',
                'quote_fr',
                'quote_en',
            ]);
        });
    }
};
