@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Monitoring Aplikasi: ' . $lowongan->judul)

@section('content')


    <div
        class="flex justify-between items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-eye me-2"></i> Monitoring Aplikasi
            </h1>
            {{-- Menggunakan kelas Tailwind untuk sub-judul --}}
            <p class="text-sm opacity-85 mt-1">Aplikasi untuk **{{ $lowongan->judul }}** ({!! $lowongan->getTipeBadge() !!})
            </p>
        </div>
        <div class="controls">
            {{-- Tombol Kembali diseragamkan --}}
            <a href="{{ route('bpdpks.lowongan.index') }}" class="px-5 py-3 text-sm font-semibold rounded-xl transition duration-200 ease-in-out 
                      bg-gray-500 border border-gray-500 hover:bg-gray-600 text-white shadow-lg hover:scale-[1.02]">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Lowongan
            </a>
        </div>
    </div>


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-xl mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100 mb-6">
        <h5 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-filter me-2 text-green-700"></i>
            Filter Aplikasi</h5>
        <form action="{{ route('bpdpks.lowongan.monitoring', $lowongan->id) }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="status_filter" class="form-label font-medium text-gray-700">Status</label>
                <select class="form-select" id="status_filter" name="status">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan (Pending)
                    </option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-8 d-flex align-items-end">
                {{-- Tombol Filter diubah ke warna hijau konsisten --}}
                <button type="submit" class="btn btn-primary bg-green-600 hover:bg-green-700 text-white me-2">
                    <i class="fas fa-search me-1"></i> Terapkan Filter
                </button>
                <a href="{{ route('bpdpks.lowongan.monitoring', $lowongan->id) }}"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>



    <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100">
        <h5 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-users me-2 text-green-700"></i>
            Daftar Pelamar</h5>
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
                                <br><small class="text-muted">Kampus:
                                    {{ $aplikasi->mahasiswa->asalKampus->nama_kampus ?? '-' }}</small>
                            </td>
                            <td>
                                {!! $aplikasi->getStatusBadge() !!}
                                @if ($aplikasi->catatan_admin)
                                    <br><small class="text-danger"
                                        title="Catatan Admin">{{ Str::limit($aplikasi->catatan_admin, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($aplikasi->created_at)->format('d M Y H:i') }}</td>
                            <td>
                                {{-- Tombol Detail diubah ke warna info/biru konsisten --}}
                                <a href="{{ route('bpdpks.lowongan.aplikasi.show', $aplikasi->id) }}"
                                    class="btn btn-sm text-white bg-blue-500 hover:bg-blue-600 me-1 mb-1">
                                    <i class="fas fa-file-alt me-1"></i> Detail
                                </a>

                                {{-- Tombol Proses diubah ke warna primer hijau konsisten --}}
                                <button type="button" class="btn btn-sm text-white bg-green-600 hover:bg-green-700"
                                    data-bs-toggle="modal" data-bs-target="#prosesModal" data-aplikasi-id="{{ $aplikasi->id }}"
                                    data-mahasiswa-nama="{{ $aplikasi->mahasiswa->nama_lengkap ?? 'Pelamar' }}"
                                    data-status-saat-ini="{{ $aplikasi->status }}"
                                    data-catatan-admin="{{ $aplikasi->catatan_admin }}">
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


    <div class="modal fade" id="prosesModal" tabindex="-1" aria-labelledby="prosesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formProsesAplikasi" method="POST">
                    @csrf
                    <div class="modal-header bg-green-700 text-white">
                        <h5 class="modal-title" id="prosesModalLabel">Proses Aplikasi</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan memproses aplikasi dari mahasiswa: <strong id="mahasiswaNama"></strong></p>
                        <div class="mb-3">
                            <label for="statusProses" class="form-label font-medium text-gray-700">Ubah Status</label>
                            <select class="form-select" id="statusProses" name="status" required>
                                <option value="diajukan">Diajukan (Pending)</option>
                                <option value="diterima">Diterima</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatanAdmin" class="form-label font-medium text-gray-700">Catatan Admin
                                (Opsional)</label>
                            <textarea class="form-control" id="catatanAdmin" name="catatan_admin" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white"
                            data-bs-dismiss="modal">Batal</button>
                        {{-- Tombol Simpan diubah ke warna hijau konsisten --}}
                        <button type="submit"
                            class="btn btn-primary bg-green-600 hover:bg-green-700 border-green-600 text-white"><i
                                class="fas fa-check me-1"></i> Simpan Status</button>
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
            if (!prosesModal) return;

            prosesModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var aplikasiId = button.getAttribute('data-aplikasi-id');
                var mahasiswaNama = button.getAttribute('data-mahasiswa-nama');
                var statusSaatIni = button.getAttribute('data-status-saat-ini');
                var catatanAdmin = button.getAttribute('data-catatan-admin');

                document.getElementById('mahasiswaNama').textContent = mahasiswaNama;

                var baseUrl = "{{ url('bpdpks/lowongan/aplikasi') }}";
                document.getElementById('formProsesAplikasi')
                    .setAttribute('action', baseUrl + '/' + aplikasiId + '/proses');

                document.getElementById('statusProses').value = statusSaatIni;
                document.getElementById('catatanAdmin').value = catatanAdmin === 'null' ? '' : catatanAdmin;
            });
        });
    </script>
@endsection