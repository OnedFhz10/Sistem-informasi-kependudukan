<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\Kampung;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenduduk = Penduduk::count();
        $totalKK       = KartuKeluarga::count();
        
        // Data Wilayah
        $totalDusun    = Dusun::count();
        $totalKampung  = Kampung::count(); // <-- Variabel penting
        $totalRW       = Rw::count();      
        $totalRT       = Rt::count();      

        $totalLaki     = Penduduk::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Penduduk::where('jenis_kelamin', 'P')->count();

        // Statistik Umur
        $allPenduduk = Penduduk::select('tanggal_lahir')->get();
        $kategoriUmur = ['0-5' => 0, '6-12' => 0, '13-17' => 0, '18-60' => 0, '60+' => 0];

        foreach ($allPenduduk as $p) {
            $umur = Carbon::parse($p->tanggal_lahir)->age;
            if ($umur <= 5) $kategoriUmur['0-5']++;
            elseif ($umur <= 12) $kategoriUmur['6-12']++;
            elseif ($umur <= 17) $kategoriUmur['13-17']++;
            elseif ($umur <= 60) $kategoriUmur['18-60']++;
            else $kategoriUmur['60+']++;
        }

        // Statistik Pekerjaan (String)
        $statsPekerjaan = Penduduk::select('pekerjaan', DB::raw('count(*) as total'))
                            ->whereNotNull('pekerjaan')
                            ->groupBy('pekerjaan')
                            ->orderBy('total', 'desc')
                            ->take(10)
                            ->get();

        // Statistik Pendidikan
        $statsPendidikan = Penduduk::select('pendidikan', DB::raw('count(*) as total'))
                            ->whereNotNull('pendidikan')
                            ->groupBy('pendidikan')
                            ->get();

        $pendudukTerbaru = Penduduk::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalPenduduk', 'totalKK', 
            'totalDusun', 'totalKampung', 'totalRW', 'totalRT',
            'totalLaki', 'totalPerempuan', 
            'kategoriUmur', 'statsPekerjaan', 'statsPendidikan',
            'pendudukTerbaru'
        ));
    }

    public function getDetailData(Request $request)
    {
        $kategori = $request->kategori;
        $label    = $request->label;
        $query = Penduduk::query(); 

        if ($kategori == 'gender') {
            $genderCode = ($label == 'Laki-laki') ? 'L' : 'P';
            $query->where('jenis_kelamin', $genderCode);
        } 
        elseif ($kategori == 'umur') {
            $now = Carbon::now();
            if ($label == '0-5') $query->whereBetween('tanggal_lahir', [$now->copy()->subYears(6)->addDay(), $now]);
            elseif ($label == '6-12') $query->whereBetween('tanggal_lahir', [$now->copy()->subYears(13)->addDay(), $now->copy()->subYears(6)]);
            elseif ($label == '13-17') $query->whereBetween('tanggal_lahir', [$now->copy()->subYears(18)->addDay(), $now->copy()->subYears(13)]);
            elseif ($label == '18-60') $query->whereBetween('tanggal_lahir', [$now->copy()->subYears(61)->addDay(), $now->copy()->subYears(18)]);
            elseif ($label == '60+') $query->whereDate('tanggal_lahir', '<=', $now->copy()->subYears(61));
        }
        elseif ($kategori == 'pekerjaan') {
            $query->where('pekerjaan', $label);
        }
        elseif ($kategori == 'pendidikan') {
            $query->where('pendidikan', $label);
        }

        return response()->json($query->latest()->get());
    }
}