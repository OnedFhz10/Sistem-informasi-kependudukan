@extends('layouts.app')

@section('title', 'Dashboard Statistik')
@section('header', 'Dashboard & Statistik Desa')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div
            class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 flex items-center justify-between transition hover:shadow-lg">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Total Penduduk</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalPenduduk }} <span
                        class="text-sm font-normal text-gray-400">Jiwa</span></h3>
            </div>
            <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 flex items-center justify-between transition hover:shadow-lg">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Kepala Keluarga</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalKK }} <span
                        class="text-sm font-normal text-gray-400">KK</span></h3>
            </div>
            <div class="bg-green-100 p-3 rounded-full text-green-600">
                <i class="fas fa-address-card text-2xl"></i>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500 flex items-center justify-between transition hover:shadow-lg">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Wilayah Dusun</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalDusun }} <span
                        class="text-sm font-normal text-gray-400">Dusun</span></h3>
            </div>
            <div class="bg-purple-100 p-3 rounded-full text-purple-600">
                <i class="fas fa-map-marked-alt text-2xl"></i>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500 flex items-center justify-between transition hover:shadow-lg">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Total RW</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalRW }} <span
                        class="text-sm font-normal text-gray-400">Unit</span></h3>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full text-yellow-600">
                <i class="fas fa-project-diagram text-2xl"></i>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500 flex items-center justify-between transition hover:shadow-lg">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Total RT</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalRT }} <span
                        class="text-sm font-normal text-gray-400">Unit</span></h3>
            </div>
            <div class="bg-red-100 p-3 rounded-full text-red-600">
                <i class="fas fa-network-wired text-2xl"></i>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">📊 Kelompok Umur</h3>
            <div class="relative h-64"><canvas id="umurChart"></canvas></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">⚖️ Perbandingan Gender</h3>
            <div class="relative h-64 flex justify-center"><canvas id="genderChart"></canvas></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">💼 Pekerjaan (Top 10)</h3>
            <div class="relative h-72"><canvas id="pekerjaanChart"></canvas></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">🎓 Jenjang Pendidikan</h3>
            <div class="relative h-72 flex justify-center"><canvas id="pendidikanChart"></canvas></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-12">
        <div class="bg-gray-800 px-6 py-4 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg">🆕 Penduduk Baru</h3>
            <a href="{{ route('penduduk.index') }}" class="text-blue-300 hover:text-white text-sm font-bold">Lihat Semua
                &rarr;</a>
        </div>
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">NIK</th>
                    <th class="py-3 px-6 text-center">Usia</th>
                    <th class="py-3 px-6 text-center">Pendidikan</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($pendudukTerbaru as $p)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-6 font-bold">{{ $p->nama_lengkap }}</td>
                        <td class="py-3 px-6 font-mono">{{ $p->nik }}</td>
                        <td class="py-3 px-6 text-center">{{ $p->usia }} Thn</td>
                        <td class="py-3 px-6 text-center">{{ $p->pendidikan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="detailModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Detail Data</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 font-bold text-2xl">&times;</button>
            </div>
            <div class="overflow-x-auto max-h-96">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white sticky top-0">
                        <tr>
                            <th class="py-2 px-4">NIK</th>
                            <th class="py-2 px-4">Nama</th>
                            <th class="py-2 px-4">L/P</th>
                            <th class="py-2 px-4">Pekerjaan</th>
                            <th class="py-2 px-4">Pendidikan</th>
                        </tr>
                    </thead>
                    <tbody id="modalContent" class="text-gray-700 text-sm"></tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <button onclick="closeModal()"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Tutup</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // -- MODAL --
        function openModal(title) {
            $('#modalTitle').text(title);
            $('#detailModal').removeClass('hidden');
        }

        function closeModal() {
            $('#detailModal').addClass('hidden');
            $('#modalContent').html('');
        }

        // -- HANDLE CLICK (AJAX) --
        function handleChartClick(event, elements, chart, chartType) {
            if (elements.length > 0) {
                const index = elements[0].index;
                const label = chart.data.labels[index];

                if (label) {
                    openModal('Memuat data: ' + label + '...');
                    $('#modalContent').html(
                        '<tr><td colspan="5" class="text-center py-4">Sedang memuat... <i class="fas fa-spinner fa-spin"></i></td></tr>'
                    );

                    $.ajax({
                        url: "{{ route('dashboard.detail') }}",
                        type: "GET",
                        data: {
                            kategori: chartType,
                            label: label
                        },
                        success: function(response) {
                            let rows = '';
                            if (response.length > 0) {
                                response.forEach(item => {
                                    rows += `
                                        <tr class="border-b hover:bg-gray-100">
        <td class="py-2 px-4 font-mono">${item.nik}</td>
        <td class="py-2 px-4 font-bold">${item.nama_lengkap}</td>
        <td class="py-2 px-4 text-center">${item.jenis_kelamin}</td>
        
        <td class="py-2 px-4">${item.pekerjaan ? item.pekerjaan : '-'}</td>
        
        <td class="py-2 px-4 text-center">${item.pendidikan ?? '-'}</td>
    </tr>
                                    `;
                                });
                            } else {
                                rows =
                                    '<tr><td colspan="5" class="text-center py-4 text-red-500">Tidak ada data.</td></tr>';
                            }

                            $('#modalTitle').text(`Detail: ${label} (${response.length} Orang)`);
                            $('#modalContent').html(rows);
                        },
                        error: function() {
                            $('#modalContent').html(
                                '<tr><td colspan="5" class="text-center py-4 text-red-500">Gagal.</td></tr>'
                            );
                        }
                    });
                }
            }
        }

        // --- CHART CONFIG ---

        // 1. UMUR
        new Chart(document.getElementById('umurChart'), {
            type: 'bar',
            data: {
                labels: ['0-5', '6-12', '13-17', '18-60', '60+'],
                datasets: [{
                    label: 'Warga',
                    data: [{{ $kategoriUmur['0-5'] }}, {{ $kategoriUmur['6-12'] }},
                        {{ $kategoriUmur['13-17'] }}, {{ $kategoriUmur['18-60'] }},
                        {{ $kategoriUmur['60+'] }}
                    ],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                onClick: (e, el, chart) => handleChartClick(e, el, chart, 'umur'),
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // 2. GENDER
        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $totalLaki }}, {{ $totalPerempuan }}],
                    backgroundColor: ['#3b82f6', '#ec4899']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                onClick: (e, el, chart) => handleChartClick(e, el, chart, 'gender')
            }
        });

        // 3. PEKERJAAN (Horizontal Bar)
        const jobLabels = {!! $statsPekerjaan->pluck('pekerjaan') !!};
        const jobData = {!! $statsPekerjaan->pluck('total') !!};

        new Chart(document.getElementById('pekerjaanChart'), {
            type: 'bar', // Bisa ganti 'bar' dengan indexAxis: 'y' untuk horizontal
            data: {
                labels: jobLabels,
                datasets: [{
                    label: 'Jumlah',
                    data: jobData,
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                indexAxis: 'y', // Membuat bar chart jadi horizontal
                responsive: true,
                maintainAspectRatio: false,
                onClick: (e, el, chart) => handleChartClick(e, el, chart, 'pekerjaan'),
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // 4. PENDIDIKAN (Pie Chart)
        const eduLabels = {!! $statsPendidikan->pluck('pendidikan') !!};
        const eduData = {!! $statsPendidikan->pluck('total') !!};

        // Generate warna acak untuk pendidikan
        const eduColors = eduLabels.map(() => '#' + Math.floor(Math.random() * 16777215).toString(16));

        new Chart(document.getElementById('pendidikanChart'), {
            type: 'pie',
            data: {
                labels: eduLabels,
                datasets: [{
                    data: eduData,
                    backgroundColor: eduColors
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                onClick: (e, el, chart) => handleChartClick(e, el, chart, 'pendidikan')
            }
        });
    </script>
@endsection
