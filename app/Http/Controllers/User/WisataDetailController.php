<?php

namespace App\Http\Controllers\User;

use App\Models\User\Rating;
use App\Models\Admin\Wisata;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class WisataDetailController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $wisata = Wisata::findOrFail($id);
        $ratings = Rating::where('id_wisata', $id)->get();
        $averageRating = $this->calculateAverageRating($ratings);

        return view('pages.user.wisata-detail', compact('wisata', 'averageRating'));
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
}
