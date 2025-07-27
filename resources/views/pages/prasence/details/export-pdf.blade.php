<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_TITLE') }}</title>
</head>
<style>
    .text-center {
        text-align: center;
    }

    .table{
        width: 100%;
        border-collapse: collapse;

    }

    .mb-2{
        margin-bottom: 20px;
    }

    .table table,
    .table th,
    .table td {
        border: 1px solid black;
        padding: 10px 4px;
    }


</style>

<body>
    <h1 class="text-center">{{ env('APP_TITLE') }}</h1>
        <div class="card-body">
                <table class="mb-2">
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
                </table>
                <table class="table ">
                    <thead>
                        <tr>
                            <th width="50">No.</th>
                            <th width="150">Tanggal</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Asal Instansi</th>
                            <th width="120">Tanda Tangan</th>
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
                                <td class=" text-center">{{ $index++ }}</td>
                                <td class=" text-center">{{ date('d/m/Y H:i', strtotime($prasence->created_at)) }}</td>
                                <td class=" text-center">{{ $detail->name }}</td>
                                <td class=" text-center">{{ $detail->jabatan }}</td>
                                <td class=" text-center">{{ $detail->asal_instansi }}</td>
                                <td class=" text-center">
                                    @php
                                        $path =  public_path('uploads/' . $detail->tanda_tangan);
                                        $type =  pathinfo($path, PATHINFO_EXTENSION);
                                        $data =  file_get_contents($path);
                                        $img  =  'data:image/' . $type . ';base64,' . base64_encode($data);
                                    @endphp
                                    <img src="{{ $img }}" style="max-width: 100%;max-height: 30px;" alt="absen">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
</body>
</html>
