<?php

namespace App\Http\Controllers\User;

use App\Models\Admin\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalWisatas = Wisata::count();
        $wisatas = Wisata::join('kategoris as k', 'wisatas.id_kategori', '=', 'k.id')
            ->select(DB::raw('count(*) as jumlah, 
                case 
                    when k.slug in ("pantai", "gunung", "air-terjun", "air-panas", "danau", "penangkaran", "mangrove") then "Alam"
                    when k.slug in ("makam", "masjid") then "Religi"
                    else k.slug 
                end as kategori'))
            ->groupBy('kategori')
            ->get();

        $topWisatas = Wisata::with('rating')
            ->withAvg('rating', 'average')
            ->orderByDesc('rating_avg_average')
            ->take(5)
            ->get();

        return view('pages.user.home', compact('totalWisatas', 'wisatas', 'topWisatas'));
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
}
