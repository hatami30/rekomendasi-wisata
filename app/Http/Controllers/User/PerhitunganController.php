<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Rating;
use App\Models\Admin\Wisata;

class PerhitunganController extends Controller
{
    public function recommendItems(Request $request)
    {
        $userRatings = Rating::where('user_id', auth()->id())->pluck('rating', 'wisata_id')->toArray();
        $allRatings = Rating::where('user_id', '!=', auth()->id())->get();
        $similarities = $this->calculateSimilarities($userRatings, $allRatings);
        $unratedWisata = Wisata::whereNotIn('id', array_keys($userRatings))->get();
        $recommendations = $this->calculateRecommendations($userRatings, $similarities, $unratedWisata);
        
        return view('', compact('recommendations'));
    }

    private function calculateSimilarities($userRatings, $allRatings)
    {
        $similarities = [];

        foreach ($allRatings as $otherUserRating) {
            $otherUserId = $otherUserRating->user_id;
            $otherUserRatings = Rating::where('user_id', $otherUserId)->pluck('rating', 'wisata_id')->toArray();
            $similarity = $this->pearsonCorrelation($userRatings, $otherUserRatings);
            $similarities[$otherUserId] = $similarity;
        }

        return $similarities;
    }

    private function pearsonCorrelation($ratings1, $ratings2)
    {
        $commonItems = array_intersect_key($ratings1, $ratings2);
        $sumProducts = 0;
        $sumSquared1 = 0;
        $sumSquared2 = 0;

        foreach ($commonItems as $itemId => $rating1) {
            $rating2 = $ratings2[$itemId];
            $sumProducts += ($rating1 * $rating2);
            $sumSquared1 += pow($rating1, 2);
            $sumSquared2 += pow($rating2, 2);
        }

        $numerator = ($sumProducts - (array_sum($ratings1) * array_sum($ratings2) / count($commonItems)));
        $denominator = sqrt(($sumSquared1 - pow(array_sum($ratings1), 2) / count($ratings1)) * ($sumSquared2 - pow(array_sum($ratings2), 2) / count($ratings2)));

        if ($denominator == 0) {
            return 0;
        }

        $correlation = $numerator / $denominator;

        return $correlation;
    }

    private function calculateRecommendations($userRatings, $similarities, $unratedWisata)
    {
        $recommendations = [];

        foreach ($unratedWisata as $wisata) {
            $wisataId = $wisata->id;
            $prediction = $this->predictRating($userRatings, $similarities, $wisataId);
            $recommendations[] = [
                'wisata' => $wisata,
                'prediction' => $prediction,
            ];
        }

        usort($recommendations, function ($a, $b) {
            return $b['prediction'] <=> $a['prediction'];
        });

        return $recommendations;
    }

    private function predictRating($userRatings, $similarities, $wisataId)
    {
        $weightedSum = 0;
        $sumOfWeights = 0;

        foreach ($similarities as $otherUserId => $similarity) {
            $otherUserRating = Rating::where('user_id', $otherUserId)
                ->where('wisata_id', $wisataId)
                ->first();

            if ($otherUserRating) {
                $otherUserRatings = $otherUserRating->toArray();

                foreach ($otherUserRatings as $category => $rating) {
                    if ($category != 'user_id' && $category != 'wisata_id') {
                        $weightedSum += $similarity * ($rating - $userRatings[$otherUserId][$category]);
                        $sumOfWeights += abs($similarity);
                    }
                }
            }
        }

        $sumOfWeights = max($sumOfWeights, 1e-9);
        $prediction = $userRatings[auth()->id()][$category] + ($weightedSum / $sumOfWeights);

        return $prediction;
    }
}
