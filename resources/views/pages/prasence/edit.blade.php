@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-top: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-radius: 12px;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0 !important;
        }

        .form-label {
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.625rem 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
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

        .btn-primary {
            background-color: #4299e1;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #3182ce;
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 8px;
            padding: 1rem 1.5rem;
        }

        .text-danger {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .map-instructions {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #4299e1;
        }

        .coordinate-inputs {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .map-error {
            background-color: #fff5f5;
            color: #e53e3e;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            border-left: 4px solid #e53e3e;
        }

        .invalid-coordinate {
            border-color: #e53e3e;
            background-color: #fff5f5;
        }
    </style>
@endpush

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-plus me-2"></i>Edit Kegiatan
                    </h4>
                    <a href="{{ route('prasence.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('prasence.update', $prasence->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan"
                               value="{{ old('nama_kegiatan', $prasence->nama_kegiatan) }}" placeholder="Masukkan nama kegiatan" required>
                        @error('nama_kegiatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tgl_kegiatan" class="form-label">Tanggal Kegiatan</label>
                                <input type="date" name="tgl_kegiatan" class="form-control" id="tgl_kegiatan"
                                       value="{{ old('tgl_kegiatan', date('Y-m-d', strtotime($prasence->tgl_kegiatan))) }}" required>
                                @error('tgl_kegiatan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" class="form-control" id="waktu_mulai"
                                       value="{{ old('waktu_mulai', date('H:i', strtotime($prasence->tgl_kegiatan))) }}" required>
                                @error('waktu_mulai')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="radius" class="form-label">Radius Kehadiran (meter)</label>
                        <input type="number" name="radius" class="form-control" id="radius"
                               value="{{ old('radius', $prasence->radius) }}" min="1" placeholder="Masukkan radius dalam meter" required>
                        @error('radius')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><strong>Lokasi Kegiatan</strong></label>
                        <div class="map-instructions">
                            <i class="bi bi-info-circle me-2"></i>Klik pada peta atau geser penanda untuk mengubah lokasi
                        </div>
                        <div id="map"></div>
                        <div class="coordinate-inputs">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude"
                                           value="{{ old('latitude', $prasence->latitude) }}" readonly required>
                                    @error('latitude')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude"
                                           value="{{ old('longitude', $prasence->longitude) }}" readonly required>
                                    @error('longitude')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="bi bi-save me-2"></i>Update Kegiatan
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

        // Dapatkan nilai dari form atau database
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
        let initialLat = getCoordinateValue("{{ old('latitude', $prasence->latitude) }}", DEFAULT_LAT);
        let initialLng = getCoordinateValue("{{ old('longitude', $prasence->longitude) }}", DEFAULT_LNG);
        let currentRadius = parseInt("{{ old('radius', $prasence->radius) }}") || 20;

        // Cek validitas koordinat
        const coordinatesValid = isValidCoordinate(initialLat, initialLng);

        // Jika koordinat tidak valid, gunakan default
        if (!coordinatesValid) {
            initialLat = DEFAULT_LAT;
            initialLng = DEFAULT_LNG;
            console.warn('Koordinat tidak valid, menggunakan default');

            // Tampilkan warning
            const mapContainer = document.getElementById('map');
            const warningDiv = document.createElement('div');
            warningDiv.className = 'map-error';
            warningDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i><strong>Peringatan:</strong> Lokasi sebelumnya tidak valid. Silahkan pilih lokasi baru.';
            mapContainer.parentNode.insertBefore(warningDiv, mapContainer.nextSibling);

            // Tandai input koordinat sebagai invalid
            document.getElementById('latitude').classList.add('invalid-coordinate');
            document.getElementById('longitude').classList.add('invalid-coordinate');
        }

        // Inisialisasi peta
        const map = L.map('map').setView([initialLat, initialLng], coordinatesValid ? DETAIL_ZOOM : DEFAULT_ZOOM);

        // Tile layer dari OpenStreetMap dengan style lebih kontras
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Custom marker icon
        const customIcon = L.icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34]
        });

        // Create draggable marker
        let marker = L.marker([initialLat, initialLng], {
            draggable: true,
            icon: customIcon
        }).addTo(map);

        // Create circle untuk radius
        let circle = L.circle([initialLat, initialLng], {
            color: '#3182ce',
            fillColor: '#90cdf4',
            fillOpacity: 0.3,
            radius: currentRadius
        }).addTo(map);

        // Get DOM elements
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const radiusInput = document.getElementById('radius');

        // Fungsi untuk update inputs dan map elements
        function updateInputs(lat, lng) {
            const latFixed = lat.toFixed(6);
            const lngFixed = lng.toFixed(6);

            latitudeInput.value = latFixed;
            longitudeInput.value = lngFixed;

            // Update marker dan circle
            marker.setLatLng([lat, lng]);
            circle.setLatLng([lat, lng]);
            circle.setRadius(currentRadius);

            // Hilangkan status invalid jika ada
            latitudeInput.classList.remove('invalid-coordinate');
            longitudeInput.classList.remove('invalid-coordinate');

            // Hilangkan warning jika ada
            const warningDiv = document.querySelector('.map-error');
            if (warningDiv) {
                warningDiv.remove();
            }

            // Auto zoom ke lokasi baru
            map.setView([lat, lng], DETAIL_ZOOM);
        }

        // Set nilai awal input
        updateInputs(initialLat, initialLng);

        // Marker drag event
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            updateInputs(position.lat, position.lng);
        });

        // Map click event
        map.on('click', function(e) {
            updateInputs(e.latlng.lat, e.latlng.lng);
        });

        // Radius input change event
        radiusInput.addEventListener('input', function() {
            currentRadius = parseInt(this.value) || 20;
            if (!isNaN(currentRadius) && currentRadius > 0) {
                circle.setRadius(currentRadius);
            }
        });
    </script>
@endpush
