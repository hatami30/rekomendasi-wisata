<?php

namespace App\Http\Controllers\User;

use App\Models\Admin\Wisata;
use App\Models\User\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerhitunganController extends Controller
{
    // Fungsi untuk merekomendasikan item kepada pengguna
    public function recommendItems(Request $request)
    {
        // Mengambil semua rating yang diberikan oleh pengguna saat ini
        $userRatings = Rating::where('id_user', auth()->id())->pluck('rating', 'id_wisata')->toArray();
        
        // Mengambil semua rating dari pengguna lain
        $allRatings = Rating::where('id_user', '!=', auth()->id())->get();
        
        // Menghitung similaritas antara rating pengguna saat ini dengan rating dari pengguna lain
        $similarities = $this->calculateSimilarities($userRatings, $allRatings);
        
        // Mengambil daftar wisata yang belum dirating oleh pengguna saat ini
        $unratedWisata = Wisata::whereNotIn('id', array_keys($userRatings))->get();
        
        // Menghitung rekomendasi item untuk pengguna berdasarkan rating dan similaritas
        $recommendations = $this->calculateRecommendations($userRatings, $similarities, $unratedWisata);
        
        // return view('pages.user.wisata', compact('recommendations')); // Kembalikan tampilan dengan rekomendasi
    }

    // Fungsi untuk menghitung similaritas antara rating pengguna saat ini dengan rating dari pengguna lain
    private function calculateSimilarities($userRatings, $allRatings)
    {
        $similarities = [];

        // Iterasi melalui semua rating dari pengguna lain
        foreach ($allRatings as $otherUserRating) {
            $otherUserId = $otherUserRating->id_user;
            
            // Ambil rating pengguna lain
            $otherUserRatings = Rating::where('id_user', $otherUserId)->pluck('rating', 'id_wisata')->toArray();
            
            // Hitung similaritas menggunakan korelasi Pearson
            $similarity = $this->pearsonCorrelation($userRatings, $otherUserRatings);
            $similarities[$otherUserId] = $similarity; // Simpan similaritas dalam array
        }

        return $similarities; // Kembalikan similaritas
    }

    // Fungsi untuk menghitung korelasi Pearson
    private function pearsonCorrelation($ratings1, $ratings2)
    {
        $commonItems = array_intersect_key($ratings1, $ratings2);
        $sumProducts = 0;
        $sumSquared1 = 0;
        $sumSquared2 = 0;

        // Iterasi melalui item yang sama
        foreach ($commonItems as $itemId => $rating1) {
            $rating2 = $ratings2[$itemId];
            
            // Hitung nilai-nilai untuk korelasi Pearson
            $sumProducts += ($rating1 * $rating2);
            $sumSquared1 += pow($rating1, 2);
            $sumSquared2 += pow($rating2, 2);
        }

        // Hitung korelasi Pearson
        $numerator = ($sumProducts - (array_sum($ratings1) * array_sum($ratings2) / count($commonItems)));
        $denominator = sqrt(($sumSquared1 - pow(array_sum($ratings1), 2) / count($ratings1)) * ($sumSquared2 - pow(array_sum($ratings2), 2) / count($ratings2)));

        if ($denominator == 0) {
            return 0; // Menghindari pembagian dengan nol
        }

        $correlation = $numerator / $denominator; // Hitung korelasi Pearson

        return $correlation; // Kembalikan korelasi Pearson
    }

    // Fungsi untuk menghitung rekomendasi item
    private function calculateRecommendations($userRatings, $similarities, $unratedWisata)
    {
        $recommendations = [];

        // Iterasi melalui wisata yang belum dirating
        foreach ($unratedWisata as $wisata) {
            $wisataId = $wisata->id;
            
            // Prediksi rating untuk wisata yang belum dirating
            $prediction = $this->predictRating($userRatings, $similarities, $wisataId);
            
            // Simpan rekomendasi dalam array
            $recommendations[] = [
                'wisata' => $wisata,
                'prediction' => $prediction,
            ];
        }

        // Urutkan rekomendasi berdasarkan prediksi rating tertinggi
        usort($recommendations, function ($a, $b) {
            return $b['prediction'] <=> $a['prediction'];
        });

        return $recommendations; // Kembalikan rekomendasi
    }

    // Fungsi untuk memprediksi rating
    private function predictRating($userRatings, $similarities, $wisataId)
    {
        $weightedSum = 0;
        $sumOfWeights = 0;

        // Iterasi melalui semua pengguna dan menghitung bobot total
        foreach ($similarities as $otherUserId => $similarity) {
            $otherUserRating = Rating::where('id_user', $otherUserId)
                ->where('id_wisata', $wisataId)
                ->first();

            if ($otherUserRating) {
                $otherUserRatings = $otherUserRating->toArray();

                foreach ($otherUserRatings as $category => $rating) {
                    if ($category != 'id_user' && $category != 'id_wisata') {
                        // Hitung jumlah bobot dan bobot terponderasi
                        $weightedSum += $similarity * ($rating - $userRatings[$otherUserId][$category]);
                        $sumOfWeights += abs($similarity);
                    }
                }
            }
        }

        // Menghindari pembagian dengan nol
        $sumOfWeights = max($sumOfWeights, 1e-9);
        
        // Menghitung prediksi rating dengan bobot terponderasi
        $prediction = $userRatings[auth()->id()][$category] + ($weightedSum / $sumOfWeights);

        return $prediction; // Kembalikan prediksi rating
    }
}
