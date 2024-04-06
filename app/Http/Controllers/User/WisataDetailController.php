<?php

namespace App\Http\Controllers\User;

use App\Models\Admin\Wisata;
use App\Models\User\Rating;
use Illuminate\Http\Request;
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

        return redirect()->back()->with('success', 'Rating berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $wisata = Wisata::findOrFail($id);
        $ratings = Rating::where('id_wisata', (int)$id)->get();
        $averageRating = $this->calculateAverageRating($ratings);

        return view('pages.user.wisata-detail', compact('wisata', 'averageRating'));
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
}
