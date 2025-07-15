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
    public function index(Request $request)
    {
        $query = DataKendaraan::query();

        // Filter status pemilik
        if ($request->filled('status_pemilik')) {
            $query->where('status_pemilik', $request->status_pemilik);
        }

        if ($request->filled('jenis_kendaraan')) {
            $query->where('jenis_kendaraan', $request->jenis_kendaraan);
        }

        // Search by no_polisi / nama_pemilik
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('no_polisi', 'like', '%' . $request->search . '%')
                ->orWhere('nama_pemilik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Urutkan tanggal masuk
        $sort = $request->get('sort', 'desc'); // default desc
        $query->orderByRaw("
            CASE WHEN status_pemilik = 'tamu' THEN 1 ELSE 0 END,
            CASE WHEN jenis_kendaraan = 'sepeda' THEN 1 ELSE 0 END
        ")->orderBy('created_at', $sort);

        $kendaraan = $query->paginate(5)->withQueryString();

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
                'jenis_kendaraan' => 'required|string|in:motor,mobil,sepeda,lainnya',
                'nama_pemilik' => 'required|string|max:100',
                'status_pemilik' => 'required|in:dokter,suster,staff,tamu'
        ];


        // !polisi = no polisi uniq
        if ($request->jenis_kendaraan !== 'sepeda') {
            $rules['no_polisi'] = 'required|unique:data_kendaraans,no_polisi';

        }

        $messages = [
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib diisi.',
            'jenis_kendaraan.in' => 'Jenis kendaraan harus dipilih dari daftar yang tersedia.',

            'nama_pemilik.required' => 'Nama pemilik tidak boleh kosong.',
            'nama_pemilik.string' => 'Nama pemilik harus berupa teks.',
            'nama_pemilik.max' => 'Nama pemilik maksimal 100 karakter ya.',

            'status_pemilik.required' => 'Status pemilik wajib dipilih.',
            'status_pemilik.in' => 'Status pemilik harus salah satu dari: dokter, suster, staff, atau tamu.',

            'no_polisi.required' => 'Nomor polisi wajib diisi untuk kendaraan non-sepeda.',
            'no_polisi.unique' => 'Nomor polisi sudah terdaftar, coba yang lain ya.',
        ];

        $request->validate($rules, $messages);

        $kendaraan = new DataKendaraan();
        $kendaraan->status_pemilik = $request->status_pemilik;
        $kendaraan->jenis_kendaraan = $request->jenis_kendaraan;
        $kendaraan->nama_pemilik = $request->nama_pemilik;
        $kendaraan->save();

        toast('Data berhasil disimpan', 'success');
        return redirect()->route('admin.kendaraan.index');
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
        $rules = [
            'jenis_kendaraan' => 'required|string|in:motor,mobil,sepeda,lainnya',
            'nama_pemilik' => 'required|string|max:100',
            'status_pemilik' => 'required|in:dokter,suster,staff,tamu',
        ];

        if ($request->jenis_kendaraan !== 'sepeda') {
            $rules['no_polisi'] = [
                'required',
                Rule::unique('data_kendaraans', 'no_polisi')->ignore($kendaraan->id),
            ];
        }

        $messages = [
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib diisi.',
            'jenis_kendaraan.in' => 'Jenis kendaraan harus dipilih dari daftar yang tersedia.',

            'nama_pemilik.required' => 'Nama pemilik tidak boleh kosong.',
            'nama_pemilik.string' => 'Nama pemilik harus berupa teks.',
            'nama_pemilik.max' => 'Nama pemilik maksimal 100 karakter ya.',

            'status_pemilik.required' => 'Status pemilik wajib dipilih.',
            'status_pemilik.in' => 'Status pemilik harus salah satu dari: dokter, suster, staff, atau tamu.',

            'no_polisi.required' => 'Nomor polisi wajib diisi untuk kendaraan non-sepeda.',
            'no_polisi.unique' => 'Nomor polisi sudah terdaftar, coba yang lain ya.',
        ];

        $request->validate($rules, $messages);

        $kendaraan->no_polisi = $request->no_polisi;
        $kendaraan->jenis_kendaraan = $request->jenis_kendaraan;
        $kendaraan->nama_pemilik = $request->nama_pemilik;
        $kendaraan->status_pemilik = $request->status_pemilik;
        $kendaraan->save();

        toast('Data berhasil diubah', 'success');
        return redirect()->route('admin.kendaraan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kendaraan = DataKendaraan::findOrFail($id);
        $kendaraan->delete();

        toast('Data berhasil dihapus', 'success');
        return redirect()->route('admin.kendaraan.index');
    }
}
