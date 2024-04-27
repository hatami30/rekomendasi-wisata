<?php

namespace App\Http\Controllers\User;

use App\Models\User\Rating;
use App\Models\Admin\Wisata;
use Illuminate\Http\Request;
use App\Models\User\Prediction;
use App\Models\User\Similarity;
use App\Http\Controllers\Controller;

class WisataDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth.user')->only('store');
    }
    public function index()
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

        $existingRating = Rating::where('id_user', auth()->id())
                                ->where('id_wisata', $request->id_wisata)
                                ->exists();

        if ($existingRating) {
            return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk wisata ini.');
        }

        $rating = new Rating();
        $rating->id_user = auth()->id();
        $rating->id_wisata = $request->id_wisata;
        $rating->harga = $request->harga;
        $rating->fasilitas = $request->fasilitas;
        $rating->keamanan = $request->keamanan;
        $rating->kenyamanan = $request->kenyamanan;
        $rating->kebersihan = $request->kebersihan;
        $rating->keindahan = $request->keindahan;
        $rating->pelayanan = $request->pelayanan;
        $rating->average = round($rating->calculateAverageRating(), 1);
        $rating->save();

        //  // Hitung similaritas dengan pengguna lain
        // $userRatings = Rating::where('id_user', auth()->id())->pluck('average', 'id_wisata')->toArray();
        // $allRatings = Rating::where('id_user', '!=', auth()->id())->get();
        // $similarities = $this->calculateSimilarities($userRatings, $allRatings);

        // // Simpan similaritas ke tabel Similarity
        // $this->saveSimilarities($similarities); 

        // // Prediksi rating untuk item-item yang belum dinilai
        // $wisata = Wisata::whereNotIn('id', array_keys($userRatings))->get();
        // $recommendations = $this->calculateRecommendations($userRatings, $similarities, $wisata);

        // // Simpan prediksi ke tabel Predictions
        // $this->savePredictions($recommendations);

        return redirect()->back()->with('success', 'Rating berhasil disimpan.');
    }

    public function saveSimilarities($similarities)
    {
        foreach ($similarities as $wisataPair => $similarity) {
            list($id_wisata1, $id_wisata2) = explode('_', $wisataPair);
            Similarity::create([
                'id_wisata1' => $id_wisata1,
                'id_wisata2' => $id_wisata2, 
                'similarity' => $similarity,
            ]);
        }
    }

    public function savePredictions($recommendations)
    {
        foreach ($recommendations as $recommendation) {
            Prediction::create([
                'id_user' => auth()->id(),
                'id_wisata' => $recommendation['wisata']->id,
                'predicted' => $recommendation['prediction'],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $wisata = Wisata::findOrFail($id);
        $ratings = Rating::where('id_wisata', $id)->get();
        $averageRating = $this->calculateAverageRating($ratings);
        $userRatings = Rating::where('id_user', auth()->id())->pluck('average', 'id_wisata')->toArray();
        $allRatings = Rating::where('id_user', '!=', auth()->id())->get();
        $similarities = $this->calculateSimilarities($userRatings, $allRatings);
        $unratedWisata = Wisata::whereNotIn('id', array_keys($userRatings))->get();
        $recommendations = $this->calculateRecommendations($userRatings, $similarities, $wisata);

        return view('pages.user.wisata-detail', compact('wisata', 'averageRating', 'recommendations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function calculateAverageRating($ratings)
    {
        $totalRating = 0;
        $numRatings = $ratings->count();

        if ($numRatings === 0) {
            return 0;
        }

        foreach ($ratings as $rating) {
            $totalRating += $rating->calculateAverageRating();
        }

        return $totalRating / $numRatings;
    }

    public function recommendItems()
    {
        // Mengambil semua rating yang diberikan oleh pengguna saat ini
        $userRatings = Rating::where('id_user', auth()->id())->pluck('average', 'id_wisata')->toArray();
        
        // Mengambil semua rating dari pengguna lain
        $allRatings = Rating::where('id_user', '!=', auth()->id())->get();
        
        // Menghitung similaritas antara rating pengguna saat ini dengan rating dari pengguna lain
        $similarities = $this->calculateSimilarities($userRatings, $allRatings);
        
        // Mengambil daftar wisata yang belum dirating oleh pengguna saat ini
        $wisata = Wisata::whereNotIn('id', array_keys($userRatings))->get();
        
        // Menghitung rekomendasi item untuk pengguna berdasarkan rating dan similaritas
        $recommendations = $this->calculateRecommendations($userRatings, $similarities, $wisata);
        
        // Tampilkan rekomendasi
        return $recommendations;
    }

    // Fungsi untuk menghitung similaritas antara rating pengguna saat ini dengan rating dari pengguna lain
    private function calculateSimilarities($userRatings, $allRatings)
    {
        $similarities = [];

        // Iterasi melalui semua rating dari pengguna lain
        foreach ($allRatings as $otherUserRating) {
            $otherUserId = $otherUserRating->id_user;
            
            // Ambil rating pengguna lain
            $otherUserRatings = Rating::where('id_user', $otherUserId)->pluck('average', 'id_wisata')->toArray();
            
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
        $n = count($commonItems);

        // Pastikan $n tidak sama dengan nol sebelum melakukan pembagian
        if ($n == 0) {
            return 0; // Atau nilai default sesuai kebutuhan Anda
        }

        // Hitung rata-rata rating
        $mean1 = array_sum($ratings1) / $n;
        $mean2 = array_sum($ratings2) / $n;

        $sumProducts = 0;
        $sumSquared1 = 0;
        $sumSquared2 = 0;

        // Iterasi melalui item yang sama
        foreach ($commonItems as $itemId => $rating1) {
            $rating2 = $ratings2[$itemId];
            
            // Hitung deviasi dari rata-rata
            $deviation1 = $rating1 - $mean1;
            $deviation2 = $rating2 - $mean2;

            // Hitung jumlah produk rating untuk korelasi Pearson
            $sumProducts += $deviation1 * $deviation2;
            $sumSquared1 += pow($deviation1, 2);
            $sumSquared2 += pow($deviation2, 2);
        }

        // Hitung korelasi Pearson
        $correlation = 0;
        if ($sumSquared1 != 0 && $sumSquared2 != 0) {
            $correlation = $sumProducts / sqrt($sumSquared1 * $sumSquared2);
        }

        return $correlation;
    }

    // Fungsi untuk menghitung rekomendasi item
    private function calculateRecommendations($userRatings, $similarities, $wisata)
    {
        $recommendations = [];

        foreach ($wisata as $item) {
            $prediction = 0;

            if (isset($similarities[auth()->id()])) {
                $prediction = $this->predictRating($userRatings, $similarities, $item->id);
            }

            $recommendations[] = [
                'wisata' => $item,
                'prediction' => $prediction,
            ];
        }

        // Urutkan rekomendasi berdasarkan prediksi rating tertinggi
        usort($recommendations, function ($a, $b) {
            return $b['prediction'] <=> $a['prediction'];
        });

        return $recommendations;
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

                // Iterasi melalui semua kategori rating
                foreach ($otherUserRatings as $category => $rating) {
                    if ($category != 'id_user' && $category != 'id_wisata') {
                        // Periksa apakah pengguna saat ini memberikan rating untuk kategori ini
                        if (isset($userRatings[$otherUserId][$category])) {
                            // Hitung jumlah bobot dan bobot terponderasi
                            $weightedSum += $similarity * ($rating - $userRatings[$otherUserId][$category]);
                            $sumOfWeights += abs($similarity);
                        }
                    }
                }
            }
        }

        // Menghindari pembagian dengan nol
        $sumOfWeights = max($sumOfWeights, 1e-9);
        
        // Menghitung prediksi rating dengan bobot terponderasi
        $userId = auth()->id();
        if (isset($userRatings[$userId])) {
            $prediction = $userRatings[$userId] + ($weightedSum / $sumOfWeights);
        } else {
            // Nilai default jika pengguna tidak memiliki rating
            $prediction = 0;
        }

        return $prediction; // Kembalikan prediksi rating
    }
}
