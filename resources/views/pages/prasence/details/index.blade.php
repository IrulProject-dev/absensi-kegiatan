@extends('layouts.main')

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary-blue-sky border-0">
                <div class="d-flex justify-content-between  align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-card-checklist me-2"></i>Detail Absensi
                    </h4>
                    <div>
                        <button type="button" id="copyLinkBtn" class="btn btn-warning me-2 d-inline-flex align-items-center"
                                data-copy-url="{{ route('absen.index', $prasence->slug) }}">
                            @include('components.animated-clipboard-icon')
                            <span class="ms-2">Copy Link</span>
                        </button>
                        <a href="{{ route('prasence-detail.exportPDF', $prasence->id) }}" target="_blank"
                           id="exportPdfBtn" class="btn btn-danger me-2 d-inline-flex align-items-center">
                            @include('components.animated-PDF-icon')
                            <span class="ms-2">Export PDF</span>
                        </a>
                        <a href="{{ route('prasence.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-card bg-light p-4 rounded">
                            <div class="row mb-3">
                                <div class="col-4 fw-semibold">Nama Kegiatan</div>
                                <div class="col-1">:</div>
                                <div class="col-7">{{ $prasence->nama_kegiatan }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 fw-semibold">Tanggal Kegiatan</div>
                                <div class="col-1">:</div>
                                <div class="col-7">{{ date('d-m-Y', strtotime($prasence->tgl_kegiatan)) }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 fw-semibold">Waktu Mulai</div>
                                <div class="col-1">:</div>
                                <div class="col-7">{{ date('H:i', strtotime($prasence->tgl_kegiatan)) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-4 fw-semibold">Lokasi</div>
                                <div class="col-1">:</div>
                                <div class="col-7">{{ $prasence->latitude }}, {{ $prasence->longitude }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{ $dataTable->table(['class' => 'table table-hover'], true) }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 12px;
    }

    .bg-primary-blue-sky {
        background: linear-gradient(135deg, var(--primary-blue-sky), var(--primary-blue-dark));
    }

    .card-header {
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        border-radius: 12px 12px 0 0 !important;
    }

    .info-card {
        background-color: #f8fafc;
        border-left: 4px solid #4299e1;
    }

    .btn-primary {
        background-color: #4299e1;
        border: none;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background-color: #3182ce;
        transform: translateY(-1px);
    }

    .btn-outline-primary {
        border: 1px solid #4299e1;
        color: #4299e1;
        transition: all 0.2s;
    }

    .btn-outline-primary:hover {
        background-color: #4299e1;
        color: white;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #e2e8f0;
        font-weight: 600;
        color: #4a5568;
    }

    .table tbody tr:hover {
        background-color: rgba(66, 153, 225, 0.05);
    }

    .dataTables_empty {
        padding: 2rem !important;
    }
</style>
@endpush

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).ready(function() {
            // Copy Link functionality
            $('#copyLinkBtn').click(function() {
                const url = $(this).data('copy-url');
                navigator.clipboard.writeText(url).then(function() {
                    // Change button temporarily to show success
                    const btn = $('#copyLinkBtn');
                    const originalHtml = btn.html();
                    btn.html('<i class="bi bi-check-circle me-2"></i>Link Copied!');
                    btn.addClass('btn-success').removeClass('btn-primary');

                    setTimeout(function() {
                        btn.html(originalHtml);
                        btn.addClass('btn-primary').removeClass('btn-success');
                    }, 2000);
                }).catch(function() {
                    alert('Gagal menyalin link');
                });
            });

            // Delete confirmation with SweetAlert
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                ).then(() => {
                                    window.LaravelDataTables["{{ $dataTable->getTableAttribute('id') }}"].draw();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
