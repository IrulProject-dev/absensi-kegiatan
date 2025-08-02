@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 flex-grow-1">Dashboard Presensi</h1>
        <a href="{{ route('prasence.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Buat Kegiatan Baru</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Total Kegiatan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs fw-semibold text-primary text-uppercase mb-1">Total Kegiatan</div>
                            <div class="h5 fw-bold mb-0 text-gray-800">{{ $totalKegiatan }}</div>
                            <div class="small text-muted mt-1">Sejak awal</div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-calendar-alt fa-2x text-primary-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Peserta -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs fw-semibold text-success text-uppercase mb-1">Total Peserta</div>
                            <div class="h5 fw-bold mb-0 text-gray-800">{{ $totalPeserta }}</div>
                            <div class="small text-muted mt-1">Total kehadiran</div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-users fa-2x text-success-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kegiatan Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs fw-semibold text-info text-uppercase mb-1">Kegiatan Hari Ini</div>
                            <div class="h5 fw-bold mb-0 text-gray-800">{{ $kegiatanHariIni }}</div>
                            <div class="small text-muted mt-1">{{ now()->format('d M Y') }}</div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-clipboard-list fa-2x text-info-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peserta Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs fw-semibold text-warning text-uppercase mb-1">Peserta Hari Ini</div>
                            <div class="h5 fw-bold mb-0 text-gray-800">{{ $pesertaHariIni }}</div>
                            <div class="small text-muted mt-1">{{ now()->format('d M Y') }}</div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-user-check fa-2x text-warning-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Kegiatan Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                    <h6 class="m-0 fw-bold text-primary">Kegiatan Terbaru</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-link text-muted" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('prasence.index') }}">Lihat Semua</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">Kegiatan</th>
                                    <th class="border-0">Tanggal</th>
                                    <th class="border-0 text-end">Peserta</th>
                                    <th class="border-0 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kegiatanTerbaru as $kegiatan)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $kegiatan->nama_kegiatan }}</div>
                                        <small class="text-muted">{{ $kegiatan->lokasi ?? 'Online' }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($kegiatan->tgl_kegiatan)->format('d M') }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $kegiatan->detail->count() }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('prasence.show', $kegiatan->id) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('prasence.edit', $kegiatan->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Tidak ada kegiatan terbaru</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peserta Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                    <h6 class="m-0 fw-bold text-primary">Peserta Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">Nama</th>
                                    <th class="border-0">Instansi</th>
                                    <th class="border-0">Kegiatan</th>
                                    <th class="border-0 text-end">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pesertaTerbaru as $peserta)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $peserta->name }}</div>
                                        <small class="text-muted">{{ $peserta->email }}</small>
                                    </td>
                                    <td>{{ $peserta->asal_instansi }}</td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 150px;">{{ $peserta->prasence->nama_kegiatan }}</div>
                                    </td>
                                    <td class="text-end">
                                        <small>{{ \Carbon\Carbon::parse($peserta->created_at)->format('H:i') }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Tidak ada peserta terbaru</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 fw-bold text-primary">Statistik Kehadiran Bulan Ini</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary: #4e73df;
        --primary-light: #e3ebf7;
        --success: #1cc88a;
        --success-light: #d1f3e8;
        --info: #36b9cc;
        --info-light: #d6f1f5;
        --warning: #f6c23e;
        --warning-light: #fdf3d9;
    }

    .card {
        border-radius: 0.5rem;
        border: none;
    }

    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        border-top: none;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .btn-icon-split {
        padding: 0.375rem 1rem;
        border-radius: 0.375rem;
    }

    .btn-icon-split .icon {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem;
        margin-right: 0.5rem;
        border-radius: 0.25rem;
    }

    .text-primary-light { color: var(--primary-light); }
    .text-success-light { color: var(--success-light); }
    .text-info-light { color: var(--info-light); }
    .text-warning-light { color: var(--warning-light); }

    .border-start { border-left: 1px solid #e3e6f0 !important; }

    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Configuration
    const ctx = document.getElementById('attendanceChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Jumlah Peserta',
                        data: {!! json_encode($chartData) !!},
                        borderColor: 'rgba(78, 115, 223, 1)',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        tension: 0.3,
                        fill: true,
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Jumlah Kegiatan',
                        data: {!! json_encode($chartActivitiesData) !!},
                        borderColor: 'rgba(28, 200, 138, 1)',
                        backgroundColor: 'rgba(28, 200, 138, 0.05)',
                        tension: 0.3,
                        fill: true,
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(28, 200, 138, 1)',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#6e707e',
                        bodyColor: '#858796',
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        padding: 12,
                        usePointStyle: true
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#858796'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            color: '#858796',
                            precision: 0
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
});
</script>
@endpush
