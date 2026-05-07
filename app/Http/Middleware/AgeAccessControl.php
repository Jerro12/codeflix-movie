<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeAccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $movie = $request->route('movie');

        // If not logged in or no movie context, proceed
        if (!$user || !$movie) {
            return $next($request);
        }

        $userCategory = $user->age_category ?? 'anak';
        $movieRating = $movie->age_rating;

        // Simple mapping check
        $isAllowed = match ($userCategory) {
            'anak' => in_array($movieRating, ['G', 'PG', 'SU', 'Anak']),
            'umum' => in_array($movieRating, ['G', 'PG', 'PG-13', 'SU', '13+']),
            'dewasa' => true,
            default => false,
        };

        if (!$isAllowed) {
            return redirect()->route('home')->with('error', 'Film ini tidak dapat diakses sesuai kategori usia Anda.');
        }

        return $next($request);
    }
}
