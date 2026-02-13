<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('important')->default(false)->after('video');
            $table->boolean('shot')->default(false)->after('important');
            $table->boolean('questionnaire')->default(false)->after('shot');
            $table->boolean('interviewed')->default(false)->after('questionnaire');
            $table->boolean('eject')->default(false)->after('interviewed');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'important',
                'shot',
                'questionnaire',
                'interviewed',
                'eject',
            ]);
        });
    }
};
