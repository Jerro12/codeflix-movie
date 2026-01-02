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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('director')->nullable();
            $table->string('writers')->nullable();
            $table->string('stars')->nullable();
            $table->text('cast')->nullable();
            $table->string('poster');
            $table->date('release_date')->nullable();
            $table->integer('duration')->default(120);
            $table->decimal('rating', 3, 1)->default(0);
            $table->string('url_720')->nullable();
            $table->string('url_1080')->nullable();
            $table->string('url_4k')->nullable();
            $table->string('video_url')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
