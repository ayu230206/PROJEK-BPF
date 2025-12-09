<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MahasiswaDetail; // Pastikan model ini diimport
use App\Models\Bpdpks\Kampus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Untuk Transaction

class UserManagementController extends Controller
{
    // ... index, create, store (untuk admin/bpdpks) biarkan sama ...
    
    // --- FITUR UTAMA: LIST USER & CRUD STANDARD (Admin/BPDPKS) ---

    public function index(Request $request)
    {
        $query = User::with('detail'); // Eager load detail mahasiswa

        // Filter pencarian
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', $search)
                  ->orWhere('email', 'like', $search);
            });
        }

        // Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // ... (Kode simpan Admin/BPDPKS tetap sama seperti sebelumnya) ...
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'role'         => ['required', Rule::in(['admin', 'bpdpks'])],
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'status_aktif' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User Admin/BPDPKS berhasil ditambahkan.');
    }

    // --- FITUR KHUSUS: INPUT DATA LENGKAP MAHASISWA (GABUNGAN) ---

    public function createMahasiswa()
    {
        $kampus = Kampus::where('status_kerjasama', 'aktif')->orderBy('nama_kampus')->get();
        return view('admin.users.create_mahasiswa', compact('kampus'));
    }

    public function storeMahasiswa(Request $request)
    {
        // 1. Validasi Data Lengkap
        $request->validate([
            // Akun & Pribadi
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:20|alpha_num', // 1 kata untuk email
            'tempat_lahir' => 'required|string',
            'tanggal_lahir'=> 'required|date',
            'umur'         => 'required|integer',
            
            // Akademik
            'asal_kampus'  => 'required|exists:kampus,id',
            'program_studi'=> 'required|string',
            'nim'          => 'required|string|unique:mahasiswa_detail,nim',
            'angkatan'     => 'required|numeric',
            
            // Nilai (Opsional jika maba)
            'ipk'          => 'nullable|numeric|between:0,4.00',
            'status_ipk'   => 'nullable|string', // Baik, Cukup, Kurang
        ]);

        // Gunakan Transaction agar jika satu gagal, semua batal (Data bersih)
        DB::transaction(function () use ($request) {
            
            // A. LOGIKA GENERATE AKUN (EMAIL & PASSWORD)
            $namaPanggilan = strtolower(trim($request->nama_panggilan));
            $domain = 'mahasiswa.sawit.ac.id';
            $finalEmail = $namaPanggilan . '@' . $domain;
            
            // Handle duplikat email (tambah angka jika ada nama panggilan sama)
            $counter = 1;
            while (User::where('email', $finalEmail)->exists()) {
                $finalEmail = $namaPanggilan . $counter . '@' . $domain;
                $counter++;
            }

            // Generate Password Random
            $generatedPassword = Str::random(8); 

            // B. SIMPAN KE TABEL USERS
            $user = User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email'        => $finalEmail,
                'password'     => Hash::make($generatedPassword),
                'role'         => 'mahasiswa',
                'asal_kampus'  => $request->asal_kampus,
                'angkatan'     => $request->angkatan,
                'status_aktif' => true,
            ]);

            // C. SIMPAN KE TABEL MAHASISWA DETAIL (DATA PRIBADI & AKADEMIK)
            MahasiswaDetail::create([
                'user_id'       => $user->id,
                'nim'           => $request->nim,
                'kampus_id'     => $request->asal_kampus,
                'program_studi' => $request->program_studi,
                
                // Data Pribadi
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'umur'          => $request->umur,
                
                // Data Akademik Awal
                'ipk'           => $request->ipk,
                'status_ipk'    => $request->status_ipk, // Simpan status manual
                
                // Set default path null dulu
                'path_ktp'      => null,
                'path_kartu_mhs'=> null,
            ]);

            // Simpan credential ke session untuk ditampilkan ke Admin sekali saja
            session()->flash('credentials', [
                'name'     => $request->nama_lengkap,
                'email'    => $finalEmail,
                'password' => $generatedPassword,
                'nim'      => $request->nim
            ]);
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Data Mahasiswa & Akun berhasil dibuat sekaligus!');
    }

    // ... edit, update, destroy tetap sama ...
    public function edit(User $user)
    {
        $kampus = Kampus::orderBy('nama_kampus')->get(); 
        return view('admin.users.edit', compact('user', 'kampus'));
    }

    public function update(Request $request, User $user)
    {
        // Update user biasa...
        $user->update($request->only('nama_lengkap', 'email', 'role', 'asal_kampus'));
        // Jika perlu update data detail juga, tambahkan logika update ke MahasiswaDetail di sini
        return redirect()->route('admin.users.index')->with('success', 'User updated');
    }

    public function destroy(User $user)
    {
        $user->delete(); // Otomatis hapus MahasiswaDetail karena foreign key cascade (biasanya)
        return redirect()->route('admin.users.index')->with('success', 'User dihapus');
    }
}