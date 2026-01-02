<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds with comprehensive category data.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Action',
                'slug' => 'action',
                'description' => 'Heart-pounding excitement with intense fight sequences, car chases, and explosive stunts. Perfect for adrenaline junkies who love high-octane entertainment.',
                'icon' => 'fa-solid fa-explosion',
            ],
            [
                'name' => 'Drama',
                'slug' => 'drama',
                'description' => 'Emotionally compelling stories that explore the human condition. Character-driven narratives that will make you laugh, cry, and everything in between.',
                'icon' => 'fa-solid fa-masks-theater',
            ],
            [
                'name' => 'Comedy',
                'slug' => 'comedy',
                'description' => 'Lighthearted entertainment guaranteed to put a smile on your face. From witty comedies to slapstick humor, find your perfect dose of laughter.',
                'icon' => 'fa-solid fa-face-laugh-squint',
            ],
            [
                'name' => 'Horror',
                'slug' => 'horror',
                'description' => 'Spine-chilling thrills and terrifying tales that will keep you on the edge of your seat. Enter if you dare—sweet dreams not guaranteed.',
                'icon' => 'fa-solid fa-ghost',
            ],
            [
                'name' => 'Sci-Fi',
                'slug' => 'sci-fi',
                'description' => 'Explore the boundaries of imagination with futuristic technology, space exploration, and mind-bending concepts. The future is here.',
                'icon' => 'fa-solid fa-rocket',
            ],
            [
                'name' => 'Animation',
                'slug' => 'animation',
                'description' => 'Stunning visual artistry for all ages. From beloved family favorites to cutting-edge anime, animation brings impossible worlds to life.',
                'icon' => 'fa-solid fa-palette',
            ],
            [
                'name' => 'Thriller',
                'slug' => 'thriller',
                'description' => 'Suspenseful stories with unexpected twists that keep you guessing. Psychological tension and gripping narratives that demand your full attention.',
                'icon' => 'fa-solid fa-user-secret',
            ],
            [
                'name' => 'Romance',
                'slug' => 'romance',
                'description' => 'Heartwarming love stories that celebrate the magic of human connection. From first glances to everlasting bonds, experience love in all its forms.',
                'icon' => 'fa-solid fa-heart',
            ],
            [
                'name' => 'Documentary',
                'slug' => 'documentary',
                'description' => 'Real stories that inform, inspire, and challenge perspectives. Explore fascinating subjects through the lens of truth and discovery.',
                'icon' => 'fa-solid fa-video',
            ],
            [
                'name' => 'Fantasy',
                'slug' => 'fantasy',
                'description' => 'Magical worlds filled with mythical creatures, epic quests, and supernatural powers. Escape reality and enter realms of wonder.',
                'icon' => 'fa-solid fa-wand-magic-sparkles',
            ],
            [
                'name' => 'Crime',
                'slug' => 'crime',
                'description' => 'Gripping tales of heists, investigations, and the criminal underworld. From detective mysteries to mob sagas, explore the darker side of humanity.',
                'icon' => 'fa-solid fa-handcuffs',
            ],
            [
                'name' => 'Mystery',
                'slug' => 'mystery',
                'description' => 'Puzzling narratives that challenge you to solve the case before the final reveal. Clues, red herrings, and shocking twists await.',
                'icon' => 'fa-solid fa-magnifying-glass',
            ],
            [
                'name' => 'Adventure',
                'slug' => 'adventure',
                'description' => 'Epic journeys and daring exploits across exotic locations. Join heroes as they discover treasure, face danger, and find themselves.',
                'icon' => 'fa-solid fa-mountain-sun',
            ],
            [
                'name' => 'Family',
                'slug' => 'family',
                'description' => 'Wholesome entertainment perfect for viewers of all ages. Warm, funny, and heartfelt stories that bring families together.',
                'icon' => 'fa-solid fa-people-roof',
            ],
            [
                'name' => 'War',
                'slug' => 'war',
                'description' => 'Powerful stories of courage, sacrifice, and survival set against the backdrop of historic and modern conflicts.',
                'icon' => 'fa-solid fa-helmet-battle',
            ],
            [
                'name' => 'History',
                'slug' => 'history',
                'description' => 'Journey through time with dramatized accounts of real events and historical figures. The past comes alive on screen.',
                'icon' => 'fa-solid fa-landmark',
            ],
            [
                'name' => 'Music',
                'slug' => 'music',
                'description' => 'Stories that celebrate the power of music, from biopics of legendary artists to tales of aspiring musicians chasing their dreams.',
                'icon' => 'fa-solid fa-music',
            ],
            [
                'name' => 'Western',
                'slug' => 'western',
                'description' => 'Tales of the Wild West featuring cowboys, outlaws, and frontier justice. Dusty towns, showdowns, and the spirit of adventure.',
                'icon' => 'fa-solid fa-hat-cowboy',
            ],
            [
                'name' => 'Sport',
                'slug' => 'sport',
                'description' => 'Inspiring stories of athletic achievement, teamwork, and personal triumph. From underdogs to champions, witness the thrill of victory.',
                'icon' => 'fa-solid fa-futbol',
            ],
            [
                'name' => 'Biography',
                'slug' => 'biography',
                'description' => 'True stories of remarkable individuals who shaped history, culture, and society. Intimate portraits of extraordinary lives.',
                'icon' => 'fa-solid fa-user-pen',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }
    }
}
