<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds with optimized batch processing.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ratings')->truncate();

        // Get all movies and users
        $movieIds = Movie::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        if (empty($movieIds) || empty($userIds)) {
            Schema::enableForeignKeyConstraints();
            return;
        }

        $ratings = [];
        $batchSize = 1000;
        $now = now();

        // Each user rates a random subset of movies (30-70%)
        foreach ($userIds as $userId) {
            // Random subset of movies for this user
            $numMovies = rand(
                (int)(count($movieIds) * 0.3), 
                (int)(count($movieIds) * 0.7)
            );
            $selectedMovies = array_rand(array_flip($movieIds), min($numMovies, count($movieIds)));
            
            if (!is_array($selectedMovies)) {
                $selectedMovies = [$selectedMovies];
            }

            foreach ($selectedMovies as $movieId) {
                // Natural distribution: more ratings around 6-8
                $rating = $this->generateNaturalRating();
                
                $ratings[] = [
                    'user_id' => $userId,
                    'movie_id' => $movieId,
                    'rating' => $rating,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // Batch insert to avoid memory issues
                if (count($ratings) >= $batchSize) {
                    DB::table('ratings')->insert($ratings);
                    $ratings = [];
                }
            }
        }

        // Insert remaining ratings
        if (!empty($ratings)) {
            DB::table('ratings')->insert($ratings);
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Generate rating with natural distribution (bell curve around 7)
     */
    private function generateNaturalRating(): float
    {
        // Weighted random to create bell curve distribution
        $weights = [
            1 => 2,   // Very rare
            2 => 3,
            3 => 5,
            4 => 8,
            5 => 12,
            6 => 18,
            7 => 22,  // Most common
            8 => 17,
            9 => 10,
            10 => 3,  // Rare perfect scores
        ];

        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);
        $cumulative = 0;

        foreach ($weights as $rating => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                // Add decimal for more variety
                return $rating + (rand(0, 9) / 10);
            }
        }

        return 7.0;
    }
}
