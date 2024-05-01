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
        $existingSimilarities = Similarity::whereIn('id_wisata1', $ratings->pluck('id_wisata'))
            ->whereIn('id_wisata2', $ratings->pluck('id_wisata'))
            ->get();

        $processedPairs = [];

        $similarities = [];

        foreach ($ratings as $rating1) {
            foreach ($ratings as $rating2) {
                if ($rating1->id != $rating2->id) {
                    $pair = [$rating1->id_wisata, $rating2->id_wisata];
                    sort($pair);
                    $pairString = join('_', $pair);

                    if (!in_array($pairString, $processedPairs)) {
                        $existing = $existingSimilarities->first(function ($item) use ($pairString) {
                            return $item->id_wisata1 == $pairString || $item->id_wisata2 == $pairString;
                        });

                        if (!$existing && !isset($similarities[$pairString])) {
                            $similarity = $this->calculateSimilarity($rating1, $rating2);
                            $similarities[$pairString] = $similarity;

                            $processedPairs[] = $pairString;
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

    public function calculateSimilarity($rating1, $rating2)
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($rating1->toArray() as $key => $value) {
            if (is_numeric($value) && is_numeric($rating2->$key)) {
                $dotProduct += $value * $rating2->$key;
                $magnitude1 += $value * $value;
                $magnitude2 += $rating2->$key * $rating2->$key;
            }
        }

        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        $cosineSimilarity = $dotProduct / ($magnitude1 * $magnitude2);

        return $cosineSimilarity;
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
                    $prediction += $similarity * $userRating->rating;
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

        if (!empty($predictions)) {
            Prediction::insert($predictions);
        }
    }
}
