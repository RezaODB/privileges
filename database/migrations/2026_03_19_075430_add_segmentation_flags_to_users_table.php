<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('nl')->default(false)->after('eject');
            $table->boolean('fr')->default(false)->after('nl');
            $table->boolean('repro')->default(false)->after('fr');
            $table->boolean('doute')->default(false)->after('repro');
            $table->boolean('lgtb')->default(false)->after('doute');
            $table->boolean('senior')->default(false)->after('lgtb');
            $table->boolean('racises')->default(false)->after('senior');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nl',
                'fr',
                'repro',
                'doute',
                'lgtb',
                'senior',
                'racises',
            ]);
        });
    }
};
