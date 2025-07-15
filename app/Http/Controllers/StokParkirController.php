<?php

namespace App\Http\Controllers;

use App\Models\StokParkir;
use Illuminate\Http\Request;

class StokParkirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StokParkir::query();

        if ($request->filled('status_pemilik')) {
            $query->where('status_pemilik', $request->status_pemilik);
        }

        if ($request->filled('jenis_kendaraan')) {
            $query->where('jenis_kendaraan', $request->jenis_kendaraan);
        }

        if ($request->filled('sort_kapasitas')) {
            $query->orderBy('kapasitas', $request->sort_kapasitas);
        }

        // Sorting default
        $query->orderBy('status_pemilik')->orderBy('jenis_kendaraan');

        $stokParkirs = $query->paginate(4)->withQueryString();

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
            'jenis_kendaraan' => 'required|in:mobil,motor,sepeda,lainnya',
            'kapasitas' => 'required|integer|min:0',
        ]);

        // Cek data yang sudah ada
        $stok = StokParkir::where('status_pemilik', $validated['status_pemilik'])
            ->where('jenis_kendaraan', $validated['jenis_kendaraan'])
            ->first();

        if ($stok) {
            // Kalau udah ada: tambahin kapasitas & sisa_slot
            $stok->kapasitas += $validated['kapasitas'];
            $stok->sisa_slot += $validated['kapasitas'];
            $stok->save();
        } else {
            // Kalau belum ada: buat baru
            $validated['sisa_slot'] = $validated['kapasitas'];
            StokParkir::create($validated);
        }

        toast('Data berhasil disimpan', 'success');
        return redirect()->route('admin.stok-parkir.index');
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
            'jenis_kendaraan' => 'in:mobil,motor,sepeda,lainnya',
            'kapasitas' => 'integer|min:0',
        ]);

        $stok = StokParkir::findOrFail($id);

        $stok->sisa_slot -= $stok->kapasitas;
        $stok->kapasitas = 0;

        $stok->kapasitas += $validated['kapasitas'] ?? 0;
        $stok->sisa_slot += $validated['kapasitas'] ?? 0;

        $stok->status_pemilik = $validated['status_pemilik'] ?? $stok->status_pemilik;
        $stok->jenis_kendaraan = $validated['jenis_kendaraan'] ?? $stok->jenis_kendaraan;

        $stok->save();

        toast('Data berhasil diubah', 'success');
        return redirect()->route('admin.stok-parkir.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stok = StokParkir::findOrFail($id);
        $stok->delete();

        toast('Data berhasil dihapus', 'success');
        return redirect()->route('admin.stok-parkir.index');
    }
}
