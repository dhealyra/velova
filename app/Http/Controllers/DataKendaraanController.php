<?php

namespace App\Http\Controllers;

use App\Models\DataKendaraan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DataKendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kendaraan = DataKendaraan::orderByRaw("
            CASE WHEN status_pemilik = 'tamu' THEN 1 ELSE 0 END,
            CASE WHEN jenis_kendaraan = 'sepeda' THEN 1 ELSE 0 END
            ")
            ->latest()
            ->paginate(5);

        $tittle = 'Hapus Data';
        $text = "Apakah anda yakin?";
        confirmDelete($tittle, $text);

        return view('admin.kendaraan.index', compact('kendaraan'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kendaraan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'jenis_kendaraan' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:100',
            'status_pemilik' => 'required|in:dokter,suster,staff,tamu'
        ];

        // !polisi = no polisi uniq
        if ($request->jenis_kendaraan !== 'sepeda') {
            $rules['no_polisi'] = 'required|unique:data_kendaraans,no_polisi';
        }

        $request->validate($rules);

        $kendaraan = new DataKendaraan();
        $kendaraan->status_pemilik = $request->status_pemilik;
        $kendaraan->jenis_kendaraan = $request->jenis_kendaraan;
        $kendaraan->nama_pemilik = $request->nama_pemilik;
        $kendaraan->save();

        toast('Data berhasil disimpan', 'success');
        return redirect()->route('kendaraan.index');
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
        $kendaraan = DataKendaraan::findOrFail($id);
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kendaraan = DataKendaraan::findOrFail($id);
        $request->validate([
            'no_polisi' => [Rule::unique('data_kendaraans', 'no_polisi')->ignore($kendaraan->id),],
            'jenis_kendaraan' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:100',
            'status_pemilik' => 'required|in:dokter,suster,staff,tamu'
        ]);

        $kendaraan->no_polisi = $request->no_polisi;
        $kendaraan->jenis_kendaraan = $request->jenis_kendaraan;
        $kendaraan->nama_pemilik = $request->nama_pemilik;
        $kendaraan->status_pemilik = $request->status_pemilik;
        $kendaraan->save();

        toast('Data berhasil diubah', 'success');
        return redirect()->route('kendaraan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kendaraan = DataKendaraan::findOrFail($id);
        $kendaraan->delete();

        toast('Data berhasil dihapus', 'success');
        return redirect()->route('kendaraan.index');
    }
}
