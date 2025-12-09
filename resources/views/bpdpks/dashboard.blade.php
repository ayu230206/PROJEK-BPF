\@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Dashboard')

@section('content')

{{-- ===================== HEADER ===================== --}}
<div class="header mb-4 d-flex justify-content-between align-items-center"
    style="
        background:linear-gradient(135deg,#4e73df,#224abe);
        padding:32px;
        border-radius:22px;
        color:white;
        position:relative;
        box-shadow:0 10px 30px rgba(0,0,0,0.22);
        overflow:hidden;
    ">

    <div style="
        position:absolute;
        right:-60px;
        top:-60px;
        width:180px;
        height:180px;
        border-radius:50%;
        background:rgba(255,255,255,0.15);
        filter:blur(40px);
    "></div>

    <div>
        <div class="fw-bolder mb-1" style="font-size:2.6rem;">👋 Welcome back,</div>

        <div class="fw-bold" style="font-size:2.6rem; color:#ffe8a3;">
            {{ Session::get('username') ?? 'bpdpks' }}
        </div>

        <div class="mt-3" style="opacity:0.9; font-size:1.15rem;">
            Your analytics dashboard • Premium Edition
        </div>
    </div>

    <div class="text-end">
        <div class="fw-semibold fs-6 opacity-75">Today:</div>
        <div class="fw-bolder fs-3">{{ date('F j, Y') }}</div>
    </div>
</div>


{{-- ===================== STAT CARDS ===================== --}}
<section id="analytics-cards" class="row g-4 mb-5">

    @php
        $cardStyle = "
            padding:26px;
            border-radius:20px;
            background:white;
            box-shadow:0 10px 28px rgba(0,0,0,0.10);
            transition:all .35s ease;
            cursor:pointer;
            border:1px solid #eee;
        ";

        $cardColors = [
            'totalRecipients'  => ['#e8f8ff', '#36b9cc', 'fas fa-users'],
            'activeCampuses'   => ['#eafaf1', '#1cc88a', 'fas fa-university'],
            'pendingApprovals' => ['#fdeaea', '#e74a3b', 'fas fa-exclamation-triangle'],
        ];
    @endphp

    {{-- TOTAL RECIPIENTS --}}
    <div class="col-md-4">
        <div class="card-custom border-start border-4"
            style="{{ $cardStyle }} border-color:{{ $cardColors['totalRecipients'][1] }}; background:{{ $cardColors['totalRecipients'][0] }};"
            onmouseover="this.style.transform='translateY(-7px)'; this.style.boxShadow='0 18px 40px rgba(0,0,0,0.18)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 28px rgba(0,0,0,0.10)'">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="text-muted small mb-2 fw-semibold">TOTAL MAHASISWA PENERIMA</div>

                    <div class="fw-bolder"
                        style="font-size:2.7rem; color:{{ $cardColors['totalRecipients'][1] }};">
                        {{ $chartData['totalRecipients'] ?? 0 }}
                    </div>
                </div>

                <div class="text-end">
                    <i class="{{ $cardColors['totalRecipients'][2] }} fa-3x"
                        style="color:{{ $cardColors['totalRecipients'][1] }}; opacity:.6;"></i>

                    <div class="small mt-2">Data Per <span class="fw-bold">Saat Ini</span></div>
                </div>

            </div>
        </div>
    </div>

    {{-- ACTIVE CAMPUSES --}}
    <div class="col-md-4">
        <div class="card-custom border-start border-4"
            style="{{ $cardStyle }} border-color:{{ $cardColors['activeCampuses'][1] }}; background:{{ $cardColors['activeCampuses'][0] }};"
            onmouseover="this.style.transform='translateY(-7px)'; this.style.boxShadow='0 18px 40px rgba(0,0,0,0.18)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 28px rgba(0,0,0,0.10)'">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="text-muted small mb-2 fw-semibold">KAMPUS AKTIF</div>

                    <div class="fw-bolder"
                        style="font-size:2.7rem; color:{{ $cardColors['activeCampuses'][1] }};">
                        {{ $chartData['activeCampuses'] ?? 0 }}
                    </div>
                </div>

                <div>
                    <i class="{{ $cardColors['activeCampuses'][2] }} fa-3x"
                        style="color:{{ $cardColors['activeCampuses'][1] }}; opacity:.6;"></i>

                    <div class="small mt-2 text-end">
                        Kerjasama <span class="fw-bold">Aktif</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- PENDING APPROVALS --}}
    <div class="col-md-4">
        <div class="card-custom border-start border-4"
            style="{{ $cardStyle }} border-color:{{ $cardColors['pendingApprovals'][1] }}; background:{{ $cardColors['pendingApprovals'][0] }};"
            onmouseover="this.style.transform='translateY(-7px)'; this.style.boxShadow='0 18px 40px rgba(0,0,0,0.18)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 28px rgba(0,0,0,0.10)'">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="text-muted small mb-2 fw-semibold">PERSETUJUAN PENDING</div>

                    <div class="fw-bolder"
                        style="font-size:2.7rem; color:{{ $cardColors['pendingApprovals'][1] }};">
                        {{ $pendingApprovals ?? 0 }}
                    </div>
                </div>

                <div>
                    <i class="{{ $cardColors['pendingApprovals'][2] }} fa-3x"
                        style="color:{{ $cardColors['pendingApprovals'][1] }}; opacity:.6;"></i>

                    <div class="small mt-2 text-end">
                        Butuh <span class="fw-bold text-danger">Tindakan</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>


---

{{-- ===================== CHART SECTION ===================== --}}
<section id="data-mahasiswa" class="row g-4 mb-5">

    <div class="col-lg-12 mb-3">
        <h2 class="fw-bolder text-dark" style="font-size:1.75rem;">
            <i class="fas fa-chart-bar me-2 text-primary"></i>
            OLAP — Rata-rata IPK per Kampus
        </h2>

        <p class="text-secondary fs-6">
            Visualisasi performa akademik mahasiswa.

            <a href="{{ route('bpdpks.datamahasiswa.index') }}"
                class="btn btn-sm btn-primary rounded-pill px-4 ms-2 shadow-sm">
                <i class="fas fa-table me-1"></i>
                Lihat Data Mahasiswa
            </a>
        </p>
    </div>


    {{-- ================= BAR CHART ================= --}}
    <div class="col-lg-8">
        <div class="p-4 shadow-lg rounded-4 bg-white"
            style="
                /* Hapus height:480px; dan ganti dengan min-height */
                min-height:480px; 
                border:1px solid #e8e8e8;
                display:flex;
                flex-direction:column;
            ">

            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <h5 class="fw-bold text-dark" id="chartTitle" style="margin:0;">
                    Average IPK — Semua Kampus
                </h5>

                <select id="filterKampusChart"
                    class="form-select form-select-sm w-auto rounded-3 shadow-sm">
                    <option value="all">Semua Kampus</option>
                    @foreach ($allKampus as $kampus)
                        <option value="{{ $kampus->id }}">{{ $kampus->nama_kampus }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tambahkan ID untuk Wrapper Canvas (Solusi C) --}}
            <div id="barChartWrapper" style="flex:1 1 auto; position:relative; height: 100%;">
                {{-- Canvas Awal --}}
                <canvas id="barChart" style="width:100%; height:100%;"></canvas>
            </div>

        </div>
    </div>



    {{-- ================= DONUT CHART ================= --}}
    <div class="col-lg-4">
        <div class="p-4 shadow-lg rounded-4 bg-white text-center"
            style="
                height:480px;
                border:1px solid #e8e8e8;
                display:flex;
                flex-direction:column;
            ">

            <h5 class="fw-bold mb-4 pb-3 text-dark border-bottom" style="margin-bottom:0;">
                IPK Distribution
            </h5>

            <div style="flex:1 1 auto; display:flex; justify-content:center; align-items:center;">
                <div style="width:70%; max-width:260px;">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>

            <div class="mt-3 small text-start mx-auto" style="max-width:240px;">
                <div class="mb-1"><span class="badge bg-primary me-2">&nbsp;</span> <strong>≥ 3.8</strong> — Excellent</div>
                <div class="mb-1"><span class="badge bg-warning me-2">&nbsp;</span> <strong>3.5–3.79</strong> — Good</div>
                <div class="mb-1"><span class="badge bg-danger me-2">&nbsp;</span> <strong>&lt; 3.5</strong> — Needs Attention</div>
            </div>

        </div>
    </div>

</section>


---

{{-- ===================== EXTRA SECTION ===================== --}}
<section class="mb-5">
    <div class="p-4 shadow-lg rounded-4 bg-white"
        style="border:1px solid #e8e8e8;">
        <h5 class="fw-bold text-primary mb-1">Informasi Tambahan Mahasiswa</h5>
        <p class="text-muted mb-0">Area untuk konten atau tabel tambahan di masa mendatang.</p>
    </div>
</section>

@endsection

---


{{-- ===================== SCRIPTS ===================== --}}
@section('scripts')
<script>

    const primaryColor = '#4e73df';
    const warningColor = '#f6c23e';
    const dangerColor  = '#e74a3b';
    const hoverColor   = '#2e59d9';

    // Pastikan data ini ada dan valid dari Controller
    const initialBarLabels    = JSON.parse('@json($chartData["barLabels"])');
    const initialBarData      = JSON.parse('@json($chartData["barData"])');
    const initialDonutData    = JSON.parse('@json($chartData["donutData"])');
    const initialDonutLabels  = JSON.parse('@json($chartData["donutLabels"])');

    let barChart, donutChart;

    function initCharts(barLabels, barData, donutData, donutLabels) {
        
        // --- BAR CHART ---
        // Solusi C: Hancurkan Chart lama dan Buat ulang elemen Canvas di DOM
        if (barChart) barChart.destroy();
        $('#barChartWrapper').html('<canvas id="barChart" style="width:100%; height:100%;"></canvas>');

        barChart = new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: "Rata-rata IPK",
                    data: barData,
                    backgroundColor: primaryColor,
                    hoverBackgroundColor: hoverColor,
                    borderRadius: 8,
                    barPercentage: 0.6,
                    categoryPercentage: 0.7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Penting agar Chart menyesuaikan wadah flex
                scales: {
                    y: { min: 3.0, max: 4.0 }
                },
                plugins: { legend: { display:false } }
            }
        });


        // --- DONUT CHART ---
        if (donutChart) donutChart.destroy();

        donutChart = new Chart(document.getElementById('donutChart'), {
            type: 'doughnut',
            data: {
                labels: donutLabels,
                datasets: [{
                    data: donutData,
                    backgroundColor: [primaryColor, warningColor, dangerColor],
                    hoverOffset: 8,
                    borderWidth: 4,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true, // Biarkan Donut Chart mempertahankan aspek rasio di wadah lebarnya
                cutout: '70%',
                plugins: { legend: { display:false } }
            }
        });
    }

    $(document).ready(() => {
        // Inisialisasi awal
        initCharts(initialBarLabels, initialBarData, initialDonutData, initialDonutLabels);

        // Event handler untuk Filter
        $('#filterKampusChart').change(function () {
            updateCharts($(this).val());
        });
    });

    function updateCharts(kampusId) {

        $('#chartTitle').text("Loading...");

        // Ganti dengan URL Route API Anda yang sebenarnya
        $.get("{{ route('bpdpks.chartdata.api') }}", { kampus_id: kampusId }, (data) => {

            const selectedName = $('#filterKampusChart option:selected').text();

            $('#chartTitle').text(`Average IPK — ${selectedName}`);
            // Mengupdate data di Stat Card, jika ID #totalRecipients memang ada.
            // Jika tidak ada di HTML, baris ini dapat dihapus.
            if ($('#totalRecipients').length) {
                 $('#totalRecipients').text(data.totalRecipients);
            }
           

            // Panggil ulang fungsi inisialisasi dengan data baru
            initCharts(data.barLabels, data.barData, data.donutData, data.donutLabels);

        }).fail(() => {
            $('#chartTitle').text("Average IPK — Error Loading Data");
        });
    }

</script>
@endsection