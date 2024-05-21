<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User\Komentar;
use App\Models\User\Image;
use App\Http\Controllers\Controller;

class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexImage()
    {
        $fotoPending = Image::where('status', 'pending')->get();
        return view('pages.admin.perizinan.image.index', compact('fotoPending'));
    }

    public function indexKomentar()
    {
        $komentars = Komentar::where('status', 'pending')->get();
        return view('pages.admin.perizinan.komentar.index', compact('komentars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
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
        $komentar = Komentar::findOrFail($id);
        return view('pages.admin.perizinan.show', compact('komentar'));
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
    public function updateKomentar(Request $request, string $id)
    {
        $komentar = Komentar::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $komentar->status = $request->status;
        $komentar->save();

        return redirect()->route('admin.perizinan.komentar.index')->with('success_komentar', 'Status komentar berhasil diperbarui.');
    }

    public function updateImage(Request $request, string $id)
    {
        $image = Image::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $image->status = $request->status;
        $image->save();

        return redirect()->route('admin.perizinan.image.index')->with('success_image', 'Status image berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approve(Request $request, $id)
    {
        // $komentar = Komentar::findOrFail($id);
        // $komentar->status = 'approved';
        // $komentar->save();

        // return redirect()->route('admin.perizinan.index')
        //     ->with('success', 'Komentar berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        // $komentar = Komentar::findOrFail($id);
        // $komentar->status = 'rejected';
        // $komentar->save();

        // return redirect()->route('admin.perizinan.index')
        //     ->with('success', 'Komentar berhasil ditolak.');
    }
}
