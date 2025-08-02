<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} - Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #4e73df;
            --primary-light: #e3ebf7;
            --danger: #e74a3b;
            --danger-light: #f8e0dd;
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .info-table {
            width: 100%;
        }
        
        .info-table tr td:first-child {
            font-weight: 500;
            color: #4a5568;
            width: 150px;
        }
        
        .info-table tr td:nth-child(2) {
            width: 20px;
        }
        
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.625rem 1rem;
            transition: all 0.2s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.2);
        }
        
        .btn-primary {
            background-color: var(--primary);
            border: none;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #3d5dd8;
            transform: translateY(-1px);
        }
        
        .btn-outline-danger {
            border-radius: 8px;
        }
        
        .signature-container {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.5rem;
            margin-bottom: 1rem;
            background-color: white;
        }
        
        #signature-pad {
            width: 100%;
            height: 150px;
            background-color: white;
        }
        
        .modal-header {
            background-color: var(--danger);
            color: white;
        }
        
        .spinner-border {
            width: 1rem;
            height: 1rem;
        }
        
        .attendance-title {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .row-cols-md-1 > * {
                flex: 0 0 auto;
                width: 100%;
            }
        }
    </style>
  </head>
  <body>
    <div class="container my-4">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="text-center attendance-title">
                    <i class="bi bi-clipboard-check me-2"></i>Absensi Sekolah
                </h4>
                <table class="info-table">
                    <tr>
                        <td>Nama Kegiatan</td>
                        <td>:</td>
                        <td>{{ $prasence->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kegiatan</td>
                        <td>:</td>
                        <td>{{ date('d-m-Y', strtotime($prasence->tgl_kegiatan)) }}</td>
                    </tr>
                    <tr>
                        <td>Waktu Mulai</td>
                        <td>:</td>
                        <td>{{ date('H:i', strtotime($prasence->tgl_kegiatan)) }}</td>
                    </tr>
                    <tr>
                        <td>Radius (meter)</td>
                        <td>:</td>
                        <td>{{ $prasence->radius }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-pencil-square me-2"></i>Form Absensi
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('absen.save', $prasence->id) }}" method="POST" id="form-absen">
                            @csrf
                            <input type="hidden" id="userLatitude" name="latitude">
                            <input type="hidden" id="userLongitude" name="longitude">

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan" required>
                                @error('jabatan')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="asal_instansi" class="form-label">Asal Instansi</label>
                                <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" placeholder="Masukkan asal instansi" required>
                                @error('asal_instansi')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="signature-pad" class="form-label">Tanda Tangan</label>
                                <div class="signature-container">
                                    <canvas id="signature-pad" class="signature-pad"></canvas>
                                </div>
                                <textarea name="signature" id="signature64" class="d-none"></textarea>
                                @error('signature')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <button type="button" class="btn btn-outline-danger btn-sm" id="clear-signature">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                <span id="submitText">Submit Absensi</span>
                                <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-list-check me-2"></i>Daftar Kehadiran
                        </h5>
                    </div>
                    <div class="card-body">
                        {{ $dataTable->table(['class' => 'table table-hover'], true) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Location Modal -->
    <div class="modal fade" id="locationErrorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle me-2"></i>Lokasi Tidak Sesuai
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda berada di luar radius yang ditentukan untuk absensi ini ({{ $prasence->radius }} meter).</p>
                    <p class="mb-0">Silahkan mendekat ke lokasi kegiatan untuk melakukan absensi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('js/signature.min.js') }}"></script>
    <script>
        $(function(){
            // Initialize signature pad
            const canvas = document.getElementById('signature-pad');
            canvas.width = canvas.offsetWidth;
            
            let signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255,255,255,0)',
                penColor: 'rgb(0,0,0)',
                minWidth: 1,
                maxWidth: 2
            });

            $('#clear-signature').on('click', function(){
                signaturePad.clear();
                $('#signature64').val('');
            });

            canvas.addEventListener('mouseup touchend', function(){
                $('#signature64').val(signaturePad.toDataURL());
            });

            // Event data
            const eventData = {
                lat: {{ $prasence->latitude }},
                lng: {{ $prasence->longitude }},
                radius: {{ $prasence->radius }}
            };

            // Calculate distance between coordinates
            function getDistance(lat1, lon1, lat2, lon2) {
                const R = 6371e3; // Earth radius in meters
                const φ1 = lat1 * Math.PI/180;
                const φ2 = lat2 * Math.PI/180;
                const Δφ = (lat2-lat1) * Math.PI/180;
                const Δλ = (lon2-lon1) * Math.PI/180;

                const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                          Math.cos(φ1) * Math.cos(φ2) *
                          Math.sin(Δλ/2) * Math.sin(Δλ/2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

                return R * c;
            }

            // Get user location
            function getUserLocation() {
                return new Promise((resolve, reject) => {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => resolve({
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            }),
                            (error) => reject(error),
                            { enableHighAccuracy: true, timeout: 10000 }
                        );
                    } else {
                        reject(new Error("Geolocation not supported"));
                    }
                });
            }

            // Form submission handler
            $('#form-absen').on('submit', async function(e) {
                e.preventDefault();
                
                // Validate signature
                if (signaturePad.isEmpty()) {
                    alert('Harap berikan tanda tangan terlebih dahulu');
                    return;
                }
                
                // Update UI
                const submitBtn = $('#submitBtn');
                const submitText = $('#submitText');
                const submitSpinner = $('#submitSpinner');
                
                submitBtn.prop('disabled', true);
                submitText.text('Memproses...');
                submitSpinner.removeClass('d-none');

                try {
                    // Get location
                    const userLocation = await getUserLocation();
                    const distance = getDistance(
                        eventData.lat,
                        eventData.lng,
                        userLocation.lat,
                        userLocation.lng
                    );

                    // Save coordinates
                    $('#userLatitude').val(userLocation.lat);
                    $('#userLongitude').val(userLocation.lng);

                    // Check radius
                    if (distance > eventData.radius) {
                        new bootstrap.Modal('#locationErrorModal').show();
                        submitBtn.prop('disabled', false);
                        submitText.text('Submit Absensi');
                        submitSpinner.addClass('d-none');
                        return;
                    }

                    // Save signature and submit
                    $('#signature64').val(signaturePad.toDataURL());
                    this.submit();

                } catch (error) {
                    console.error("Error:", error);
                    alert("Gagal mendapatkan lokasi. Pastikan izin lokasi diberikan dan GPS aktif.");
                    submitBtn.prop('disabled', false);
                    submitText.text('Submit Absensi');
                    submitSpinner.addClass('d-none');
                }
            });
            
            // Responsive signature pad
            window.addEventListener('resize', function() {
                canvas.width = canvas.offsetWidth;
                signaturePad.clear(); // Clearing will redraw at new size
            });
        });
    </script>

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
  </body>
</html>