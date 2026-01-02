<?php

namespace Database\Seeders;

use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SeriesSeeder extends Seeder
{
    private array $tmdbPosters = [
        'ggFHVNu6YYI5L9pCfOacjizRGt.jpg', 'u3bZgnGQ9T01sWNhyveQz0wH0Hl.jpg',
        '49WJfeN0moxb9IPfGn8AIqMGskD.jpg', 'qWnJzyZhyy74gjpSjIXWmuk0ifX.jpg',
        '7WJsMuSpjU1h8NJUdoLIGdGblIN.jpg', 'e3NBGiAifW9Xt8xD5tpARskjccO.jpg',
        'zU0htwkhNvBQdVSIKB9s6hgVeFK.jpg', '34OGjFEbHj0E3lE2w0iTUVq0CBz.jpg',
        'gKG5QGz5Ngf8fgWpBsWtlg5L2SF.jpg', 'aCw8ONfyz3AhngVQa1E2Ss4KBPF.jpg',
        'lz4xYdF1n85JdPfzsVIKfZ41XsX.jpg', 'z97CXs3xP0eDz9K7g5vCBxgD2Kp.jpg',
    ];

    private array $tmdbBanners = [
        'tsRy63Mu5cu8etL1X7ZLyf7URnw.jpg', 'suopoADq0k8YZr4dQXcU6pToj6s.jpg',
        '56v2KjBlU4XaOv9rVYEQypROD7P.jpg', 'd8JxB9l4Jxhk9qcW64b3t6tlh1z.jpg',
        '70YdbMELM4b8x8VXjlubymb2bQ0.jpg', 'wiE9doxiLwq3WCGamDIOb2PqBqh.jpg',
    ];

    private array $sampleVideos = [
        'BigBuckBunny.mp4', 'ElephantsDream.mp4', 'ForBiggerBlazes.mp4',
        'ForBiggerEscapes.mp4', 'ForBiggerFun.mp4', 'Sintel.mp4', 'TearsOfSteel.mp4',
    ];

    private array $directors = [
        'Vince Gilligan', 'David Benioff', 'The Duffer Brothers', 'Greg Daniels',
        'Shonda Rhimes', 'Ryan Murphy', 'Taylor Sheridan', 'Mike White',
        'Hwang Dong-hyuk', 'Sam Levinson', 'Jesse Armstrong', 'Amy Sherman-Palladino',
    ];

    private array $actors = [
        'Bryan Cranston', 'Emilia Clarke', 'Millie Bobby Brown', 'Steve Carell',
        'Pedro Pascal', 'Jenna Ortega', 'Zendaya', 'Jason Bateman', 'Julia Garner',
        'Jeremy Strong', 'Sarah Snook', 'Jennifer Coolidge', 'Aubrey Plaza',
        'Adam Scott', 'Elizabeth Moss', 'Evan Peters', 'Kit Harington', 'Peter Dinklage',
    ];

    public function run(): void
    {
        $seriesData = $this->getAllSeries();
        
        foreach ($seriesData as $data) {
            $category = Category::where('name', $data['category'])->first();
            
            $series = Series::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'slug' => $data['slug'],
                    'description' => $data['description'],
                    'poster' => $data['poster'],
                    'banner' => $data['banner'],
                    'release_year' => $data['release_year'],
                    'status' => $data['status'],
                    'director' => $data['director'],
                    'cast' => $data['cast'],
                    'age_rating' => $data['age_rating'],
                    'category_id' => $category?->id,
                ]
            );

            foreach ($data['seasons'] as $seasonData) {
                $season = Season::updateOrCreate(
                    ['series_id' => $series->id, 'number' => $seasonData['number']],
                    ['title' => $seasonData['title']]
                );

                foreach ($seasonData['episodes'] as $episodeData) {
                    Episode::updateOrCreate(
                        ['season_id' => $season->id, 'number' => $episodeData['number']],
                        [
                            'title' => $episodeData['title'],
                            'description' => $episodeData['description'],
                            'duration' => $episodeData['duration'],
                            'url_720' => $this->getRandomVideo(),
                            'url_1080' => $this->getRandomVideo(),
                            'url_4k' => $this->getRandomVideo(),
                        ]
                    );
                }
            }
        }
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
        $cast = array_rand(array_flip($this->actors), rand(4, 6));
        return implode(', ', $cast);
    }

    private function generateEpisodes(int $count, string $seriesTitle): array
    {
        $episodes = [];
        $episodeTitles = $this->getEpisodeTitles();
        
        for ($i = 1; $i <= $count; $i++) {
            $episodes[] = [
                'number' => $i,
                'title' => $episodeTitles[array_rand($episodeTitles)] . ' Part ' . $i,
                'description' => "Episode {$i} of {$seriesTitle} continues the thrilling story with unexpected twists and compelling character development that keeps viewers on the edge of their seats.",
                'duration' => rand(35, 65),
            ];
        }
        return $episodes;
    }

    private function getEpisodeTitles(): array
    {
        return [
            'The Beginning', 'Dark Secrets', 'Rising Tension', 'Breaking Point',
            'Revelations', 'The Truth', 'Consequences', 'New Horizons',
            'Into Darkness', 'The Reckoning', 'Crossroads', 'Shadows',
            'Redemption', 'The Storm', 'Awakening', 'Final Stand',
        ];
    }

    private function generateSeasons(int $count, string $seriesTitle, int $epPerSeason): array
    {
        $seasons = [];
        for ($s = 1; $s <= $count; $s++) {
            $seasons[] = [
                'number' => $s,
                'title' => "Season {$s}",
                'episodes' => $this->generateEpisodes($epPerSeason, $seriesTitle),
            ];
        }
        return $seasons;
    }

    private function getAllSeries(): array
    {
        $seriesTemplates = [
            // Drama (12 series)
            ['title' => 'Breaking Bad', 'category' => 'Drama', 'year' => 2008, 'seasons' => 5, 'ep' => 10],
            ['title' => 'The Crown', 'category' => 'Drama', 'year' => 2016, 'seasons' => 6, 'ep' => 10],
            ['title' => 'Succession', 'category' => 'Drama', 'year' => 2018, 'seasons' => 4, 'ep' => 10],
            ['title' => 'Better Call Saul', 'category' => 'Drama', 'year' => 2015, 'seasons' => 6, 'ep' => 10],
            ['title' => 'The Handmaids Tale', 'category' => 'Drama', 'year' => 2017, 'seasons' => 5, 'ep' => 10],
            ['title' => 'Ozark', 'category' => 'Drama', 'year' => 2017, 'seasons' => 4, 'ep' => 10],
            ['title' => 'Mad Men', 'category' => 'Drama', 'year' => 2007, 'seasons' => 7, 'ep' => 13],
            ['title' => 'The Wire', 'category' => 'Drama', 'year' => 2002, 'seasons' => 5, 'ep' => 10],
            ['title' => 'The Sopranos', 'category' => 'Drama', 'year' => 1999, 'seasons' => 6, 'ep' => 13],
            ['title' => 'House of Cards', 'category' => 'Drama', 'year' => 2013, 'seasons' => 6, 'ep' => 13],
            ['title' => 'Yellowstone', 'category' => 'Drama', 'year' => 2018, 'seasons' => 5, 'ep' => 10],
            ['title' => 'This Is Us', 'category' => 'Drama', 'year' => 2016, 'seasons' => 6, 'ep' => 18],

            // Comedy (8 series)
            ['title' => 'The Office', 'category' => 'Comedy', 'year' => 2005, 'seasons' => 9, 'ep' => 22],
            ['title' => 'Parks and Recreation', 'category' => 'Comedy', 'year' => 2009, 'seasons' => 7, 'ep' => 13],
            ['title' => 'Brooklyn Nine-Nine', 'category' => 'Comedy', 'year' => 2013, 'seasons' => 8, 'ep' => 18],
            ['title' => 'Ted Lasso', 'category' => 'Comedy', 'year' => 2020, 'seasons' => 3, 'ep' => 12],
            ['title' => 'Schitts Creek', 'category' => 'Comedy', 'year' => 2015, 'seasons' => 6, 'ep' => 13],
            ['title' => 'The Good Place', 'category' => 'Comedy', 'year' => 2016, 'seasons' => 4, 'ep' => 13],
            ['title' => 'Barry', 'category' => 'Comedy', 'year' => 2018, 'seasons' => 4, 'ep' => 8],
            ['title' => 'What We Do in the Shadows', 'category' => 'Comedy', 'year' => 2019, 'seasons' => 5, 'ep' => 10],

            // Sci-Fi (8 series)
            ['title' => 'Stranger Things', 'category' => 'Sci-Fi', 'year' => 2016, 'seasons' => 4, 'ep' => 9],
            ['title' => 'Black Mirror', 'category' => 'Sci-Fi', 'year' => 2011, 'seasons' => 6, 'ep' => 6],
            ['title' => 'Westworld', 'category' => 'Sci-Fi', 'year' => 2016, 'seasons' => 4, 'ep' => 10],
            ['title' => 'The Expanse', 'category' => 'Sci-Fi', 'year' => 2015, 'seasons' => 6, 'ep' => 10],
            ['title' => 'Severance', 'category' => 'Sci-Fi', 'year' => 2022, 'seasons' => 2, 'ep' => 9],
            ['title' => 'Dark', 'category' => 'Sci-Fi', 'year' => 2017, 'seasons' => 3, 'ep' => 8],
            ['title' => 'Altered Carbon', 'category' => 'Sci-Fi', 'year' => 2018, 'seasons' => 2, 'ep' => 8],
            ['title' => 'Foundation', 'category' => 'Sci-Fi', 'year' => 2021, 'seasons' => 2, 'ep' => 10],

            // Thriller (6 series)
            ['title' => 'Mindhunter', 'category' => 'Thriller', 'year' => 2017, 'seasons' => 2, 'ep' => 9],
            ['title' => 'You', 'category' => 'Thriller', 'year' => 2018, 'seasons' => 4, 'ep' => 10],
            ['title' => 'Mr. Robot', 'category' => 'Thriller', 'year' => 2015, 'seasons' => 4, 'ep' => 10],
            ['title' => 'Hannibal', 'category' => 'Thriller', 'year' => 2013, 'seasons' => 3, 'ep' => 13],
            ['title' => 'Killing Eve', 'category' => 'Thriller', 'year' => 2018, 'seasons' => 4, 'ep' => 8],
            ['title' => 'The Americans', 'category' => 'Thriller', 'year' => 2013, 'seasons' => 6, 'ep' => 10],

            // Fantasy (6 series)
            ['title' => 'Game of Thrones', 'category' => 'Fantasy', 'year' => 2011, 'seasons' => 8, 'ep' => 10],
            ['title' => 'House of the Dragon', 'category' => 'Fantasy', 'year' => 2022, 'seasons' => 2, 'ep' => 10],
            ['title' => 'The Witcher', 'category' => 'Fantasy', 'year' => 2019, 'seasons' => 3, 'ep' => 8],
            ['title' => 'The Lord of the Rings: Rings of Power', 'category' => 'Fantasy', 'year' => 2022, 'seasons' => 2, 'ep' => 8],
            ['title' => 'Shadow and Bone', 'category' => 'Fantasy', 'year' => 2021, 'seasons' => 2, 'ep' => 8],
            ['title' => 'The Wheel of Time', 'category' => 'Fantasy', 'year' => 2021, 'seasons' => 2, 'ep' => 8],

            // Crime (5 series)
            ['title' => 'True Detective', 'category' => 'Crime', 'year' => 2014, 'seasons' => 4, 'ep' => 8],
            ['title' => 'Fargo', 'category' => 'Crime', 'year' => 2014, 'seasons' => 5, 'ep' => 10],
            ['title' => 'Peaky Blinders', 'category' => 'Crime', 'year' => 2013, 'seasons' => 6, 'ep' => 6],
            ['title' => 'Narcos', 'category' => 'Crime', 'year' => 2015, 'seasons' => 3, 'ep' => 10],
            ['title' => 'Money Heist', 'category' => 'Crime', 'year' => 2017, 'seasons' => 5, 'ep' => 8],

            // Animation (5 series)
            ['title' => 'Arcane', 'category' => 'Animation', 'year' => 2021, 'seasons' => 2, 'ep' => 9],
            ['title' => 'Attack on Titan', 'category' => 'Animation', 'year' => 2013, 'seasons' => 4, 'ep' => 16],
            ['title' => 'Rick and Morty', 'category' => 'Animation', 'year' => 2013, 'seasons' => 7, 'ep' => 10],
            ['title' => 'Invincible', 'category' => 'Animation', 'year' => 2021, 'seasons' => 2, 'ep' => 8],
            ['title' => 'Castlevania', 'category' => 'Animation', 'year' => 2017, 'seasons' => 4, 'ep' => 10],
        ];

        $allSeries = [];
        $statuses = ['Completed', 'Ongoing', 'Completed', 'Completed'];
        $ageRatings = ['TV-14', 'TV-MA', 'TV-PG', 'TV-MA'];

        foreach ($seriesTemplates as $template) {
            $allSeries[] = [
                'title' => $template['title'],
                'slug' => Str::slug($template['title']),
                'description' => $this->generateSeriesDescription($template['title'], $template['category']),
                'poster' => $this->getRandomPoster(),
                'banner' => $this->getRandomBanner(),
                'release_year' => $template['year'],
                'status' => $statuses[array_rand($statuses)],
                'director' => $this->directors[array_rand($this->directors)],
                'cast' => $this->getRandomCast(),
                'age_rating' => $ageRatings[array_rand($ageRatings)],
                'category' => $template['category'],
                'seasons' => $this->generateSeasons($template['seasons'], $template['title'], $template['ep']),
            ];
        }

        return $allSeries;
    }

    private function generateSeriesDescription(string $title, string $category): string
    {
        $templates = [
            'Drama' => "{$title} is an acclaimed drama series that delves deep into the human experience, featuring complex characters and emotionally resonant storytelling that has captivated audiences worldwide.",
            'Comedy' => "{$title} delivers non-stop laughs with its brilliant comedic timing, memorable ensemble cast, and sharp writing that has made it a beloved favorite among comedy enthusiasts.",
            'Sci-Fi' => "{$title} pushes the boundaries of imagination with its visionary science fiction storytelling, stunning visual effects, and thought-provoking themes about technology and humanity.",
            'Thriller' => "{$title} keeps viewers on the edge of their seats with its gripping suspense, unexpected twists, and intense psychological drama that demands attention from start to finish.",
            'Fantasy' => "{$title} transports viewers to breathtaking fantastical worlds filled with magic, mythical creatures, and epic adventures that capture the imagination like no other.",
            'Crime' => "{$title} explores the dark underbelly of society through compelling crime narratives, morally complex characters, and intricate plots that keep audiences guessing.",
            'Animation' => "{$title} showcases the incredible artistry of animation with stunning visuals, compelling narratives, and characters that resonate with audiences of all ages.",
        ];
        return $templates[$category] ?? "{$title} is a critically acclaimed series that has captured the hearts of viewers worldwide with its exceptional storytelling and unforgettable characters.";
    }
}
