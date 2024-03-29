<?php

namespace App\Http\Controllers\User;

use App\Models\Admin\Wisata;
use Illuminate\Http\Request;
use App\Models\Admin\Kategori;
use App\Http\Controllers\Controller;

class RekomendasiWisataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wisatas = Wisata::paginate(12);
        return view('pages.user.rekomendasi-wisata', compact('wisatas'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function filterByCategory($slug) 
    {
        $kategori = Kategori::where('slug', $slug)->first();

        if ($kategori) {
            $wisatas = Wisata::where('id_kategori', $kategori->id)->paginate(12);
            return view('pages.user.rekomendasi-wisata', compact('wisatas'));
        } else {
            abort(404);
        }
    }
}
