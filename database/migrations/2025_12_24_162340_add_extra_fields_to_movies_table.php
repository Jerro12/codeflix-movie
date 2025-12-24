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
        Schema::table('movies', function (Blueprint $table) {
            $table->string('trailer_url')->nullable()->after('poster');
            $table->string('banner')->nullable()->after('trailer_url');
            $table->enum('age_rating', ['G', 'PG', 'PG-13', 'R', 'NC-17'])->default('PG-13')->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['trailer_url', 'banner', 'age_rating']);
        });
    }
};
