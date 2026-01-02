<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with comprehensive data.
     * 
     * This seeder creates:
     * - 55+ Users with multiple profiles
     * - 3 subscription plans
     * - 20 categories
     * - 150+ movies with validated TMDB images
     * - 50+ series with 800+ episodes
     * - Thousands of ratings with natural distribution
     */
    public function run(): void
    {
        $this->command->info('🎬 Starting Codeflix Database Seeder...');
        
        $this->command->info('👤 Seeding Users...');
        $this->call(UserSeeder::class);
        
        $this->command->info('💎 Seeding Plans...');
        $this->call(PlanSeeder::class);
        
        $this->command->info('📁 Seeding Categories...');
        $this->call(CategorySeeder::class);
        
        $this->command->info('🎥 Seeding Movies (150+)...');
        $this->call(MovieSeeder::class);
        
        $this->command->info('📺 Seeding Series (50+ with 800+ episodes)...');
        $this->call(SeriesSeeder::class);
        
        $this->command->info('⭐ Seeding Ratings...');
        $this->call(RatingSeeder::class);
        
        $this->command->info('✅ Database seeding completed successfully!');
    }
}
