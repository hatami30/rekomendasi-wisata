<?php

namespace App\Http\Controllers\User;

use App\Models\User\Image;
use App\Models\User\Rating;
use App\Models\Admin\Wisata;
use Illuminate\Http\Request;
use App\Models\User\Komentar;
use App\Models\User\Prediction;

use App\Models\User\Similarity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WisataDetailController extends Controller
{
    public function show(string $id)
    {
        $wisata = Wisata::findOrFail($id);
        $ratings = Rating::where('id_wisata', $id)->get();
        $averageRating = $this->calculateAverageRating($ratings);
        $predictions = $wisata->predictions;
        $images = Image::where('id_wisata', $id)
                            ->where('status', 'approved')
                            ->get();
        $komentars = Komentar::where('id_wisata', $id)
                    ->where('status', 'approved')
                    ->get();

        return view('pages.user.wisata-detail', compact('wisata', 'averageRating', 'predictions', 'komentars', 'images'));
    }

    public function storeRating(Request $request)
    {
        $userId = Auth::id();

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

        if (!$request->has('id_wisata')) {
            return redirect()->back()->with('error', 'ID wisata tidak ditemukan dalam permintaan.');
        }

        if (!$userId) {
            return redirect()->back()->with('error', 'ID pengguna tidak valid.');
        }

        $existingRating = Rating::where('id_user', $userId)
                                ->where('id_wisata', $request->id_wisata)
                                ->exists();

        if ($existingRating) {
            return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk wisata ini.');
        }

        $rating = new Rating($request->all());
        $rating->id_user = $userId;
        $rating->average = $rating->calculateAverageRating();
        $rating->save();

        $this->calculateAndSaveRecommendations($userId);

        return redirect()->back()->with('success', 'Rating berhasil disimpan.');
    }

    public function storeImage(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'id_wisata' => 'required|exists:wisatas,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('user/wisata_photos', $imageName);

                $imageModel = new Image();
                $imageModel->id_user = $userId;
                $imageModel->id_wisata = $request->id_wisata;
                $imageModel->image_path = $imageName;
                $imageModel->status = 'pending';
                $imageModel->save();
            }
        }

        return redirect()->back()->with('success', 'Gambar berhasil diunggah dan menunggu persetujuan.');
    }

    public function storeComment(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'id_wisata' => 'required|exists:wisatas,id',
            'comment' => 'required|string',
        ]);

        if (!$request->has('id_wisata')) {
            return redirect()->back()->with('error', 'ID wisata tidak ditemukan dalam permintaan.');
        }

        if (!$userId) {
            return redirect()->back()->with('error', 'ID pengguna tidak valid.');
        }

        $komentar = new Komentar();
        $komentar->id_user = $userId;
        $komentar->id_wisata = $request->id_wisata;
        $komentar->comment = $request->comment;
        $komentar->status = 'pending';
        $komentar->save();

        return redirect()->back()->with('success', 'Komentar berhasil disimpan.');
    }

    public function calculateAndSaveRecommendations($userId)
    {
        $userRatings = Rating::where('id_user', $userId)->get();
        $allRatings = Rating::where('id_user', '!=', $userId)->get();
        $similarities = $this->calculateItemSimilarities($allRatings, $userRatings);
        $ratedWisataIds = $userRatings->pluck('id_wisata')->toArray();
        $ratedWisata = Wisata::whereIn('id', $ratedWisataIds)->get();
        $this->calculatePredictions($userId, $userRatings, $similarities, $ratedWisata);
    }

    public function calculateItemSimilarities($allRatings, $userRatings)
    {
        $similarities = [];

        foreach ($allRatings as $rating1) {
            foreach ($allRatings as $rating2) {
                if ($rating1->id !== $rating2->id) {
                    $pair = [$rating1->id_wisata, $rating2->id_wisata];
                    sort($pair);
                    $pairString = join('_', $pair);

                    if (!isset($similarities[$pairString])) {
                        $similarity = $this->calculateSimilarity($rating1, $rating2, $userRatings);
                        $similarities[$pairString] = $similarity;

                        Similarity::create([
                            'id_wisata1' => $pair[0],
                            'id_wisata2' => $pair[1],
                            'similarity' => $similarity,
                        ]);
                    }
                }
            }
        }

        return $similarities;
    }

    public function calculateSimilarity($rating1, $rating2, $userRatings)
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($userRatings[$rating1->id_user] as $wisataId => $rating) {
            if (isset($userRatings[$rating2->id_user]) && isset($userRatings[$rating2->id_user][$wisataId])) {
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

        return $dotProduct / ($magnitude1 * $magnitude2);
    }

    public function calculateAverageRating($ratings)
    {
        $sum = 0;
        $count = 0;

        foreach ($ratings as $rating) {
            $sum += $rating->average;
            $count++;
        }

        if ($count == 0) {
            return 0;
        }

        return $sum / $count;
    }

    public function calculatePredictions($userId, $userRatings, $similarities, $ratedWisata)
    {
        foreach ($ratedWisata as $wisata) {
            if (!$userRatings->contains('id_wisata', $wisata->id)) {
                $prediction = $this->predictRating($userRatings, $similarities, $userId, $wisata->id);
                Prediction::create([
                    'id_user' => $userId,
                    'id_wisata' => $wisata->id,
                    'predicted' => $prediction
                ]);
            }
        }
    }

    public function predictRating($userRatings, $similarities, $userId, $wisataId)
    {
        $weightedSum = 0;
        $sumOfWeights = 0;

        foreach ($userRatings as $rating) {
            $pair = [$rating->id_wisata, $wisataId];
            sort($pair);
            $pairString = join('_', $pair);

            if (isset($similarities[$pairString])) {
                $similarity = $similarities[$pairString];
                $weightedSum += $similarity * $rating->average;
                $sumOfWeights += $similarity;
            }
        }

        return $sumOfWeights != 0 ? $weightedSum / $sumOfWeights : 0;
    }
}
