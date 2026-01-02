<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MovieSeeder extends Seeder
{
    // Validated TMDB poster paths (confirmed working)
    private array $tmdbPosters = [
        'qJ2tW6WMUDux911r6m7haRef0WH.jpg', 'oYuLEt3zVCKq57qu2F8dT7NIa6f.jpg',
        '8tZYtuWezp8JbcsvHYO0O46tFbo.jpg', 'q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg',
        'arw2vcBveWOVZr6pxd9XTd1TdQa.jpg', '3bhkrj58Vtu7enYsRolD1fZdja1.jpg',
        'eWdyYQreja6JGCzqHWXpWHDrrPo.jpg', 'ek8e8txUyUwd2BNqj6lFEerJfbq.jpg',
        'qbaIViX3tLmEcFc5Zn6g4nMgteL.jpg', 'nAU74GmpUk7t5iklEp3bufwDq4n.jpg',
        'gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 'gajva2L0rPYkEWjzgFlBXCAVBE5.jpg',
        'f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg', 'iiZZdoQBEYBv6id8su7ImL0oCbD.jpg',
        'gGEsBPAijhVUFoiNpgZXqRVWJt2.jpg', '7IiTTgloJzvGI1TAYymCfbfl3vT.jpg',
        'gdiLTof3rbPDAmPaCf4g6op46bj.jpg', 'pB8BM7pdSp6B6Ih7QZ4DrQ3PmJK.jpg',
        '1LRLLWGvs5sZdTzPMBgL0M0dGJ0.jpg', 'vZloFAK7NmvMGKE7VtBBPEBpJWn.jpg',
        'svIDTNUoajS8dLEo7EosxvyAsgJ.jpg', 'lzWHmYdfeFiMIY4JaMmtR7GEli3.jpg',
        'p1F51Lvj3sMopG948F5HsBbl43C.jpg', '4m1Au3YkjqsxF8iwQy0fPYSxE0h.jpg',
        'feSiISwgEpVzR1v3zv2n2AU4ANJ.jpg', 'bOGkgRGdhrBYJSLpXaxhXVstddV.jpg',
        'pIkRyD18kl4FhoCNQuWxWu5cBLM.jpg', 'AoT2YrJUJlg5vKE3iMOLvHlTd3m.jpg',
        'd5NXSklXo0qyIYkgV94XAgMIckC.jpg', 'velWPhVMQeQKcxggNEU8YmIo52R.jpg',
    ];

    // Validated TMDB banner paths
    private array $tmdbBanners = [
        'nMKdUUepR0i5zn0y1T4CsSB5chy.jpg', 's3TBrRGB1iav7gFOCN0CNqpZYGc.jpg',
        'xRWht48C2V8XNfzvPehyClOvDni.jpg', 'kXfqcdQKsToO0OUXHcrrNCHDBzO.jpg',
        '3h1JZGDhZ8nzxdgvkxha0qBqi05.jpg', 'rSPw7tgCH9c6NqICZef4kZjFOQ5.jpg',
        'nX5XotM9yprCKarRH4fzOq1VM1J.jpg', '8bFymJJGGJVHGSwHB9MrK2tXhxJ.jpg',
        'szTExuyIHKrG8qMOT4YT2Vy7nNP.jpg', 'roYyPiQDQKmIKUEhO912bQ2dInZ.jpg',
        'xJHokMbljvjADYdit5fK5VQsXEG.jpg', 'sAtoMqDVhNDQBc3QJL3RF6hlhGq.jpg',
        'ngxqIYQhJO6S6WrXXAFNmSE7zYO.jpg', '7d6EY00g1c39SGZOoCJ5Py9nNth.jpg',
    ];

    // Google sample videos (validated working)
    private array $sampleVideos = [
        'BigBuckBunny.mp4', 'ElephantsDream.mp4', 'ForBiggerBlazes.mp4',
        'ForBiggerEscapes.mp4', 'ForBiggerFun.mp4', 'ForBiggerJoyrides.mp4',
        'ForBiggerMeltdowns.mp4', 'Sintel.mp4', 'SubaruOutbackOnStreetAndDirt.mp4',
        'TearsOfSteel.mp4', 'VolkswagenGTIReview.mp4', 'WeAreGoingOnBullrun.mp4',
    ];

    private array $directors = [
        'Christopher Nolan', 'Steven Spielberg', 'Martin Scorsese', 'Quentin Tarantino',
        'Denis Villeneuve', 'David Fincher', 'Ridley Scott', 'James Cameron',
        'Guillermo del Toro', 'Alfonso Cuarón', 'Bong Joon-ho', 'Jordan Peele',
        'Greta Gerwig', 'Damien Chazelle', 'Wes Anderson', 'Coen Brothers',
        'Paul Thomas Anderson', 'Sam Mendes', 'Spike Lee', 'Kathryn Bigelow',
    ];

    private array $actors = [
        'Leonardo DiCaprio', 'Tom Hanks', 'Denzel Washington', 'Brad Pitt',
        'Robert Downey Jr.', 'Christian Bale', 'Joaquin Phoenix', 'Ryan Gosling',
        'Timothée Chalamet', 'Oscar Isaac', 'Adam Driver', 'Michael B. Jordan',
        'Chadwick Boseman', 'Samuel L. Jackson', 'Morgan Freeman', 'Tom Hardy',
        'Margot Robbie', 'Scarlett Johansson', 'Florence Pugh', 'Saoirse Ronan',
        'Viola Davis', 'Meryl Streep', 'Cate Blanchett', 'Emma Stone',
        'Jennifer Lawrence', 'Natalie Portman', 'Amy Adams', 'Anne Hathaway',
    ];

    public function run(): void
    {
        $this->seedCoreMovies();
        $this->seedGeneratedMovies();
    }

    private function seedCoreMovies(): void
    {
        $movies = $this->getCoreMovies();
        foreach ($movies as $movieData) {
            $this->createMovie($movieData);
        }
    }

    private function seedGeneratedMovies(): void
    {
        $movieTemplates = $this->getMovieTemplates();
        
        foreach ($movieTemplates as $template) {
            for ($i = 1; $i <= $template['count']; $i++) {
                $title = $template['titles'][$i - 1] ?? "{$template['prefix']} {$i}";
                $movieData = [
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'description' => $this->generateDescription($template['category'], $title),
                    'poster' => $this->getRandomPoster(),
                    'banner' => $this->getRandomBanner(),
                    'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'video_url' => $this->getRandomVideo(),
                    'url_720' => $this->getRandomVideo(),
                    'url_1080' => $this->getRandomVideo(),
                    'url_4k' => $this->getRandomVideo(),
                    'release_date' => $this->randomDate(),
                    'duration' => rand(85, 180),
                    'rating' => round(rand(60, 95) / 10, 1),
                    'director' => $this->directors[array_rand($this->directors)],
                    'cast' => $this->getRandomCast(),
                    'age_rating' => $this->getRandomAgeRating(),
                    'category' => $template['category'],
                ];
                $this->createMovie($movieData);
            }
        }
    }

    private function createMovie(array $movieData): void
    {
        $category = Category::where('name', $movieData['category'])->first();
        if (!$category) {
            $category = Category::create([
                'name' => $movieData['category'],
                'slug' => Str::slug($movieData['category']),
            ]);
        }

        $categoryName = $movieData['category'];
        unset($movieData['category']);
        $movieData['category_id'] = $category->id;

        $movie = Movie::updateOrCreate(
            ['slug' => $movieData['slug']],
            $movieData
        );
        $movie->categories()->syncWithoutDetaching([$category->id]);
    }

    private function getRandomPoster(): string
    {
        return 'https://image.tmdb.org/t/p/w500/' . $this->tmdbPosters[array_rand($this->tmdbPosters)];
    }

    private function getRandomBanner(): string
    {
        return 'https://image.tmdb.org/t/p/original/' . $this->tmdbBanners[array_rand($this->tmdbBanners)];
    }

    private function getRandomVideo(): string
    {
        return 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/' . $this->sampleVideos[array_rand($this->sampleVideos)];
    }

    private function getRandomCast(): string
    {
        $cast = array_rand(array_flip($this->actors), rand(4, 7));
        return implode(', ', $cast);
    }

    private function getRandomAgeRating(): string
    {
        $ratings = ['G', 'PG', 'PG-13', 'R', 'NC-17'];
        return $ratings[array_rand($ratings)];
    }

    private function randomDate(): string
    {
        $start = strtotime('1990-01-01');
        $end = strtotime('2024-12-01');
        return date('Y-m-d', rand($start, $end));
    }

    private function generateDescription(string $category, string $title): string
    {
        $templates = [
            'Action' => "In this explosive action thriller, {$title} delivers non-stop adrenaline with breathtaking stunts, intense combat sequences, and a gripping storyline that keeps you on the edge of your seat from start to finish.",
            'Drama' => "{$title} is a deeply moving drama that explores the complexities of human emotion and relationships. With powerful performances and a compelling narrative, this film touches the heart and stays with you long after the credits roll.",
            'Comedy' => "Get ready to laugh out loud with {$title}, a hilarious comedy that combines sharp wit, memorable characters, and perfectly timed humor to deliver an entertaining experience for audiences of all ages.",
            'Horror' => "{$title} plunges viewers into a nightmare of terror and suspense. With chilling atmosphere, shocking twists, and genuinely frightening moments, this horror masterpiece will haunt your dreams.",
            'Sci-Fi' => "Set in a visionary future, {$title} explores the boundaries of science and imagination. With stunning visual effects and thought-provoking themes, this sci-fi epic redefines the genre.",
            'Thriller' => "{$title} is a pulse-pounding thriller that keeps you guessing until the very end. With unexpected twists, mounting tension, and a story that grips you from the first frame.",
            'Romance' => "Experience the magic of love with {$title}, a heartwarming romance that celebrates the beauty of human connection. A touching story of passion, devotion, and the power of true love.",
            'Fantasy' => "Enter a world of wonder with {$title}, an epic fantasy adventure filled with mythical creatures, ancient magic, and heroes destined for greatness. A journey beyond imagination awaits.",
            'Animation' => "{$title} brings stunning animation and unforgettable characters to life in this visually spectacular adventure. Perfect for audiences of all ages, this animated masterpiece is pure magic.",
            'Crime' => "Dive into the criminal underworld with {$title}, a gripping crime saga that explores the thin line between law and lawlessness. A tale of betrayal, justice, and consequences.",
            'Mystery' => "{$title} weaves an intricate web of clues, suspects, and shocking revelations. This captivating mystery will challenge your deductive skills until the final twist is revealed.",
            'Adventure' => "Embark on an epic journey with {$title}, an adventure that takes you across breathtaking landscapes and into the heart of danger. A tale of courage, discovery, and triumph.",
            'Documentary' => "{$title} offers a compelling look into real events and extraordinary people. This thought-provoking documentary challenges perspectives and inspires meaningful reflection.",
            'Family' => "{$title} is a heartwarming family film that brings generations together. With lovable characters and valuable lessons, this movie creates memories that last a lifetime.",
            'War' => "{$title} depicts the courage and sacrifice of those who served. A powerful war epic that honors the human spirit in the face of unimaginable adversity.",
            'Biography' => "{$title} tells the remarkable true story of an extraordinary individual. An inspiring biographical journey through triumph, struggle, and the legacy left behind.",
        ];
        return $templates[$category] ?? "Discover the extraordinary story of {$title}, a cinematic experience that captivates audiences with its compelling narrative, stunning visuals, and unforgettable performances.";
    }

    private function getCoreMovies(): array
    {
        return [
            ['title' => 'The Dark Knight', 'slug' => 'the-dark-knight', 'description' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.', 'poster' => 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 'banner' => 'https://image.tmdb.org/t/p/original/nMKdUUepR0i5zn0y1T4CsSB5chy.jpg', 'trailer_url' => 'https://www.youtube.com/watch?v=EXeTwQWrcwY', 'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'url_720' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'url_1080' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'url_4k' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'release_date' => '2008-07-18', 'duration' => 152, 'rating' => 9.0, 'director' => 'Christopher Nolan', 'cast' => 'Christian Bale, Heath Ledger, Aaron Eckhart, Michael Caine, Gary Oldman', 'age_rating' => 'PG-13', 'category' => 'Action'],
            ['title' => 'Inception', 'slug' => 'inception', 'description' => 'A thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.', 'poster' => 'https://image.tmdb.org/t/p/w500/oYuLEt3zVCKq57qu2F8dT7NIa6f.jpg', 'banner' => 'https://image.tmdb.org/t/p/original/s3TBrRGB1iav7gFOCN0CNqpZYGc.jpg', 'trailer_url' => 'https://www.youtube.com/watch?v=YoHD9XEInc0', 'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', 'url_720' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', 'url_1080' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', 'url_4k' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', 'release_date' => '2010-07-16', 'duration' => 148, 'rating' => 8.8, 'director' => 'Christopher Nolan', 'cast' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Tom Hardy, Cillian Murphy', 'age_rating' => 'PG-13', 'category' => 'Action'],
            ['title' => 'The Shawshank Redemption', 'slug' => 'the-shawshank-redemption', 'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 'poster' => 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg', 'banner' => 'https://image.tmdb.org/t/p/original/kXfqcdQKsToO0OUXHcrrNCHDBzO.jpg', 'trailer_url' => 'https://www.youtube.com/watch?v=6hB3S9bIaco', 'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4', 'url_720' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4', 'url_1080' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4', 'url_4k' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4', 'release_date' => '1994-09-23', 'duration' => 142, 'rating' => 9.3, 'director' => 'Frank Darabont', 'cast' => 'Tim Robbins, Morgan Freeman, Bob Gunton, William Sadler', 'age_rating' => 'R', 'category' => 'Drama'],
            ['title' => 'Interstellar', 'slug' => 'interstellar', 'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanitys survival.', 'poster' => 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 'banner' => 'https://image.tmdb.org/t/p/original/xJHokMbljvjADYdit5fK5VQsXEG.jpg', 'trailer_url' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E', 'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4', 'url_720' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4', 'url_1080' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4', 'url_4k' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4', 'release_date' => '2014-11-07', 'duration' => 169, 'rating' => 8.6, 'director' => 'Christopher Nolan', 'cast' => 'Matthew McConaughey, Anne Hathaway, Jessica Chastain, Michael Caine', 'age_rating' => 'PG-13', 'category' => 'Sci-Fi'],
            ['title' => 'Parasite', 'slug' => 'parasite', 'description' => 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.', 'poster' => 'https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg', 'banner' => 'https://image.tmdb.org/t/p/original/TU9NIjwzjoKPwQHoHshkFcQUCG.jpg', 'trailer_url' => 'https://www.youtube.com/watch?v=5xH0HfJHsaY', 'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4', 'url_720' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4', 'url_1080' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4', 'url_4k' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4', 'release_date' => '2019-05-30', 'duration' => 132, 'rating' => 8.5, 'director' => 'Bong Joon-ho', 'cast' => 'Song Kang-ho, Lee Sun-kyun, Cho Yeo-jeong, Choi Woo-shik', 'age_rating' => 'R', 'category' => 'Thriller'],
        ];
    }

    private function getMovieTemplates(): array
    {
        return [
            ['category' => 'Action', 'prefix' => 'Action', 'count' => 18, 'titles' => ['Mad Max: Fury Road', 'John Wick', 'The Raid', 'Die Hard', 'Mission: Impossible', 'Gladiator', 'The Bourne Identity', 'Kill Bill', 'Top Gun: Maverick', 'Atomic Blonde', 'Nobody', 'Extraction', 'The Gray Man', 'Bullet Train', 'Fast X', 'Fury', 'Black Hawk Down', 'Sicario']],
            ['category' => 'Drama', 'prefix' => 'Drama', 'count' => 14, 'titles' => ['Forrest Gump', 'The Godfather', 'Schindlers List', 'Fight Club', 'The Green Mile', 'A Beautiful Mind', 'Good Will Hunting', 'The Pursuit of Happyness', 'Whiplash', 'Marriage Story', 'Manchester by the Sea', 'Moonlight', 'The Father', 'Nomadland']],
            ['category' => 'Comedy', 'prefix' => 'Comedy', 'count' => 12, 'titles' => ['The Grand Budapest Hotel', 'Superbad', 'The Hangover', 'Bridesmaids', 'Step Brothers', 'Anchorman', 'Dumb and Dumber', 'The Big Lebowski', 'Knives Out', 'Game Night', 'Palm Springs', 'Free Guy']],
            ['category' => 'Horror', 'prefix' => 'Horror', 'count' => 12, 'titles' => ['Get Out', 'A Quiet Place', 'Hereditary', 'The Conjuring', 'IT', 'Midsommar', 'The Witch', 'Us', 'Annihilation', 'The Babadook', 'Dont Breathe', 'Smile']],
            ['category' => 'Sci-Fi', 'prefix' => 'SciFi', 'count' => 14, 'titles' => ['Blade Runner 2049', 'The Matrix', 'Dune', 'Arrival', 'Ex Machina', 'The Martian', 'Gravity', 'District 9', 'Edge of Tomorrow', 'Looper', 'Tenet', 'Everything Everywhere All at Once', 'Nope', 'Oppenheimer']],
            ['category' => 'Animation', 'prefix' => 'Animation', 'count' => 10, 'titles' => ['Spider-Man: Into the Spider-Verse', 'Coco', 'Your Name', 'Spirited Away', 'The Lion King', 'Toy Story', 'Finding Nemo', 'Inside Out', 'Encanto', 'Puss in Boots: The Last Wish']],
            ['category' => 'Thriller', 'prefix' => 'Thriller', 'count' => 11, 'titles' => ['Gone Girl', 'Se7en', 'Zodiac', 'Prisoners', 'Shutter Island', 'The Silence of the Lambs', 'No Country for Old Men', 'Nightcrawler', 'The Departed', 'Black Swan', 'Split']],
            ['category' => 'Romance', 'prefix' => 'Romance', 'count' => 10, 'titles' => ['The Notebook', 'La La Land', 'Pride and Prejudice', 'Titanic', 'Before Sunrise', 'Crazy Rich Asians', 'The Fault in Our Stars', 'A Star Is Born', 'Call Me by Your Name', 'Past Lives']],
            ['category' => 'Fantasy', 'prefix' => 'Fantasy', 'count' => 10, 'titles' => ['The Lord of the Rings', 'Harry Potter', 'Pan\'s Labyrinth', 'The Shape of Water', 'Stardust', 'The Princess Bride', 'Coraline', 'Fantastic Beasts', 'Maleficent', 'The Chronicles of Narnia']],
            ['category' => 'Crime', 'prefix' => 'Crime', 'count' => 12, 'titles' => ['Pulp Fiction', 'The Usual Suspects', 'Heat', 'Goodfellas', 'Casino', 'The Town', 'Baby Driver', 'Reservoir Dogs', 'Snatch', 'Logan Lucky', 'Den of Thieves', 'Widows']],
            ['category' => 'Mystery', 'prefix' => 'Mystery', 'count' => 8, 'titles' => ['The Prestige', 'Memento', 'Murder on the Orient Express', 'The Girl with the Dragon Tattoo', 'Knives Out 2', 'Gone Baby Gone', 'Mystic River', 'The Sixth Sense']],
            ['category' => 'Adventure', 'prefix' => 'Adventure', 'count' => 12, 'titles' => ['Indiana Jones', 'Jurassic Park', 'Pirates of the Caribbean', 'Avatar', 'Life of Pi', 'The Revenant', 'Into the Wild', 'Cast Away', 'King Kong', 'Jungle Cruise', 'Uncharted', 'The Lost City']],
            ['category' => 'Documentary', 'prefix' => 'Documentary', 'count' => 8, 'titles' => ['Planet Earth', 'Free Solo', 'Won\'t You Be My Neighbor', 'The Social Dilemma', 'Blackfish', '13th', 'Icarus', 'My Octopus Teacher']],
            ['category' => 'Family', 'prefix' => 'Family', 'count' => 8, 'titles' => ['Home Alone', 'The Incredibles', 'Paddington', 'Frozen', 'Shrek', 'Up', 'WALL-E', 'Moana']],
            ['category' => 'War', 'prefix' => 'War', 'count' => 6, 'titles' => ['Saving Private Ryan', '1917', 'Dunkirk', 'Hacksaw Ridge', 'Apocalypse Now', 'Full Metal Jacket']],
            ['category' => 'Biography', 'prefix' => 'Biography', 'count' => 8, 'titles' => ['Bohemian Rhapsody', 'The Social Network', 'The Imitation Game', 'Steve Jobs', 'The Theory of Everything', 'Elvis', 'Rocketman', 'Ray']],
        ];
    }
}
