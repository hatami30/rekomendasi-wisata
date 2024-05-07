<?php

namespace App\Http\Controllers\User;

use App\Models\User\Rating;
use App\Models\Admin\Wisata;
use Illuminate\Http\Request;
use App\Models\User\Prediction;
use App\Models\User\Similarity;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class WisataDetailController extends Controller
{
    // public function index()
    // {
    //     $userId = auth()->id();
    //     $predictedWisataIds = Prediction::where('id_user', $userId)->pluck('id_wisata')->toArray();
    //     $recommendations = Wisata::whereIn('id', $predictedWisataIds)->get();

    //     return view('pages.user.wisata-detail', compact('recommendations'));
    // }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $wisata = Wisata::findOrFail($id);
        $ratings = Rating::where('id_wisata', $id)->get();
        $averageRating = $this->calculateAverageRating($ratings);
        $predictions = Prediction::where('id_wisata', $id)->get();

        return view('pages.user.wisata-detail', compact('wisata', 'averageRating', 'predictions'));
    }

    /**
     * Calculate the average rating for a given collection of ratings.
     */
    public function calculateAverageRating(Collection $ratings)
    {
        $totalRating = $ratings->sum('average');
        $numRatings = $ratings->count();

        if ($numRatings === 0) {
            return 0;
        }

        return $totalRating / $numRatings;
    }

    public function store(Request $request)
    {
        $userId = auth()->id();

        $request->validate([
            'id_wisata' => 'required|exists:wisatas,id',
            'harga' => 'required|numeric|min:1|max:5',
            'fasilitas' => 'required|numeric|min:1|max:5',
            'keamanan' => 'required|numeric|min:1|max:5',
            'kenyamanan' => 'required|numeric|min:1|max:5',
            'kebersihan' => 'required|numeric|min:1|max:5',
            'keindahan' => 'required|numeric|min:1|max:5',
            'pelayanan' => 'required|numeric|min:1|max:5',
        ]);

        $existingRating = Rating::where('id_user', $userId)
                                ->where('id_wisata', $request->id_wisata)
                                ->exists();

        if ($existingRating) {
            return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk wisata ini.');
        }

        $rating = new Rating();
        $rating->id_user = $userId;
        $rating->id_wisata = $request->id_wisata;
        $rating->harga = $request->harga;
        $rating->fasilitas = $request->fasilitas;
        $rating->keamanan = $request->keamanan;
        $rating->kenyamanan = $request->kenyamanan;
        $rating->kebersihan = $request->kebersihan;
        $rating->keindahan = $request->keindahan;
        $rating->pelayanan = $request->pelayanan;
        $rating->average = $rating->calculateAverageRating();
        $rating->save();

        $this->calculateAndSaveRecommendations($userId);

        return redirect()->back()->with('success', 'Rating berhasil disimpan.');
    }

    public function calculateAndSaveRecommendations($userId)
    {
        $userRatings = Rating::where('id_user', $userId)->get();
        $allRatings = Rating::where('id_user', '!=', $userId)->get();
        $similarities = $this->calculateItemSimilarities($allRatings);
        $ratedWisataIds = $userRatings->pluck('id_wisata')->toArray();
        $ratedWisata = Wisata::whereIn('id', $ratedWisataIds)->get();
        $this->calculatePredictions($userId, $userRatings, $similarities, $ratedWisata);

        return redirect()->back()->with('success', 'Rekomendasi wisata berhasil diperbarui.');
    }

    public function calculateItemSimilarities($ratings)
    {
        $userRatings = [];

        foreach ($ratings as $rating) {
            $userId = $rating->id_user;

            if (!isset($userRatings[$userId])) {
                $userRatings[$userId] = [];
            }

            $userRatings[$userId][$rating->id_wisata] = $rating->average;
        }

        $similarities = [];

        foreach ($ratings as $rating1) {
            foreach ($ratings as $rating2) {
                if ($rating1->id !== $rating2->id) {
                    $pair = [$rating1->id_wisata, $rating2->id_wisata];
                    sort($pair);
                    $pairString = join('_', $pair);

                    if ($pair[0] !== $pair[1]) {
                        $existingSimilarity = Similarity::where('id_wisata1', $pair[0])
                            ->where('id_wisata2', $pair[1])
                            ->exists();

                        if (!$existingSimilarity && !isset($similarities[$pairString])) {
                            $similarity = $this->calculateSimilarity($rating1, $rating2, $userRatings);
                            $similarities[$pairString] = $similarity;
                        }
                    }
                }
            }
        }

        foreach ($similarities as $pairString => $similarity) {
            $pair = explode('_', $pairString);
            Similarity::create([
                'id_wisata1' => $pair[0],
                'id_wisata2' => $pair[1],
                'similarity' => $similarity,
            ]);
        }

        return $similarities;
    }

    public function calculateSimilarity($rating1, $rating2, $userRatings)
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($userRatings[$rating1->id_user] as $wisataId => $rating) {
            if (isset($userRatings[$rating2->id_user][$wisataId])) {
                $dotProduct += $rating * $userRatings[$rating2->id_user][$wisataId];
                $magnitude1 += pow($rating, 2);
                $magnitude2 += pow($userRatings[$rating2->id_user][$wisataId], 2);
            }
        }

        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        $similarity = $dotProduct / ($magnitude1 * $magnitude2);

        return $similarity;
    }

    public function calculateMagnitude($rating)
    {
        $magnitude = 0;
        $criteria = $this->getCriteriaNames();

        foreach ($criteria as $criterion) {
            if (isset($rating->{$criterion})) {
                $magnitude += $rating->{$criterion} * $rating->{$criterion};
            }
        }

        return sqrt($magnitude);
    }

    public function calculatePredictions($userId, $userRatings, $similarities, $ratedWisata)
    {
        $existingPredictions = Prediction::where('id_user', $userId)
            ->whereIn('id_wisata', $ratedWisata->pluck('id'))
            ->pluck('id_wisata')
            ->toArray();

        $predictions = [];

        foreach ($ratedWisata as $wisata) {
            if (!in_array($wisata->id, $existingPredictions, true)) {
                $prediction = $this->predictRating($userRatings, $similarities, $userId, $wisata->id);
                
                $predictions[] = [
                    'id_user' => $userId,
                    'id_wisata' => $wisata->id,
                    'predicted' => $prediction
                ];
            }
        }

        if (!empty($predictions)) {
            Prediction::insert($predictions);
        }
    }

    public function predictRating($userRatings, $similarities, $userId, $wisataId)
    {
        $weightedSum = 0;
        $sumOfWeights = 0;

        foreach ($similarities as $pairString => $similarity) {
            $pair = explode('_', $pairString);
            $otherWisataId = $pair[0] == $wisataId ? $pair[1] : $pair[0];

            if (isset($userRatings[$userId][$otherWisataId])) {
                $weightedSum += $similarity * $userRatings[$userId][$otherWisataId];
                $sumOfWeights += $similarity;
            }
        }

        if ($sumOfWeights != 0) {
            return $weightedSum / $sumOfWeights;
        } else {
            return 0;
        }
    }
}
