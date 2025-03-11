<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('administrators', function (Blueprint $table) {
            $table->dropColumn('name'); // Supprime l'ancien champ
            $table->string('first_name', 50)->after('id');
            $table->string('last_name', 50)->after('first_name');
        });
    }

    public function down(): void
    {
        Schema::table('administrators', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
            $table->string('name', 100)->after('id');
        });
    }
};