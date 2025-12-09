@extends('admin.layout.LayoutAdmin')

@section('title', 'Input Data Mahasiswa Lengkap')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-sawit-utama text-white">
            <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Input Data Mahasiswa & Buat Akun</h5>
        </div>
        <div class="card-body bg-light">
            
            <form action="{{ route('admin.users.store_mahasiswa') }}" method="POST">
                @csrf
                
                <div class="row">
                    {{-- KOLOM KIRI: DATA PRIBADI --}}
                    <div class="col-md-6">
                        <h6 class="text-sawit-utama border-bottom pb-2 mb-3">A. Data Pribadi</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required placeholder="Contoh: Budi Santoso" value="{{ old('nama_lengkap') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" required value="{{ old('tempat_lahir') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Umur</label>
                            <input type="number" name="umur" class="form-control" required placeholder="Contoh: 20" value="{{ old('umur') }}">
                        </div>

                        {{-- DATA AKUN --}}
                        <h6 class="text-sawit-utama border-bottom pb-2 mb-3 mt-4">B. Setup Akun (Login)</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-danger">Nama Panggilan (1 Kata)</label>
                            <input type="text" name="nama_panggilan" class="form-control" required placeholder="budi" pattern="[a-zA-Z0-9]+" title="Hanya huruf dan angka, tanpa spasi" value="{{ old('nama_panggilan') }}">
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-info-circle"></i> Digunakan untuk generate email otomatis: <strong>nama@mahasiswa.sawit.ac.id</strong>
                            </small>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: DATA AKADEMIK --}}
                    <div class="col-md-6">
                        <h6 class="text-sawit-utama border-bottom pb-2 mb-3">C. Data Akademik</h6>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Asal Kampus</label>
                            <select name="asal_kampus" class="form-select" required>
                                <option value="">-- Pilih Kampus --</option>
                                @foreach($kampus as $k)
                                    <option value="{{ $k->id }}" {{ old('asal_kampus') == $k->id ? 'selected' : '' }}>{{ $k->nama_kampus }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Program Studi</label>
                            <input type="text" name="program_studi" class="form-control" required placeholder="Contoh: Agroteknologi" value="{{ old('program_studi') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">NIM</label>
                                <input type="text" name="nim" class="form-control" required placeholder="Nomor Induk Mahasiswa" value="{{ old('nim') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Angkatan</label>
                                <input type="number" name="angkatan" class="form-control" required placeholder="2024" value="{{ old('angkatan') }}">
                            </div>
                        </div>

                        <div class="card bg-white border p-3">
                            <label class="form-label fw-bold text-success">Input Nilai Awal (Opsional)</label>
                            <small class="d-block text-muted mb-2">Hanya isi jika mahasiswa sudah memiliki IPK.</small>
                            
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="small">IPK Saat Ini</label>
                                    <input type="number" step="0.01" min="0" max="4.00" name="ipk" class="form-control" placeholder="0.00" value="{{ old('ipk') }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small">Status IPK</label>
                                    <select name="status_ipk" class="form-select">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Sangat Baik" {{ old('status_ipk') == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik (> 3.5)</option>
                                        <option value="Baik" {{ old('status_ipk') == 'Baik' ? 'selected' : '' }}>Baik (3.0 - 3.5)</option>
                                        <option value="Cukup" {{ old('status_ipk') == 'Cukup' ? 'selected' : '' }}>Cukup (2.5 - 2.9)</option>
                                        <option value="Kurang" {{ old('status_ipk') == 'Kurang' ? 'selected' : '' }}>Kurang (< 2.5)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <hr class="my-4">
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-success px-4 fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Data Lengkap
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection