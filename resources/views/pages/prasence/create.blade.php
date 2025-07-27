@extends('layouts.main')

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4 class="card-title">
                            Tambah Kegiatan
                        </h4>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('prasence.index') }}" class="btn btn-primary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('prasence.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kegiatan">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control mt-3" id="nama_kegiatan" value="{{ old('nana_kegiatan') }}">
                        @error('nama_kegiatan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tgl_kegiatan">tgl Kegiatan</label>
                        <input type="date" name="tgl_kegiatan" class="form-control mt-3" id="tgl_kegiatan" value="{{ old('tgl_kegiatan') }}">
                        @error('tgl_kegiatan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" class="form-control mt-3" id="waktu_mulai" value="{{ old('waktu_mulai') }}">
                        @error('waktu_mulai')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
