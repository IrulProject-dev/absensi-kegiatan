@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            margin-top: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">
                            Tambah Kegiatan (Prasence)
                        </h4>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('prasence.index') }}" class="btn btn-sm btn-outline-primary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('prasence.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required>
                        @error('nama_kegiatan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Added Radius Input Field -->
                    <div class="mb-3">
                        <label for="radius" class="form-label">Radius (meter)</label>
                        <input type="number" name="radius" class="form-control" id="radius"
                               value="{{ old('radius', 20) }}" min="1" required>
                        @error('radius')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tgl_kegiatan" class="form-label">Tanggal Kegiatan</label>
                                <input type="date" name="tgl_kegiatan" class="form-control" id="tgl_kegiatan" value="{{ old('tgl_kegiatan', date('Y-m-d')) }}" required>
                                @error('tgl_kegiatan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" class="form-control" id="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                                @error('waktu_mulai')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Lokasi Kegiatan</strong></label>
                        <p class="form-text text-muted mt-0">Klik pada peta atau geser penanda untuk memilih lokasi.</p>
                        <div id="map"></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly required>
                             @error('latitude')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly required>
                             @error('longitude')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Simpan Kegiatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <script>
        // Tentukan koordinat awal dan nilai dari old() jika ada
        const initialLat = {{ old('latitude', -2.5489) }};
        const initialLng = {{ old('longitude', 118.0149) }};
        const initialZoom = {{ old('latitude') ? 15 : 5 }};
        let currentRadius = {{ old('radius', 20) }};

        // Inisialisasi peta
        const map = L.map('map').setView([initialLat, initialLng], initialZoom);

        // Tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Marker yang bisa digeser
        let marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);

        // Circle untuk menunjukkan radius
        let circle = L.circle([initialLat, initialLng], {
            color: 'blue',
            fillColor: '#3388ff',
            fillOpacity: 0.2,
            radius: currentRadius
        }).addTo(map);

        const latitudeInput = document.querySelector('#latitude');
        const longitudeInput = document.querySelector('#longitude');
        const radiusInput = document.querySelector('#radius');

        // Fungsi untuk memperbarui nilai input dan circle
        function updateInputs(lat, lng) {
            latitudeInput.value = lat.toFixed(8);
            longitudeInput.value = lng.toFixed(8);
            marker.setLatLng([lat, lng]);
            circle.setLatLng([lat, lng]);
            circle.setRadius(currentRadius);
        }

        // Set nilai awal input
        updateInputs(initialLat, initialLng);

        // Event listener saat marker digeser
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            updateInputs(position.lat, position.lng);
        });

        // Event listener saat peta diklik
        map.on('click', function(e) {
            updateInputs(e.latlng.lat, e.latlng.lng);
            map.setView(e.latlng, 15);
        });

        // Event listener saat radius diubah
        radiusInput.addEventListener('input', function() {
            currentRadius = parseInt(this.value);
            circle.setRadius(currentRadius);
        });
    </script>
@endpush
