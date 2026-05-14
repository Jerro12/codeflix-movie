<?php

namespace App\Services;

use App\Models\User;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Support\Facades\Cache;

class RecommendationService
{
    protected $k;

    public function __construct($k = 5)
    {
        $this->k = $k;
    }

    /**
     * Set the K parameter dynamically.
     */
    public function setK($k)
    {
        $this->k = $k;
        return $this;
    }

    /**
     * Get recommendations for a specific user using User-Based Collaborative Filtering (KNN).
     */
    public function getRecommendations(User $user, $limit = 10)
    {
        // 1. Get all ratings for the target user
        $userRatings = Rating::where('user_id', $user->id)->pluck('rating', 'movie_id')->toArray();

        if (empty($userRatings)) {
            // Fallback to top rated if no ratings found (Cold Start)
            // Filter by age category
            $allowedRatings = $this->getAllowedAgeRatings($user);
            return Movie::whereIn('age_rating', $allowedRatings)
                ->orderByDesc('rating')
                ->limit($limit)
                ->get();
        }

        // 2. Find all other users who have rated at least one movie in common
        $commonUserIds = Rating::whereIn('movie_id', array_keys($userRatings))
            ->where('user_id', '!=', $user->id)
            ->distinct()
            ->pluck('user_id');

        $similarities = [];

        // 3. Calculate similarity with each user
        foreach ($commonUserIds as $otherUserId) {
            $otherUserRatings = Rating::where('user_id', $otherUserId)->pluck('rating', 'movie_id')->toArray();
            $similarity = $this->calculateCosineSimilarity($userRatings, $otherUserRatings);
            
            if ($similarity > 0) {
                $similarities[$otherUserId] = $similarity;
            }
        }

        // 4. Sort and get Top K Neighbors
        arsort($similarities);
        $neighbors = array_slice($similarities, 0, $this->k, true);

        if (empty($neighbors)) {
            return Movie::whereNotIn('id', array_keys($userRatings))->orderByDesc('rating')->limit($limit)->get();
        }

        // 5. Predict ratings for movies the user hasn't seen and are allowed for their age
        $allowedRatings = $this->getAllowedAgeRatings($user);
        $unseenMovies = Movie::whereNotIn('id', array_keys($userRatings))
            ->whereIn('age_rating', $allowedRatings)
            ->pluck('id');
        $predictions = [];

        foreach ($unseenMovies as $movieId) {
            $score = $this->predictRating($movieId, $neighbors);
            if ($score > 0) {
                $predictions[$movieId] = $score;
            }
        }

        // 6. Return top recommended movies
        arsort($predictions);
        $recommendedMovieIds = array_keys(array_slice($predictions, 0, $limit, true));

        return Movie::whereIn('id', $recommendedMovieIds)
            ->get()
            ->sortBy(function ($movie) use ($predictions) {
                return -$predictions[$movie->id];
            })
            ->values();
    }

    /**
     * Get detailed debug information about the recommendation process.
     */
    public function getDebugInfo(User $user)
    {
        $userRatings = Rating::where('user_id', $user->id)->pluck('rating', 'movie_id')->toArray();
        
        if (empty($userRatings)) {
            return ['error' => 'User has no ratings. Please rate some movies first.'];
        }

        $commonUserIds = Rating::whereIn('movie_id', array_keys($userRatings))
            ->where('user_id', '!=', $user->id)
            ->distinct()
            ->pluck('user_id');

        $allSimilarities = [];
        foreach ($commonUserIds as $otherUserId) {
            $otherUserRatings = Rating::where('user_id', $otherUserId)->pluck('rating', 'movie_id')->toArray();
            $similarity = $this->calculateCosineSimilarity($userRatings, $otherUserRatings);
            
            $otherUser = User::find($otherUserId);
            $allSimilarities[] = [
                'user_id' => $otherUserId,
                'user_name' => $otherUser->name,
                'similarity' => $similarity,
                'common_movies_count' => count(array_intersect_key($userRatings, $otherUserRatings))
            ];
        }

        // Sort all similarities
        usort($allSimilarities, fn($a, $b) => $b['similarity'] <=> $a['similarity']);

        // Get Top K Neighbors
        $neighbors = array_slice($allSimilarities, 0, $this->k);
        $neighborIds = array_column($neighbors, 'user_id');
        $neighborWeights = array_combine($neighborIds, array_column($neighbors, 'similarity'));

        // Predict ratings for unseen movies
        $allowedRatings = $this->getAllowedAgeRatings($user);
        $unseenMovies = Movie::whereNotIn('id', array_keys($userRatings))
            ->whereIn('age_rating', $allowedRatings)
            ->latest() // Prioritaskan film terbaru agar muncul di debug
            ->limit(50) // Perbanyak candidate untuk debug
            ->get();
            
        $predictions = [];

        foreach ($unseenMovies as $movie) {
            $score = $this->predictRating($movie->id, $neighborWeights);
            // Untuk keperluan riset/debug, kita tampilkan semua meskipun skornya 0
            // agar user tahu bahwa film tersebut sedang diproses tapi tidak ada rating dari tetangga
            $predictions[] = [
                'movie_id' => $movie->id,
                'movie_title' => $movie->title,
                'predicted_rating' => $score
            ];
        }

        // Sort predictions: yang punya skor di atas, sisanya tetap urut terbaru
        usort($predictions, function($a, $b) {
            if ($a['predicted_rating'] == $b['predicted_rating']) return 0;
            return ($a['predicted_rating'] > $b['predicted_rating']) ? -1 : 1;
        });

        return [
            'target_user' => [
                'name' => $user->name,
                'ratings_count' => count($userRatings),
                'ratings' => Rating::where('user_id', $user->id)->with('movie')->get()->map(fn($r) => ['title' => $r->movie->title, 'rating' => $r->rating])
            ],
            'k_parameter' => $this->k,
            'all_similarities' => array_slice($allSimilarities, 0, 10), // Show top 10 potential neighbors
            'neighbors' => $neighbors,
            'predictions' => array_slice($predictions, 0, 10)
        ];
    }

    /**
     * Calculate Cosine Similarity between two users (as specified in the thesis).
     */
    protected function calculateCosineSimilarity($ratings1, $ratings2)
    {
        $commonMovies = array_intersect_key($ratings1, $ratings2);
        
        if (empty($commonMovies)) return 0;

        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        foreach ($commonMovies as $movieId => $ratingA) {
            $ratingB = $ratings2[$movieId];
            
            $dotProduct += ($ratingA * $ratingB);
            $normA += pow($ratingA, 2);
            $normB += pow($ratingB, 2);
        }

        $denominator = sqrt($normA) * sqrt($normB);

        if ($denominator == 0) return 0;

        return $dotProduct / $denominator;
    }

    /**
     * Predict rating for a movie based on neighbors' ratings using Weighted Average.
     */
    protected function predictRating($movieId, $neighbors)
    {
        $totalSimilarity = 0;
        $weightedSum = 0;

        foreach ($neighbors as $neighborId => $similarity) {
            $rating = Rating::where('user_id', $neighborId)->where('movie_id', $movieId)->first();
            
            if ($rating) {
                // Formula: Sum(Similarity * Rating) / Sum(Similarity)
                $weightedSum += ($rating->rating * $similarity);
                $totalSimilarity += abs($similarity);
            }
        }

        if ($totalSimilarity == 0) return 0;

        return $weightedSum / $totalSimilarity;
    }

    /**
     * Get allowed age ratings based on user category.
     */
    protected function getAllowedAgeRatings(User $user)
    {
        $category = $user->age_category ?? 'anak'; // Default to strictest if not set
        
        return match ($category) {
            'anak' => ['SU', 'Anak', 'G', 'PG'],
            'umum' => ['SU', 'Anak', '13+', 'G', 'PG', 'PG-13'],
            'dewasa' => ['SU', 'Anak', '13+', '17+', 'G', 'PG', 'PG-13', 'R', 'NC-17', '21+'],
            default => ['SU', 'Anak'],
        };
    }
}
