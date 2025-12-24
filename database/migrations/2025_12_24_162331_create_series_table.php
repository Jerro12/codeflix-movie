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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('poster');
            $table->string('banner')->nullable();
            $table->string('director')->nullable();
            $table->string('cast')->nullable();
            $table->year('release_year');
            $table->enum('status', ['ongoing', 'completed', 'cancelled'])->default('ongoing');
            $table->enum('age_rating', ['G', 'PG', 'PG-13', 'R', 'NC-17'])->default('PG-13');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
