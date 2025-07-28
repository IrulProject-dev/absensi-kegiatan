<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
  </head>
  <body>
    <div class="container my-5">
        <div class="card">
            <div class="card-body mb-4">
                <h4 class="text-center">Absensi Sekolah</h4>
                <table class="table table-borderless">
                    <tr>
                        <td width="150">Nama Kegiatan</td>
                        <td width="20"> : </td>
                        <td>{{ $prasence->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kegiatan</td>
                        <td> : </td>
                        <td>{{ date('d-m-Y', strtotime($prasence->tgl_kegiatan)) }}</td>
                    </tr>
                    <tr>
                        <td>Waktu Mulai</td>
                        <td> : </td>
                        <td>{{ date('H:i', strtotime($prasence->tgl_kegiatan)) }}</td>
                    </tr>
                    <tr>
                        <td>Radius (meter)</td>
                        <td> : </td>
                        <td>{{ $prasence->radius }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Absensi</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('absen.save', $prasence->id) }}" method="POST" id="form-absen">
                            @csrf
                            <input type="hidden" id="userLatitude" name="latitude">
                            <input type="hidden" id="userLongitude" name="longitude">

                            <div class="mb-3">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan" required>
                                @error('jabatan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="asal_instansi">Asal Instansi</label>
                                <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" placeholder="Asal instansi" required>
                                @error('asal_instansi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanda_tangan">Tanda Tangan</label>
                                <div class="d-block form-control mb-2">
                                    <canvas id="signature-pad" class="signature-pad"></canvas>
                                </div>
                                <textarea name="signature" id="signature64" class="d-none"></textarea>
                                @error('signature')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <button type="button" class="btn btn-outline-danger" id="clear-signature">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                    Clear
                                </button>
                            </div>

                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Daftar Kehadiran</h5>
                    </div>
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk pesan error -->
    <div class="modal fade" id="locationErrorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Lokasi Tidak Sesuai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda berada di luar radius yang ditentukan untuk absensi ini ({{ $prasence->radius }} meter).</p>
                    <p>Silahkan mendekat ke lokasi kegiatan untuk melakukan absensi.</p>
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
            // Inisialisasi signature pad
            let sig = $('#signature-pad').parent().width();
            $('#signature-pad').attr('width', sig);

            let signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
                backgroundColor: 'rgb(255,255,255,0)',
                penColor: 'rgb(0,0,0)'
            });

            $('#clear-signature').on('click', function(){
                signaturePad.clear();
            });

            $('canvas').on('mouseup touchend', function(){
                $('#signature64').val(signaturePad.toDataURL());
            });

            // Data kegiatan dari server
            const kegiatanLocation = {
                lat: {{ $prasence->latitude }},
                lng: {{ $prasence->longitude }},
                radius: {{ $prasence->radius }}
            };

            // Fungsi untuk menghitung jarak antara dua koordinat (dalam meter)
            function getDistance(lat1, lon1, lat2, lon2) {
                const R = 6371e3; // Radius bumi dalam meter
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

            // Fungsi untuk mendapatkan lokasi pengguna
            function getUserLocation() {
                return new Promise((resolve, reject) => {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                resolve({
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                });
                            },
                            (error) => {
                                reject(error);
                            },
                            {
                                enableHighAccuracy: true,
                                timeout: 5000,
                                maximumAge: 0
                            }
                        );
                    } else {
                        reject(new Error("Geolocation tidak didukung"));
                    }
                });
            }

            // Handle form submission
            $('#form-absen').on('submit', async function(e) {
                e.preventDefault();

                const submitBtn = $('#submitBtn');
                submitBtn.prop('disabled', true);
                submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...');

                try {
                    // Dapatkan lokasi pengguna
                    const userLocation = await getUserLocation();

                    // Hitung jarak dari lokasi kegiatan
                    const distance = getDistance(
                        kegiatanLocation.lat,
                        kegiatanLocation.lng,
                        userLocation.lat,
                        userLocation.lng
                    );

                    // Simpan koordinat pengguna ke form
                    $('#userLatitude').val(userLocation.lat);
                    $('#userLongitude').val(userLocation.lng);

                    // Cek apakah dalam radius yang ditentukan
                    if (distance > kegiatanLocation.radius) {
                        // Tampilkan modal error
                        const modal = new bootstrap.Modal(document.getElementById('locationErrorModal'));
                        modal.show();
                        submitBtn.prop('disabled', false);
                        submitBtn.text('Submit');
                        return;
                    }

                    // Jika dalam radius, lanjutkan submit form
                    $('#signature64').val(signaturePad.toDataURL());
                    this.submit();

                } catch (error) {
                    console.error("Error:", error);
                    alert("Gagal mendapatkan lokasi. Pastikan izin lokasi diberikan dan GPS aktif.");
                    submitBtn.prop('disabled', false);
                    submitBtn.text('Submit');
                }
            });
        });
    </script>

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
  </body>
</html>
