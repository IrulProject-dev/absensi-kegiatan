@extends('layouts.main')

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4 class="card-title">
                            Daftar Kegiatan
                        </h4>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('prasence.create') }}" class="btn btn-primary">
                            Tambah Data
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <table id="datatable" class="table table-striped ">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Waktu Mulai</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    @php
                        $index = 1;
                    @endphp
                        <tbody>
                            @if ($data->isEmpty())
                            <tr>
                                <td colspan="5" class=" text-center" colspan="5">Data Tidak Ditemukan</td>
                            </tr>
                            @endif
                        @foreach($data as $prasence)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $prasence->nama_kegiatan }}</td>
                                <td>{{ date('d-m-Y',strtotime( $prasence->tgl_kegiatan)) }}</td>
                                <td>{{ date('H:i',strtotime($prasence->tgl_kegiatan)) }}</td>
                                <td>
                                    <a href="{{ route('prasence.show', $prasence->id) }}" class="btn btn-secondary mx-1">
                                        Detail
                                    </a>
                                    <a href="{{ route('prasence.edit', $prasence->id) }}" class="btn btn-warning mx-1">
                                        Edit
                                    </a>
                                    <form action="{{ route('prasence.destroy', $prasence->id) }}"
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

{{-- @push('js')
    <script>
        new DataTable('#datatable');
    </script>
@endpush --}}

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
