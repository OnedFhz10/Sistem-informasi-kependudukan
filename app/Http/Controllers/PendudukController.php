<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;     
use App\Models\KartuKeluarga;
use App\Exports\PendudukExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PendudukController extends Controller
{
    private $listPekerjaan = [
        'Belum/Tidak Bekerja', 'Mengurus Rumah Tangga', 'Pelajar/Mahasiswa', 'Pensiunan',
        'Pegawai Negeri Sipil (PNS)', 'TNI', 'POLRI', 'Perdagangan', 'Petani/Pekebun', 
        'Peternak', 'Wiraswasta', 'Karyawan Swasta', 'Buruh Harian Lepas', 'Lainnya'
    ];

    public function index(Request $request)
    {
        $query = Penduduk::query(); 

        if ($request->has('search') && $request->search != null) {
            $cari = $request->search;
            $query->where(function($q) use ($cari) {
                $q->where('nama_lengkap', 'LIKE', '%'.$cari.'%')
                  ->orWhere('nik', 'LIKE', '%'.$cari.'%');
            });
        }

        $penduduks = $query->latest()->paginate(10);
        $penduduks->appends(['search' => $request->search]);

        return view('penduduk.index', compact('penduduks'));
    }

    public function create()
    {
        $pekerjaans = $this->listPekerjaan;
        $kks = KartuKeluarga::all();
        return view('penduduk.create', compact('pekerjaans', 'kks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:penduduks,nik|digits:16',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'pekerjaan' => 'required',
            'kartu_keluarga_id' => 'required',
            'status_hubungan' => 'required', 
            'pendidikan' => 'required',      
            'nama_ayah' => 'required',       
            'nama_ibu' => 'required',        
        ]);

        Penduduk::create($request->all());
        return redirect()->route('penduduk.index')->with('success', 'Data Warga Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $pekerjaans = $this->listPekerjaan;
        $kks = KartuKeluarga::all();
        return view('penduduk.edit', compact('penduduk', 'pekerjaans', 'kks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduks,nik,'.$id,
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'pekerjaan' => 'required',
            'kartu_keluarga_id' => 'required',
            'status_hubungan' => 'required',
            'pendidikan' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
        ]);

        $penduduk = Penduduk::findOrFail($id);
        $penduduk->update($request->all());
        return redirect()->route('penduduk.index')->with('success', 'Data Warga Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();
        return redirect()->route('penduduk.index')->with('success', 'Data Penduduk Berhasil Dihapus!');
    }
    public function exportExcel()
    {
        // Nama file saat didownload nanti: data-penduduk-tanggal.xlsx
        return Excel::download(new PendudukExport, 'data-penduduk-' . date('Y-m-d') . '.xlsx');
    }
    public function exportPdf()
    {
        // Ambil data penduduk (bisa ditambah logic filter jika perlu)
        $penduduks = \App\Models\Penduduk::all();

        // Load view yang tadi kita buat
        $pdf = Pdf::loadView('penduduk.pdf', compact('penduduks'));

        // Atur ukuran kertas (A4 Landscape agar tabel muat)
        $pdf->setPaper('a4', 'landscape');

        // Download file
        return $pdf->download('laporan-penduduk-' . date('Y-m-d') . '.pdf');
    }
}