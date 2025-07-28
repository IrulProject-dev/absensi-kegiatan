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
                            Edit Kegiatan (Prasence)
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

                <form action="{{ route('prasence.update', $prasence->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan"
                               value="{{ old('nama_kegiatan', $prasence->nama_kegiatan) }}" required>
                        @error('nama_kegiatan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="radius" class="form-label">Radius (meter)</label>
                        <input type="number" name="radius" class="form-control" id="radius"
                               value="{{ old('radius', $prasence->radius) }}" min="1" required>
                        @error('radius')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tgl_kegiatan" class="form-label">Tanggal Kegiatan</label>
                                <input type="date" name="tgl_kegiatan" class="form-control" id="tgl_kegiatan"
                                       value="{{ old('tgl_kegiatan', date('Y-m-d', strtotime($prasence->tgl_kegiatan))) }}" required>
                                @error('tgl_kegiatan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" class="form-control" id="waktu_mulai"
                                       value="{{ old('waktu_mulai', date('H:i', strtotime($prasence->tgl_kegiatan))) }}" required>
                                @error('waktu_mulai')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Lokasi Kegiatan</strong></label>
                        <p class="form-text text-muted mt-0">Klik pada peta atau geser penanda untuk mengubah lokasi.</p>
                        <div id="map"></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                   value="{{ old('latitude', $prasence->latitude) }}" readonly required>
                            @error('latitude')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                   value="{{ old('longitude', $prasence->longitude) }}" readonly required>
                            @error('longitude')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Update Kegiatan
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
        // Fungsi untuk validasi koordinat
        function isValidCoordinate(lat, lng) {
            return !isNaN(lat) && !isNaN(lng) &&
                   lat >= -90 && lat <= 90 &&
                   lng >= -180 && lng <= 180;
        }

        // Dapatkan nilai dari form atau default
        function getCoordinateValue(value, defaultValue) {
            const num = parseFloat(value);
            return !isNaN(num) ? num : defaultValue;
        }

        // Default koordinat (Indonesia tengah)
        const DEFAULT_LAT = -2.5489;
        const DEFAULT_LNG = 118.0149;
        const DEFAULT_ZOOM = 5;
        const DETAIL_ZOOM = 15;

        // Coba dapatkan nilai dari form atau database
        let initialLat = getCoordinateValue("{{ old('latitude', $prasence->latitude ?? '') }}", DEFAULT_LAT);
        let initialLng = getCoordinateValue("{{ old('longitude', $prasence->longitude ?? '') }}", DEFAULT_LNG);
        let currentRadius = parseInt("{{ old('radius', $prasence->radius ?? 20) }}") || 20;

        // Cek validitas koordinat
        const coordinatesValid = isValidCoordinate(initialLat, initialLng);

        // Jika koordinat tidak valid, gunakan default
        if (!coordinatesValid) {
            initialLat = DEFAULT_LAT;
            initialLng = DEFAULT_LNG;
            console.warn('Koordinat tidak valid, menggunakan default');
        }

        // Inisialisasi peta
        const map = L.map('map').setView([initialLat, initialLng], coordinatesValid ? DETAIL_ZOOM : DEFAULT_ZOOM);

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

        // Set nilai awal input
        latitudeInput.value = initialLat.toFixed(8);
        longitudeInput.value = initialLng.toFixed(8);
        radiusInput.value = currentRadius;

        // Fungsi untuk memperbarui nilai input dan circle
        function updateInputs(lat, lng) {
            latitudeInput.value = lat.toFixed(8);
            longitudeInput.value = lng.toFixed(8);
            marker.setLatLng([lat, lng]);
            circle.setLatLng([lat, lng]);
            circle.setRadius(currentRadius);

            // Auto zoom ke lokasi baru
            map.setView([lat, lng], DETAIL_ZOOM);
        }

        // Event listener saat marker digeser
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            updateInputs(position.lat, position.lng);
        });

        // Event listener saat peta diklik
        map.on('click', function(e) {
            updateInputs(e.latlng.lat, e.latlng.lng);
        });

        // Event listener saat radius diubah
        radiusInput.addEventListener('input', function() {
            currentRadius = parseInt(this.value) || 20;
            circle.setRadius(currentRadius);
        });

        // Tampilkan warning jika koordinat default digunakan
        if (!coordinatesValid) {
            const mapContainer = document.getElementById('map');
            const warningDiv = document.createElement('div');
            warningDiv.className = 'map-error';
            warningDiv.innerHTML = '<strong>Peringatan:</strong> Lokasi sebelumnya tidak valid. Silahkan pilih lokasi baru.';
            mapContainer.parentNode.insertBefore(warningDiv, mapContainer.nextSibling);
        }
    </script>
@endpush
