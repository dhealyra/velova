<?php

namespace App\Http\Controllers;

use App\Models\KendaraanKeluar;
use App\Models\Kompensasi;
use Illuminate\Http\Request;

class KompensasiController extends Controller
{
    public function form($idKeluar)
    {
        $keluar = KendaraanKeluar::findOrFail($idKeluar);
        return view('petugas.kompensasi.form', compact('keluar'));
    }

    // Simpan kompensasi baru
    public function simpan(Request $req)
    {
        $req->validate([
            'id_kendaraan_keluar' => 'required|exists:kendaraan_keluars,id',
            'jenis_kompensasi' => 'required|string',
            'kompensasi_disetujui' => 'required|numeric|min:0',
            'nama_pemilik' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        Kompensasi::create([
            'id_kendaraan_keluar' => $req->id_kendaraan_keluar,
            'jenis_kompensasi' => $req->jenis_kompensasi,
            'tipe_kompensasi' => 0, // internal
            'kompensasi_disetujui' => $req->kompensasi_disetujui,
            'nama_pemilik' => $req->nama_pemilik,
            'keterangan' => $req->keterangan,
            'status_pengajuan' => 'pending'
        ]);

        return redirect()->route('kompensasi.index')->with('success', 'Pengajuan kompensasi terkirim!');
    }

    // Edit form
    public function edit($id)
    {
        $kompensasi = Kompensasi::findOrFail($id);
        return view('petugas.kompensasi.edit', compact('kompensasi'));
    }

    // Update kompensasi
    public function update(Request $req, $id)
    {
        $req->validate([
            'jenis_kompensasi' => 'required|string',
            'kompensasi_disetujui' => 'required|numeric|min:0',
            'nama_pemilik' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $kompensasi = Kompensasi::findOrFail($id);
        $kompensasi->update($req->all());

        return redirect()->route('kompensasi.index')->with('success', 'Kompensasi diperbarui.');
    }

    // Hapus kompensasi
    public function destroy($id)
    {
        $kompensasi = Kompensasi::findOrFail($id);
        $kompensasi->delete();

        return redirect()->route('kompensasi.index')->with('success', 'Kompensasi dihapus.');
    }

    // Admin menyetujui kompensasi
    public function setujui($id)
    {
        $kompensasi = Kompensasi::findOrFail($id);
        $kompensasi->status_pengajuan = 1; // disetujui
        $kompensasi->save();

        return redirect()->back()->with('success', 'Kompensasi disetujui!');
    }

    // Admin menolak kompensasi
    public function tolak($id)
    {
        $kompensasi = Kompensasi::findOrFail($id);
        $kompensasi->status_pengajuan = 2; // ditolak
        $kompensasi->save();

        return redirect()->back()->with('success', 'Kompensasi ditolak!');
    }
}
