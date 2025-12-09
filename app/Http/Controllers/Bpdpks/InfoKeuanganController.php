<?php

namespace App\Http\Controllers\Bpdpks;

use App\Http\Controllers\Controller;
use App\Models\Bpdpks\Keuangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Bpdpks\TransaksiDana;

class InfoKeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Start building the query
        $query = Keuangan::with([
            'mahasiswa' => function($q) {
                $q->select('id', 'nama_lengkap');
            }, 
            'mahasiswa.detail.kampus:id,nama_kampus' // PERBAIKAN: Menggunakan 'id' dari tabel kampus
        ]);

        // 1. FILTER BERDASARKAN STATUS
        if ($request->filled('status_filter')) {
            $query->where('status_pencairan', $request->status_filter);
        }

        // 2. FILTER BERDASARKAN SEMESTER
        if ($request->filled('semester_filter')) {
            $query->where('semester', 'like', '%' . $request->semester_filter . '%');
        }

        // 3. FILTER BERDASARKAN PENCARIAN MAHASISWA/NIM/KAMPUS
        if ($request->filled('search')) {
            $searchTerm = $request->search;

            $query->whereHas('mahasiswa', function ($q) use ($searchTerm) {
                // Cari di nama mahasiswa
                $q->where('nama_lengkap', 'like', '%' . $searchTerm . '%');
            })
            ->orWhereHas('mahasiswa.detail', function ($q) use ($searchTerm) {
                // Cari di NIM
                $q->where('nim', 'like', '%' . $searchTerm . '%');
            })
            ->orWhereHas('mahasiswa.detail.kampus', function ($q) use ($searchTerm) {
                // Cari di nama kampus
                $q->where('nama_kampus', 'like', '%' . $searchTerm . '%');
            });
        }

        // Jalankan query dan pagination
        $dataKeuangan = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString(); 

        return view('bpdpks.infokeuangan.index', compact('dataKeuangan'));
    }

    public function create()
    {
        $mahasiswas = User::where('role', 'mahasiswa')->select('id', 'nama_lengkap')->get(); 
        return view('bpdpks.infokeuangan.create', compact('mahasiswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'semester' => 'required|string|max:50',
            'tanggal_transfer' => 'nullable|date',
            'jumlah_bulanan' => 'required|numeric|min:0',
            'jumlah_buku' => 'nullable|numeric|min:0',
            'status_pencairan' => 'required|in:proses,ditransfer,diterima,ditangguhkan',
            'bukti_transfer' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5048',
        ]);

        $pathBukti = null;
        if ($request->hasFile('bukti_transfer')) {
            $pathBukti = $request->file('bukti_transfer')->store('keuangan/bukti_transfer', 'public');
        }

        Keuangan::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'semester' => $request->semester,
            'tanggal_transfer' => $request->tanggal_transfer,
            'jumlah_bulanan' => $request->jumlah_bulanan,
            'jumlah_buku' => $request->jumlah_buku ?? 0,
            'status_pencairan' => $request->status_pencairan,
            'keterangan' => $request->keterangan,
            'path_bukti_transfer' => $pathBukti,
            'alasan_ditangguhkan' => $request->alasan_ditangguhkan,
        ]);

        return redirect()->route('bpdpks.keuangan.index')
                         ->with('success', 'Data Keuangan baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $mahasiswas = User::where('role', 'mahasiswa')->select('id', 'nama_lengkap')->get();
        return view('bpdpks.infokeuangan.edit', compact('keuangan', 'mahasiswas'));
    }

    public function update(Request $request, $id)
    {
        $keuangan = Keuangan::findOrFail($id);
        
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'semester' => 'required|string|max:50',
            'tanggal_transfer' => 'nullable|date',
            'jumlah_bulanan' => 'required|numeric|min:0',
            'jumlah_buku' => 'nullable|numeric|min:0',
            'status_pencairan' => 'required|in:proses,ditransfer,diterima,ditangguhkan',
            'bukti_transfer' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5048',
        ]);

        $data = $request->except(['_token', '_method', 'bukti_transfer']);

        if ($request->hasFile('bukti_transfer')) {
            if ($keuangan->path_bukti_transfer) {
                Storage::disk('public')->delete($keuangan->path_bukti_transfer);
            }
            $pathBukti = $request->file('bukti_transfer')->store('keuangan/bukti_transfer', 'public');
            $data['path_bukti_transfer'] = $pathBukti;
        }

        $keuangan->update($data);

        return redirect()->route('bpdpks.keuangan.index')
                         ->with('success', 'Data Keuangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        
        if ($keuangan->path_bukti_transfer) {
            Storage::disk('public')->delete($keuangan->path_bukti_transfer);
        }

        $keuangan->delete();
        
        return redirect()->route('bpdpks.keuangan.index')
                         ->with('success', 'Data Keuangan berhasil dihapus.');
    }
}