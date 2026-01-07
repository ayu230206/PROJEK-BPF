<?php

namespace App\Http\Controllers\Bpdpks;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaDetail;
use App\Models\Bpdpks\Kampus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataMahasiswaController extends Controller
{
    private function getChartData(int $kampusId = null)
    {
        $queryMahasiswa = MahasiswaDetail::query();


        if ($kampusId) {
            $queryMahasiswa->where('kampus_id', $kampusId);
        }

        // 1. Data Rata-rata IPK per Kampus (untuk Bar Chart)
        $avgIpkPerKampus = (clone $queryMahasiswa)
            ->select('kampus_id', DB::raw('AVG(ipk) as avg_ipk'))
            ->groupBy('kampus_id')
            ->with('kampus:id,nama_kampus') // Load nama kampus
            ->get();

        $barLabels = $avgIpkPerKampus->map(fn($item) => $item->kampus->nama_kampus ?? 'Unknown')->toArray();
        $barData = $avgIpkPerKampus->map(fn($item) => number_format((float)$item->avg_ipk, 2, '.', ''))->toArray();

        // Data Distribusi IPK (untuk Donut Chart)
        $totalMahasiswa = (clone $queryMahasiswa)->count();
        $countExcellent = (clone $queryMahasiswa)->where('ipk', '>=', 3.80)->count();
        $countGood = (clone $queryMahasiswa)->where('ipk', '>=', 3.50)->where('ipk', '<', 3.80)->count();
        // Hitung Needs Attention dari total dikurangi Excellent dan Good
        $countAttention = $totalMahasiswa - $countExcellent - $countGood;

        $donutData = [
            'excellent' => $countExcellent,
            'good' => $countGood,
            'attention' => $countAttention,
        ];

        // Card data (hanya total recipients yang dinamis berdasarkan filter)
        $activeCampuses = Kampus::where('status_kerjasama', 'aktif')->count();

        return [
            'barLabels' => $barLabels,
            'barData' => $barData,
            'donutData' => array_values($donutData),
            'totalRecipients' => $totalMahasiswa,
            'activeCampuses' => $activeCampuses,
            'donutLabels' => ['Excellent (≥ 3.8)', 'Good (3.5 – 3.79)', 'Needs Attention (< 3.5)'],
        ];
    }


    public function dashboard()
    {
        // Ambil data untuk inisialisasi awal grafik (Semua Kampus)
        $chartData = $this->getChartData(null);

        // Ambil semua kampus untuk dropdown filter
        $allKampus = Kampus::orderBy('nama_kampus')->get();

        $pendingApprovals = 6; // Contoh data dummy

        return view('bpdpks.dashboard', compact('chartData', 'pendingApprovals', 'allKampus'));
    }

    /**
     * Endpoint API untuk mengambil data chart berdasarkan filter kampus (dipanggil via AJAX).
     */
    public function getChartDataApi(Request $request)
    {
        $kampusId = $request->input('kampus_id', null);

        // Jika ID adalah 'all' atau tidak ada, set null agar getChartData mengambil semua data
        if ($kampusId === 'all') {
            $kampusId = null;
        }

        $data = $this->getChartData($kampusId);

        return response()->json($data);
    }


    public function index(Request $request)
    {
        // Mendapatkan data untuk tabel detail
        $query = MahasiswaDetail::with(['user', 'kampus']);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', $search);
            })->orWhereHas('kampus', function ($q) use ($search) {
                // Perlu dicek apakah Kampus di-load atau Kampus sudah memiliki relasi di MahasiswaDetail
                $q->where('nama_kampus', 'like', $search);
            })->orWhere('nim', 'like', $search);
        }

        // Filter Kampus 
        if ($request->filled('kampus_id')) {
            $query->where('kampus_id', $request->kampus_id);
        }

        // Ambil data dengan pagination
        $dataMahasiswa = $query->latest()->paginate(10);

        //  semua kampus untuk filter
        $allKampus = Kampus::orderBy('nama_kampus')->get();

        return view('bpdpks.datamahasiswa.index', compact('dataMahasiswa', 'allKampus'));
    }


    public function show(MahasiswaDetail $mahasiswa)
    {

        $mahasiswa->load(['user', 'kampus']);
        return view('bpdpks.datamahasiswa.show', compact('mahasiswa'));
    }
}
