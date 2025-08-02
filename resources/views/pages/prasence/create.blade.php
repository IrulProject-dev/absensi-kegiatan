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
    </style>
@endpush

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-plus me-2"></i>Tambah Kegiatan
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

                <form action="{{ route('prasence.store') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan"
                               value="{{ old('nama_kegiatan') }}" placeholder="Masukkan nama kegiatan" required>
                        @error('nama_kegiatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tgl_kegiatan" class="form-label">Tanggal Kegiatan</label>
                                <input type="date" name="tgl_kegiatan" class="form-control" id="tgl_kegiatan"
                                       value="{{ old('tgl_kegiatan', date('Y-m-d')) }}" required>
                                @error('tgl_kegiatan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" class="form-control" id="waktu_mulai"
                                       value="{{ old('waktu_mulai') }}" required>
                                @error('waktu_mulai')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="radius" class="form-label">Radius Kehadiran (meter)</label>
                        <input type="number" name="radius" class="form-control" id="radius"
                               value="{{ old('radius', 20) }}" min="1" placeholder="Masukkan radius dalam meter" required>
                        @error('radius')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><strong>Lokasi Kegiatan</strong></label>
                        <div class="map-instructions">
                            <i class="bi bi-info-circle me-2"></i>Klik pada peta atau geser penanda untuk memilih lokasi
                        </div>
                        <div id="map"></div>
                        <div class="coordinate-inputs">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude"
                                           value="{{ old('latitude') }}" readonly required>
                                    @error('latitude')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude"
                                           value="{{ old('longitude') }}" readonly required>
                                    @error('longitude')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="bi bi-save me-2"></i>Simpan Kegiatan
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
        // Initialize map with better default view
        const initialLat = {{ old('latitude', -2.5489) }};
        const initialLng = {{ old('longitude', 118.0149) }};
        const initialZoom = {{ old('latitude') ? 15 : 5 }};
        let currentRadius = {{ old('radius', 20) }};

        const map = L.map('map').setView([initialLat, initialLng], initialZoom);

        // Add OpenStreetMap tiles with better contrast
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

        // Create circle for radius visualization
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

        // Function to update inputs and map elements
        function updateInputs(lat, lng) {
            latitudeInput.value = lat.toFixed(6);
            longitudeInput.value = lng.toFixed(6);
            marker.setLatLng([lat, lng]);
            circle.setLatLng([lat, lng]);
            circle.setRadius(currentRadius);

            // Zoom to the new location if it's significantly different
            const currentCenter = map.getCenter();
            if (currentCenter.distanceTo([lat, lng]) > 1000) {
                map.setView([lat, lng], 15);
            }
        }

        // Set initial values
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
            currentRadius = parseInt(this.value);
            if (!isNaN(currentRadius) && currentRadius > 0) {
                circle.setRadius(currentRadius);
            }
        });
    </script>
@endpush
