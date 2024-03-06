<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Wisata;
use Illuminate\Http\Request;
use App\Models\Admin\Kategori;
use App\Http\Controllers\Controller;

class WisataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wisatas = Wisata::all();
        return view('pages.admin.wisata.index', compact('wisatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('pages.admin.wisata.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'nama_wisata' => 'required',
            'lokasi_wisata' => 'required',
            'desk_wisata' => 'required',
            'gambar_wisata' => 'required',
        ]);

        Wisata::create($request->all());

        return redirect()->route('admin.wisata.index')->with('success', 'Wisata berhasil ditambahkan!');
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
        $wisata = Wisata::findOrFail($id);

        return view('pages.admin.wisata.edit', compact('wisata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_kategori' => 'required',
            'nama_wisata' => 'required',
            'lokasi_wisata' => 'required',
            'desk_wisata' => 'required',
            'gambar_wisata' => 'required',
        ]);
        $wisata = Wisata::findOrFail($id);
        $wisata->update($request->all());

        return redirect()->route('admin.wisata.index')->with('success', 'Data wisata berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wisata = Wisata::findOrFail($id);
        $wisata->delete();

        return redirect()->route('admin.wisata.index')->with('success', 'Data wisata berhasil dihapus.');
    }
}
