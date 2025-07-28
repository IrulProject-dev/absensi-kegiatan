@extends('layouts.main')

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4 class="card-title">
                            Detail Absensi
                        </h4>
                    </div>
                    <div class="col text-end">
                        <button type="button" id="copyLinkBtn" class="btn btn-warning d-inline-flex align-items-center me-2" data-copy-url="{{ route('absen.index', $prasence->slug) }}">
                            @include('components.animated-clipboard-icon')
                            <span>Copy Link</span>
                        </button>
                        <a href="{{ route('prasence-detail.exportPDF', $prasence->id) }}"target="_blank" id="exportPdfBtn" class="btn btn-danger d-inline-flex align-items-center me-2">
                            @include('components.animated-PDF-icon')
                            <span>Expore PDF</span>
                        </a>
                        <a href="{{ route('prasence.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="150">Nama Kegiatan</td>
                        <td width="20"> : </td>
                        <td>{{ $prasence->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kegiatan</td>
                        <td> : </td>
                        <td>{{  date('d-m-Y', strtotime($prasence->tgl_kegiatan)) }}</td>
                    </tr>
                    <tr>
                        <td>Waktu Mulai</td>
                        <td> : </td>
                        <td>{{  date('H:i', strtotime($prasence->tgl_kegiatan)) }}</td>
                    </tr>
                    <tr>
                        <td>Lokasi</td>
                        <td> : </td>
                        <td>{{ $prasence->latitude }}, {{ $prasence->longitude }}</td>
                    </tr>
                </table>
                {{-- <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th width="50">No.</th>
                            <th width="120">Tanggal</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Asal Instansi</th>
                            <th with="120">Tanda Tangan</th>
                            <th width="100">Opsi</th>
                        </tr>
                    </thead>
                    @php
                        $index = 1;
                    @endphp
                        <tbody>
                            @if ($prasenceDetail->isEmpty())
                            <tr>
                                <td colspan="7" class=" text-center" colspan="5">Data Tidak Ditemukan</td>
                            </tr>
                            @endif
                            @foreach($prasenceDetail as $detail)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td class=" text-center">{{ date('d/m/Y H:i', strtotime($prasence->created_at)) }}</td>
                                <td>{{ $detail->name }}</td>
                                <td>{{ $detail->jabatan }}</td>
                                <td>{{ $detail->asal_instansi }}</td>
                                <td>
                                    @if ($detail->tanda_tangan)
                                        <img src="{{ asset('uploads/' . $detail->tanda_tangan) }}" alt="Tanda Tangan" width="100">
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('prasence-detail.destroy', $detail->id) }}"
                                        method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah kamu benar benar ingin menghapus kagiatan {{ $prasence->nama_kegiatan }}')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </table> --}}
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection


@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).on('click', '.btn-delete', function(e){
            e.preventDefault();
            let url = $(this).attr('href');
            if(confirm('Apakah kamu yakin ingin menghapus data ini')){
                $.ajax({
                    type : 'DELETE',
                    url : url,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success : function(data){
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Gagal menghapus data.');
                    }
                })
            }
        })
    </script>
@endpush
