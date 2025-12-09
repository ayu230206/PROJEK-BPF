@extends('admin.layout.LayoutAdmin')

@section('title', 'Monitoring Aplikasi: ' . $lowongan->judul)

@section('content')

    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-eye me-2"></i> Monitoring Aplikasi</h1>
            <p class="subtle">Aplikasi untuk **{{ $lowongan->judul }}** ({!! $lowongan->getTipeBadge() !!})</p>
        </div>
        <div class="controls">
            <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Lowongan
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card-custom mb-4">
        <h5 class="section-title">Filter Aplikasi</h5>
        <form action="{{ route('admin.lowongan.monitoring', $lowongan->id) }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="status_filter" class="form-label">Status</label>
                <select class="form-select" id="status_filter" name="status">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan (Pending)</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-8 d-flex align-items-end">
                <button type="submit" class="btn btn-info text-white me-2">Terapkan Filter</button>
                <a href="{{ route('admin.lowongan.monitoring', $lowongan->id) }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>


    <div class="card-custom">
        <h5 class="section-title">Daftar Pelamar</h5>
        <div class="table-responsive">
            <table class="table table-hover datatable" id="aplikasiTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mahasiswa (ID)</th>
                        <th>Status Aplikasi</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aplikasis as $aplikasi)
                    <tr>
                        <td>{{ $loop->iteration + ($aplikasis->perPage() * ($aplikasis->currentPage() - 1)) }}</td>
                        <td>
                            <strong>{{ $aplikasi->mahasiswa->nama_lengkap ?? 'N/A' }}</strong>
                            <br><small class="text-muted">ID: {{ $aplikasi->mahasiswa_id }}</small>
                            <br><small class="text-muted">Kampus: {{ $aplikasi->mahasiswa->asalKampus->nama_kampus ?? '-' }}</small>
                            {{-- TODO: Tambahkan link ke Detail Mahasiswa jika ada --}}
                        </td>
                        <td>
                            {!! $aplikasi->getStatusBadge() !!}
                            @if ($aplikasi->catatan_admin)
                                <br><small class="text-danger" title="Catatan Admin">{{ Str::limit($aplikasi->catatan_admin, 50) }}</small>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($aplikasi->created_at)->format('d M Y H:i') }}</td>
                        <td>
                            {{-- Tombol untuk memicu modal proses --}}
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#prosesModal" data-aplikasi-id="{{ $aplikasi->id }}" data-mahasiswa-nama="{{ $aplikasi->mahasiswa->nama_lengkap ?? 'Pelamar' }}" data-status-saat-ini="{{ $aplikasi->status }}" data-catatan-admin="{{ $aplikasi->catatan_admin }}">
                                <i class="fas fa-cogs me-1"></i> Proses
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada mahasiswa yang melamar lowongan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $aplikasis->links() }}
        </div>
    </div>

    {{-- Modal Proses Aplikasi --}}
    <div class="modal fade" id="prosesModal" tabindex="-1" aria-labelledby="prosesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formProsesAplikasi" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="prosesModalLabel">Proses Aplikasi</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan memproses aplikasi dari mahasiswa: <strong id="mahasiswaNama"></strong></p>
                        <div class="mb-3">
                            <label for="statusProses" class="form-label">Ubah Status</label>
                            <select class="form-select" id="statusProses" name="status" required>
                                <option value="diajukan">Diajukan (Pending)</option>
                                <option value="diterima">Diterima</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatanAdmin" class="form-label">Catatan Admin (Opsional)</label>
                            <textarea class="form-control" id="catatanAdmin" name="catatan_admin" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check me-1"></i> Simpan Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var prosesModal = document.getElementById('prosesModal');
        
        // Pastikan prosesModal ada sebelum menambahkan listener
        if (prosesModal) { 
            prosesModal.addEventListener('show.bs.modal', function (event) {
                // 1. Ambil data dari tombol pemicu
                var button = event.relatedTarget;
                var aplikasiId = button.getAttribute('data-aplikasi-id');
                var mahasiswaNama = button.getAttribute('data-mahasiswa-nama');
                var statusSaatIni = button.getAttribute('data-status-saat-ini');
                var catatanAdmin = button.getAttribute('data-catatan-admin');

                // 2. Ambil elemen di dalam modal
                var modalTitle = prosesModal.querySelector('#mahasiswaNama');
                var form = prosesModal.querySelector('#formProsesAplikasi');
                var statusSelect = prosesModal.querySelector('#statusProses');
                var catatanTextarea = prosesModal.querySelector('#catatanAdmin');

                // 3. Update konten modal
                modalTitle.textContent = mahasiswaNama;
                
                // PERBAIKAN KUTIP BLADE
                var baseUrl = "{{ url('admin/lowongan/aplikasi') }}"; 
                form.setAttribute('action', baseUrl + '/' + aplikasiId + '/proses');

                // 4. Set nilai form saat ini
                statusSelect.value = statusSaatIni;

                // Pastikan catatanAdmin tidak null
                catatanTextarea.value = catatanAdmin === 'null' ? '' : catatanAdmin;
            });
        }
    });
</script>
@endsection
