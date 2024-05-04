<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Wisata;
use App\Models\Admin\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AdminWisataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jumlahWisata = Wisata::count();
        $wisatas = Wisata::all();

        return view('pages.admin.wisata.index', compact('jumlahWisata', 'wisatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();

        return view('pages.admin.wisata.createOrUpdate', compact('kategoris'));
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
            'latitude' => 'required',
            'longitude' => 'required',
            'desk_wisata' => 'required',
            'gambar_wisata' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $gambarWisataPath = $request->file('gambar_wisata')->store('wisata_photos', 'public');

        Wisata::create([
            'id_kategori' => $request->input('id_kategori'),
            'nama_wisata' => $request->input('nama_wisata'),
            'lokasi_wisata' => $request->input('lokasi_wisata'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'desk_wisata' => $request->input('desk_wisata'),
            'gambar_wisata' => $gambarWisataPath,
        ]);

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
        $kategoris = Kategori::all();

        return view('pages.admin.wisata.createOrUpdate', compact('wisata', 'kategoris'));
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
            'latitude' => 'required',
            'longitude' => 'required',
            'desk_wisata' => 'required',
            'gambar_wisata' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $wisata = Wisata::findOrFail($id);

        $attributes = [
            'id_kategori' => $request->input('id_kategori'),
            'nama_wisata' => $request->input('nama_wisata'),
            'lokasi_wisata' => $request->input('lokasi_wisata'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'desk_wisata' => $request->input('desk_wisata'),
        ];

        if ($request->hasFile('gambar_wisata')) {
            Storage::delete('public/' . $wisata->gambar_wisata);
            $gambarWisataPath = $request->file('gambar_wisata')->store('wisata_photos', 'public');
            $attributes['gambar_wisata'] = $gambarWisataPath;
        }

        $wisata->update($attributes);

        return redirect()->route('admin.wisata.index')->with('success', 'Data wisata berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wisata = Wisata::findOrFail($id);
        Storage::delete('public/' . $wisata->gambar_wisata);
        $wisata->delete();

        return redirect()->route('admin.wisata.index')->with('success', 'Data wisata berhasil dihapus.');
    }
}
