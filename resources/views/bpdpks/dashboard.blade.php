@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Dashboard')

@section('content')


    @php

        $LowonganAplikasiModel = '\App\Models\Bpdpks\LowonganAplikasi';

        // Default/Fallback
        $totalAplikasiMasuk = 0;

        try {

            if (class_exists($LowonganAplikasiModel)) {
                $totalAplikasiMasuk = $LowonganAplikasiModel::where('status', 'diajukan')->count();
            } else {
                // Jika kelas Model tidak ditemukan (error configuration Laravel), gunakan fallback
                $totalAplikasiMasuk = $pendingApprovals ?? 0;
            }
        } catch (\Throwable $e) {
            // Fallback jika terjadi error koneksi DB atau query
            $totalAplikasiMasuk = $pendingApprovals ?? 0;
        }

        // --- Definisi Warna & Kelas (Tidak Berubah) ---

        $cardClasses = "p-[26px] rounded-[20px] bg-white border border-[#eee] transition duration-350 ease-in-out cursor-pointer";
        $cardBoxShadow = '0 10px 28px rgba(0,0,0,0.10)';

        $cardColors = [
            'totalRecipients' => ['#e8f8ff', '#36b9cc', 'fas fa-users'],
            'activeCampuses' => ['#eafaf1', '#1cc88a', 'fas fa-university'],
            'pendingApprovals' => ['#fdeaea', '#e74a3b', 'fas fa-exclamation-triangle'],
            'totalAplikasiMasuk' => ['#fff7e8', '#f6c23e', 'fas fa-envelope-open-text'],
        ];
    @endphp

    <style>
        /* Menggunakan CSS kustom untuk pseudo-element effect pada header */
        .header-modern-effect::before {
            content: "";
            position: absolute;
            right: -60px;
            top: -60px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            filter: blur(40px);
        }
    </style>

    {{-- ===================== HEADER MODERN HIJAU (Diterjemahkan ke Tailwind) ===================== --}}
    <div class="flex justify-between items-center mb-4 p-[28px] rounded-[18px] text-white relative shadow-xl" style="
                /* Background: linear-gradient(135deg, #0b3a2e, #1f6f4b) */
                background: linear-gradient(135deg, #0b3a2e, #1f6f4b);
                /* box-shadow kustom untuk mempertahankan efek */
                box-shadow: 0 8px 22px rgba(0,0,0,0.18);
            ">

        <div class="header-modern-effect">
            <h1 class="font-bold m-0" style="font-size: 2.6rem;">
                <span>👋 Welcome back,</span>
            </h1>
            <h2 class="font-bold m-0" style="font-size: 2.6rem; color: #ffe8a3;">
                {{ Session::get('username') ?? 'bpdpks' }}
            </h2>
            <p class="opacity-90 mt-2" style="font-size: 1.15rem;">Your analytics dashboard • Premium Edition</p>
        </div>

        <div class="text-right">
            <div class="font-semibold text-base opacity-75">Today:</div>
            <div class="font-extrabold text-3xl">{{ date('F j, Y') }}</div>
        </div>
    </div>



    <section id="analytics-cards" class="row g-4 mb-5">

        @php

        @endphp

        {{-- TOTAL RECIPIENTS (DIUBAH MENJADI A TAG DENGAN ROUTE DATAMAHASISWA) --}}
        <div class="col-md-4">
            <a href="{{ route('bpdpks.datamahasiswa.index') }}"
                class="{{ $cardClasses }} border-l-4 block no-underline text-gray-800" style="
                        box-shadow: {{ $cardBoxShadow }};
                        border-color:{{ $cardColors['totalRecipients'][1] }};
                        background:{{ $cardColors['totalRecipients'][0] }};
                    "
                onmouseover="this.style.transform='translateY(-7px)'; this.style.boxShadow='0 18px 40px rgba(0,0,0,0.18)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='{{ $cardBoxShadow }}'">

                <div class="d-flex justify-content-between items-center">

                    <div>
                        <div class="text-gray-500 text-xs mb-2 font-semibold">TOTAL MAHASISWA PENERIMA</div>

                        <div class="font-extrabold"
                            style="font-size:2.7rem; color:{{ $cardColors['totalRecipients'][1] }};">
                            {{ $chartData['totalRecipients'] ?? 0 }}
                        </div>
                    </div>

                    <div class="text-right">
                        <i class="{{ $cardColors['totalRecipients'][2] }} fa-3x"
                            style="color:{{ $cardColors['totalRecipients'][1] }}; opacity:.6;"></i>

                        <div class="text-sm mt-2">Klik untuk <span class="font-bold">Lihat Data</span></div>
                    </div>

                </div>
            </a>
        </div>

        {{-- ACTIVE CAMPUSES (DIUBAH MENJADI A TAG DENGAN ROUTE KERJASAMA) --}}
        <div class="col-md-4">
            <a href="{{ route('bpdpks.kerjasama.index') }}"
                class="{{ $cardClasses }} border-l-4 block no-underline text-gray-800" style="
                        box-shadow: {{ $cardBoxShadow }};
                        border-color:{{ $cardColors['activeCampuses'][1] }};
                        background:{{ $cardColors['activeCampuses'][0] }};
                    "
                onmouseover="this.style.transform='translateY(-7px)'; this.style.boxShadow='0 18px 40px rgba(0,0,0,0.18)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='{{ $cardBoxShadow }}'">

                <div class="d-flex justify-content-between items-center">

                    <div>
                        <div class="text-gray-500 text-xs mb-2 font-semibold">KAMPUS AKTIF</div>

                        <div class="font-extrabold" style="font-size:2.7rem; color:{{ $cardColors['activeCampuses'][1] }};">
                            {{ $chartData['activeCampuses'] ?? 0 }}
                        </div>
                    </div>

                    <div class="text-right">
                        <i class="{{ $cardColors['activeCampuses'][2] }} fa-3x"
                            style="color:{{ $cardColors['activeCampuses'][1] }}; opacity:.6;"></i>

                        <div class="text-sm mt-2 text-right">
                            Klik untuk <span class="font-bold">Lihat Detail</span>
                        </div>
                    </div>

                </div>
            </a>
        </div>


        <div class="col-md-4">
            {{-- Mengubah div menjadi tag <a> dan menggunakan variabel/warna baru --}}
                <a href="{{ route('bpdpks.lowongan.index') }}"
                    class="{{ $cardClasses }} border-l-4 block no-underline text-gray-800" style="
                        box-shadow: {{ $cardBoxShadow }};
                        border-color:{{ $cardColors['totalAplikasiMasuk'][1] }};
                        background:{{ $cardColors['totalAplikasiMasuk'][0] }};
                    "
                    onmouseover="this.style.transform='translateY(-7px)'; this.style.boxShadow='0 18px 40px rgba(0,0,0,0.18)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='{{ $cardBoxShadow }}'">

                    <div class="d-flex justify-content-between items-center">

                        <div>
                            {{-- Judul diubah --}}
                            <div class="text-gray-500 text-xs mb-2 font-semibold">JUMLAH LAMARAN MASUK</div>

                            <div class="font-extrabold"
                                style="font-size:2.7rem; color:{{ $cardColors['totalAplikasiMasuk'][1] }};">
                                {{ $totalAplikasiMasuk ?? 0 }}
                            </div>
                        </div>

                        <div class="text-right">
                            {{-- Ikon diubah --}}
                            <i class="{{ $cardColors['totalAplikasiMasuk'][2] }} fa-3x"
                                style="color:{{ $cardColors['totalAplikasiMasuk'][1] }}; opacity:.6;"></i>

                            <div class="text-sm mt-2 text-right">
                                Klik untuk <span class="font-bold text-yellow-600">Lihat Detail</span>
                            </div>
                        </div>

                    </div>
                </a>
        </div>

    </section>


    <hr class="border-t border-gray-300 my-5">


    {{-- ===================== CHART SECTION (TIDAK DIUBAH) ===================== --}}
    <section id="data-mahasiswa" class="row g-4 mb-5">

        <div class="col-lg-12 mb-3">
            <h2 class="font-extrabold text-gray-800" style="font-size:1.75rem;">
                <i class="fas fa-chart-bar me-2 text-blue-600"></i>
                OLAP — Rata-rata IPK per Kampus
            </h2>

            <p class="text-gray-600 text-base">
                Visualisasi performa akademik mahasiswa.

                {{-- Tetap menggunakan Bootstrap button class --}}
                <a href="{{ route('bpdpks.datamahasiswa.index') }}"
                    class="btn btn-sm btn-primary rounded-pill px-4 ms-2 shadow-sm">
                    <i class="fas fa-table me-1"></i>
                    Lihat Data Mahasiswa
                </a>
            </p>
        </div>


        {{-- ================= BAR CHART ================= --}}
        <div class="col-lg-8">
            {{-- p-4, shadow-lg, rounded-4, bg-white -> Tailwind equivalent --}}
            <div class="p-4 shadow-xl rounded-2xl bg-white flex flex-col" style="
                        min-height:480px; 
                        border:1px solid #e8e8e8;
                    ">

                {{-- d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom -> Tailwind/Bootstrap mix
                --}}
                <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-200">
                    <h5 class="font-bold text-gray-800 m-0" id="chartTitle">
                        Average IPK — Semua Kampus
                    </h5>

                    {{-- Tetap menggunakan Bootstrap form-select class --}}
                    <select id="filterKampusChart" class="form-select form-select-sm w-auto rounded-lg shadow-sm">
                        <option value="all">Semua Kampus</option>
                        @foreach ($allKampus as $kampus)
                            <option value="{{ $kampus->id }}">{{ $kampus->nama_kampus }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- flex:1 1 auto; position:relative; height: 100%; -> Tailwind equivalent --}}
                <div id="barChartWrapper" class="flex-grow relative h-full">
                    {{-- Canvas Awal --}}
                    <canvas id="barChart" class="w-full h-full"></canvas>
                </div>

            </div>

        </div>



        {{-- ================= DONUT CHART ================= --}}
        <div class="col-lg-4">
            {{-- p-4, shadow-lg, rounded-4, bg-white, text-center -> Tailwind equivalent --}}
            <div class="p-4 shadow-xl rounded-2xl bg-white text-center flex flex-col" style="
                        height:480px;
                        border:1px solid #e8e8e8;
                    ">

                {{-- fw-bold mb-4 pb-3 text-dark border-bottom -> Tailwind/Bootstrap mix --}}
                <h5 class="font-bold mb-4 pb-3 text-gray-800 border-b border-gray-200 m-0">
                    IPK Distribution
                </h5>

                {{-- flex:1 1 auto; display:flex; justify-content:center; align-items:center; -> Tailwind equivalent --}}
                <div class="flex-grow flex justify-center items-center">
                    {{-- width:70%; max-width:260px; -> Tailwind equivalent --}}
                    <div class="w-[70%] max-w-[260px]">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>

                {{-- mt-3 small text-start mx-auto -> Tailwind/Bootstrap mix --}}
                <div class="mt-3 text-sm text-left mx-auto" style="max-width:240px;">
                    <div class="mb-1"><span class="badge bg-primary me-2">&nbsp;</span> <strong>≥ 3.8</strong> — Excellent
                    </div>
                    <div class="mb-1"><span class="badge bg-warning me-2">&nbsp;</span> <strong>3.5–3.79</strong> — Good
                    </div>
                    <div class="mb-1"><span class="badge bg-danger me-2">&nbsp;</span> <strong>&lt; 3.5</strong> — Needs
                        Attention</div>
                </div>

            </div>
        </div>

    </section>


    {{-- ===================== EXTRA SECTION (TIDAK DIUBAH) ===================== --}}
    <section class="mb-5">
        {{-- p-4, shadow-lg, rounded-4, bg-white -> Tailwind equivalent --}}
        <div class="p-4 shadow-xl rounded-2xl bg-white" style="border:1px solid #e8e8e8;">
            <h5 class="font-bold text-blue-600 mb-1">Informasi Tambahan Mahasiswa</h5>
            <p class="text-gray-500 m-0">Area untuk konten atau tabel tambahan di masa mendatang.</p>
        </div>
    </section>

@endsection

---


{{-- ===================== SCRIPTS (TIDAK DIUBAH) ===================== --}}
@section('scripts')
    <script>

        const primaryColor = '#4e73df';
        const warningColor = '#f6c23e';
        const dangerColor = '#e74a3b';
        const hoverColor = '#2e59d9';

        // Pastikan data ini ada dan valid dari Controller
        const initialBarLabels = JSON.parse('@json($chartData["barLabels"])');
        const initialBarData = JSON.parse('@json($chartData["barData"])');
        const initialDonutData = JSON.parse('@json($chartData["donutData"])');
        const initialDonutLabels = JSON.parse('@json($chartData["donutLabels"])');

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
                    plugins: { legend: { display: false } }
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
                    plugins: { legend: { display: false } }
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
                    // Catatan: Variabel $chartData['totalRecipients'] di card atas perlu diganti jika ini adalah variabel yang ingin diupdate
                    // Contoh: $('#totalRecipients').text(data.totalRecipients);
                }

                // Panggil ulang fungsi inisialisasi dengan data baru
                initCharts(data.barLabels, data.barData, data.donutData, data.donutLabels);

            }).fail(() => {
                $('#chartTitle').text("Average IPK — Error Loading Data");
            });
        }

    </script>
@endsection