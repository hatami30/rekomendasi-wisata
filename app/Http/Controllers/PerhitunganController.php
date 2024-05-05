<?php

namespace App\Http\Controllers;

use App\Models\User\Rating;
use App\Models\Admin\Wisata;
use Illuminate\Http\Request;
use App\Models\User\Prediction;
use App\Models\User\Similarity;

class PerhitunganController extends Controller
{
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
    }

    public function calculateItemSimilarities($ratings)
    {
        $userRatings = Rating::selectRaw('AVG(average) as average, id_user')
            ->groupBy('id_user')
            ->pluck('average', 'id_user');

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

        // arsort($similarities);

        return $similarities;
    }

    public function calculateSimilarity($rating1, $rating2, $userRatings)
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($rating1->toArray() as $key => $value) {
            if (is_numeric($value) && is_numeric($rating2->$key)) {
                $dotProduct += ($value - $userRatings[$rating1->id_user]) * ($rating2->$key - $userRatings[$rating2->id_user]);
                $magnitude1 += pow(($value - $userRatings[$rating1->id_user]), 2);
                $magnitude2 += pow(($rating2->$key - $userRatings[$rating2->id_user]), 2);
            }
        }

        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        $similarity = $dotProduct / ($magnitude1 * $magnitude2);

        $normalizedSimilarity = ($similarity + 1) / 2;

        return $normalizedSimilarity;
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
                $prediction = 0;
                $totalSimilarity = 0;

                foreach ($userRatings as $userRating) {
                    $similarity = $similarities[$userRating->id_wisata . '_' . $wisata->id] ?? 0;
                    $prediction += $userRating->rating * $similarity;
                    $totalSimilarity += $similarity;
                }

                if ($totalSimilarity != 0) {
                    $prediction /= $totalSimilarity;
                }

                $predictions[] = [
                    'id_user' => $userId,
                    'id_wisata' => $wisata->id,
                    'predicted' => $prediction
                ];
            }
        }

        // usort($predictions, function($a, $b) {
        //     return $b['predicted'] <=> $a['predicted'];
        // });

        if (!empty($predictions)) {
            Prediction::insert($predictions);
        }
    }
}
