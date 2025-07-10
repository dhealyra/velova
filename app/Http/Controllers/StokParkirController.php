<?php

namespace App\Http\Controllers;

use App\Models\StokParkir;
use Illuminate\Http\Request;

class StokParkirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stokParkirs = StokParkir::orderBy('status_pemilik', 'asc')->orderBy('jenis_kendaraan', 'asc')->paginate(5);
        $tittle = 'Hapus Data';
        $text = "Apakah anda yakin?";
        confirmDelete($tittle, $text);

        return view('admin.stok-parkir.index', compact('stokParkirs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stok-parkir.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'status_pemilik' => 'required|in:tamu,staff',
            'jenis_kendaraan' => 'required|in:mobil,motor,sepeda',
            'kapasitas' => 'required|integer|min:0',
            'sisa_slot' => 'required|integer|min:0',
        ]);

        $stok = StokParkir::create($validated);
        toast('Data berhasil disimpan', 'success');
        return redirect()->route('stok-parkir.index');
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
        $stokParkir = StokParkir::findOrFail($id);
        return view('admin.stok-parkir.edit', compact('stokParkir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'status_pemilik' => 'in:tamu,staff',
            'jenis_kendaraan' => 'in:mobil,motor,sepeda',
            'kapasitas' => 'integer|min:0',
            'sisa_slot' => 'integer|min:0',
        ]);

        $stok = StokParkir::findOrFail($id);
        $stok->update($validated);

        toast('Data berhasil diubah', 'success');
        return redirect()->route('stok-parkir.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stok = StokParkir::findOrFail($id);
        $stok->delete();

        toast('Data berhasil dihapus', 'success');
        return redirect()->route('stok-parkir.index');
    }
}
