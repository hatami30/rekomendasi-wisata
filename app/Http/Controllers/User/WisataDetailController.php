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
        $predictions = Prediction::with('wisata')
            ->where('id_user', Auth::id())
            ->orderBy('predicted', 'desc')
            ->take(3)
            ->get();
        $images = Image::where('id_wisata', $id)
            ->where('status', 'approved')
            ->take(5)
            ->get();
        $komentars = Komentar::where('id_wisata', $id)
            ->where('status', 'approved')
            ->take(10)
            ->get();

        $actualRatings = Rating::where('id_user', Auth::id())->pluck('average')->toArray();
        $predictedRatings = Prediction::where('id_user', Auth::id())->pluck('predicted')->toArray();

        $mae = $this->calculateMAE($actualRatings, $predictedRatings);

        return view('pages.user.wisata-detail', compact('wisata', 'averageRating', 'predictions', 'komentars', 'images', 'mae'));
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

        $rating = new Rating();
        $rating->setData($request->all());
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
        $similarities = $this->calculateItemSimilarities($allRatings);
        $ratedWisataIds = $userRatings->pluck('id_wisata')->toArray();
        $allWisataIds = Wisata::pluck('id')->toArray();
        $unratedWisataIds = array_diff($allWisataIds, $ratedWisataIds);
        $this->calculatePredictions($userId, $userRatings, $similarities, $unratedWisataIds);
    }

    public function calculateItemSimilarities($allRatings)
    {
        $similarities = [];

        $itemRatings = [];
        foreach ($allRatings as $rating) {
            $itemRatings[$rating->id_wisata][$rating->id_user] = $rating->average;
        }

        foreach ($itemRatings as $item1 => $ratings1) {
            foreach ($itemRatings as $item2 => $ratings2) {
                if ($item1 != $item2) {
                    $pair = [$item1, $item2];
                    sort($pair);
                    $pairString = join('_', $pair);

                    if (!isset($similarities[$pairString])) {
                        $similarity = $this->calculateCosineSimilarity($ratings1, $ratings2);
                        $similarities[$pairString] = $similarity;

                        Similarity::updateOrCreate(
                            ['id_wisata1' => $pair[0], 'id_wisata2' => $pair[1]],
                            ['similarity' => $similarity]
                        );
                    }
                }
            }
        }

        return $similarities;
    }

    public function calculateCosineSimilarity($ratings1, $ratings2)
    {
        $commonUsers = array_intersect_key($ratings1, $ratings2);

        if (count($commonUsers) == 0) {
            return 0;
        }

        $numerator = 0;
        $denominator1 = 0;
        $denominator2 = 0;

        foreach ($commonUsers as $user => $rating) {
            $numerator += $ratings1[$user] * $ratings2[$user];
            $denominator1 += pow($ratings1[$user], 2);
            $denominator2 += pow($ratings2[$user], 2);
        }

        $denominator = sqrt($denominator1) * sqrt($denominator2);

        return $denominator == 0 ? 0 : $numerator / $denominator;
    }

    public function calculateAverageRating($ratings)
    {
        $sum = 0;
        $count = $ratings->count();

        foreach ($ratings as $rating) {
            $sum += $rating->average;
        }

        return $count > 0 ? $sum / $count : 0;
    }

    public function calculatePredictions($userId, $userRatings, $similarities, $unratedWisataIds)
    {
        foreach ($unratedWisataIds as $wisataId) {
            $prediction = $this->predictRating($userRatings, $similarities, $wisataId);
            Prediction::updateOrCreate(
                ['id_user' => $userId, 'id_wisata' => $wisataId],
                ['predicted' => $prediction]
            );
        }
    }

    public function predictRating($userRatings, $similarities, $wisataId)
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
                $sumOfWeights += abs($similarity);
            }
        }

        return $sumOfWeights != 0 ? $weightedSum / $sumOfWeights : 0;
    }

    public function calculateMAE($actualRatings, $predictedRatings)
    {
        $sum = 0;
        $n = count($actualRatings);

        for ($i = 0; $i < $n; $i++) {
            if ($actualRatings[$i] !== null && $predictedRatings[$i] !== null) {
                $sum += abs($actualRatings[$i] - $predictedRatings[$i]);
            }
        }

        return $n > 0 ? $sum / $n : 0;
    }
}
