@extends('layouts.main')

@section('content')
    <div class="container my-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary-blue-sky text-white border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">
                            <i class="bi bi-calendar-event me-2"></i>Daftar Kegiatan
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('prasence.create') }}" class="btn btn-light btn-sm rounded-pill">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Data
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    {{ $dataTable->table(['class' => 'table table-hover mb-0'], true) }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --primary-blue-sky: #4fc3f7;
            --primary-blue-dark: #0288d1;
        }

        .bg-primary-blue-sky {
            background: linear-gradient(135deg, var(--primary-blue-sky), var(--primary-blue-dark));
        }

        /* Table Styling */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid var(--primary-blue-sky);
            font-weight: 600;
            color: #495057;
            padding: 1rem;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(79, 195, 247, 0.05);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #f0f0f0;
        }

        /* Button Styling */
        .btn {
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 6px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Action Buttons */
        .btn-action-group {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        /* Empty State */
        .dataTables_empty {
            padding: 2rem !important;
            text-align: center !important;
            color: #6c757d;
        }

        /* Pagination Styling */
        .dataTables_paginate .paginate_button {
            border-radius: 6px !important;
            margin: 0 2px !important;
            border: 1px solid #dee2e6 !important;
        }

        .dataTables_paginate .paginate_button.current {
            background: var(--primary-blue-sky) !important;
            border-color: var(--primary-blue-sky) !important;
            color: white !important;
        }

        /* Search Box */
        .dataTables_filter input {
            border-radius: 20px;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
        }

        /* Card Styling */
        .card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            padding: 1.25rem 1.5rem;
        }
    </style>
@endpush

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).ready(function() {
            // Custom delete confirmation with SweetAlert
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let kegiatanName = $(this).data('name') || 'data ini';

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus ${kegiatanName}. Tindakan ini tidak dapat dikembalikan!`,
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
                            success: function(data) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data telah berhasil dihapus.',
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

            // Add button icons and classes to DataTables
            window.LaravelDataTables["{{ $dataTable->getTableAttribute('id') }}"].on('draw', function() {
                $('.btn-edit').prepend('<i class="bi bi-pencil-square me-1"></i>');
                $('.btn-show').prepend('<i class="bi bi-eye me-1"></i>');
                $('.btn-delete').prepend('<i class="bi bi-trash me-1"></i>');

                // Wrap action buttons
                $('td:last-child').each(function() {
                    $(this).html('<div class="btn-action-group">' + $(this).html() + '</div>');
                });
            });
        });
    </script>
@endpush
