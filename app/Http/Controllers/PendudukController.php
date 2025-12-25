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

    // --- HALAMAN UTAMA: HANYA WARGA AKTIF ---
    public function index(Request $request)
    {
        $query = Penduduk::with(['kartuKeluarga.dusun'])
                         ->where('status', 'aktif'); // <--- KUNCI: Hanya yang Aktif

        if ($request->has('search') && $request->search != null) {
            $cari = $request->search;
            $query->where(function($q) use ($cari) {
                $q->where('nama_lengkap', 'LIKE', '%'.$cari.'%')
                  ->orWhere('nik', 'LIKE', '%'.$cari.'%');
            });
        }

        $penduduks = $query->latest()->paginate(10);
        $penduduks->appends(['search' => $request->search]); // Agar pagination jalan saat search

        $judul = 'Daftar Penduduk (Warga Aktif)';
        return view('penduduk.index', compact('penduduks', 'judul'));
    }

    // --- SUB MENU: WARGA MENINGGAL ---
    public function indexMeninggal()
    {
        $penduduks = Penduduk::with(['kartuKeluarga.dusun'])
                             ->where('status', 'meninggal')
                             ->latest()
                             ->paginate(10);
        $judul = 'Arsip Data Kematian';
        return view('penduduk.index', compact('penduduks', 'judul'));
    }

    // --- SUB MENU: WARGA PINDAH KELUAR ---
    public function indexPindah()
    {
        $penduduks = Penduduk::with(['kartuKeluarga.dusun'])
                             ->where('status', 'pindah')
                             ->latest()
                             ->paginate(10);
        $judul = 'Arsip Warga Pindah Keluar';
        return view('penduduk.index', compact('penduduks', 'judul'));
    }

    // --- SUB MENU: DATA PENDATANG (Warga Aktif yang Statusnya Pendatang) ---
    public function indexPendatang()
    {
        $penduduks = Penduduk::with(['kartuKeluarga.dusun'])
                             ->where('status', 'aktif')
                             ->where('status_dasar', 'Pendatang')
                             ->latest()
                             ->paginate(10);
        $judul = 'Data Penduduk Pendatang';
        return view('penduduk.index', compact('penduduks', 'judul'));
    }

    public function create()
    {
        $pekerjaans = $this->listPekerjaan;
        $kks = KartuKeluarga::with('dusun')->get(); // Load dusun untuk info di dropdown
        return view('penduduk.create', compact('pekerjaans', 'kks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:penduduks,nik',
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
            'agama' => 'required',
            'status_perkawinan' => 'required',
            'status_dasar' => 'required',
            // status tidak divalidasi karena otomatis
        ]);

        $data = $request->all();
        $data['status'] = 'aktif'; // <--- PAKSA JADI AKTIF OTOMATIS

        Penduduk::create($data);
        return redirect()->route('penduduk.index')->with('success', 'Warga Baru Berhasil Ditambahkan');
    }

    public function show($id)
    {
        $penduduk = Penduduk::with(['kartuKeluarga.rt', 'kartuKeluarga.rw', 'kartuKeluarga.dusun'])->findOrFail($id);
        return view('penduduk.show', compact('penduduk'));
    }

    public function edit($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $pekerjaans = $this->listPekerjaan;
        $kks = KartuKeluarga::with('dusun')->get();
        return view('penduduk.edit', compact('penduduk', 'pekerjaans', 'kks'));
    }

    public function update(Request $request, $id)
    {
        // Validasi
        $request->validate([
            // ... validasi lainnya ...
            'status' => 'required',
            'tanggal_meninggal' => 'nullable|date',
            'tanggal_pindah' => 'nullable|date',
        ]);

        $penduduk = Penduduk::findOrFail($id);
        $data = $request->all();

        // LOGIKA PEMBERSIHAN TANGGAL
        if ($request->status == 'aktif') {
            // Jika dikembalikan jadi aktif, hapus tanggal meninggal/pindah
            $data['tanggal_meninggal'] = null;
            $data['tanggal_pindah'] = null;
        } 
        elseif ($request->status == 'meninggal') {
            $data['tanggal_pindah'] = null; // Tidak mungkin pindah
            // Jika user lupa isi tanggal, otomatis isi hari ini
            if(!$request->tanggal_meninggal) $data['tanggal_meninggal'] = now();
        } 
        elseif ($request->status == 'pindah') {
            $data['tanggal_meninggal'] = null; // Tidak mungkin meninggal
            // Jika user lupa isi tanggal, otomatis isi hari ini
            if(!$request->tanggal_pindah) $data['tanggal_pindah'] = now();
        }

        $penduduk->update($data);

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
        return Excel::download(new PendudukExport, 'data-penduduk-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $penduduks = Penduduk::all(); // Bisa disesuaikan filter jika perlu
        $pdf = Pdf::loadView('penduduk.pdf', compact('penduduks'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan-penduduk-' . date('Y-m-d') . '.pdf');
    }
}