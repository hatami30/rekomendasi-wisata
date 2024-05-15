<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User\Komentar;
use App\Http\Controllers\Controller;

class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $komentars = Komentar::where('status', 'pending')->get();
        return view('pages.admin.perizinan.index', compact('komentars'));
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
    public function update(Request $request, string $id)
    {
        $komentar = Komentar::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $komentar->status = $request->status;
        $komentar->save();

        return redirect()->route('admin.perizinan.index')->with('success', 'Status komentar berhasil diperbarui.');
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
