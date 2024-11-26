@extends('layout.master')

@section('title')
    ALOKASI PUPUK PADA DATA LAHAN
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Detail Informasi Lahan</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Informasi Lahan</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Penggarap Lahan:</strong> {{ $lahan->user->name }}</p>
                        <p><strong>Nama Lahan:</strong> {{ $lahan->nama_lahan }}</p>
                        <p><strong>Luas Lahan:</strong> {{ $lahan->luas_lahan }} M2</p>
                        <p><strong>Isi Lahan:</strong> {{ $lahan->isi_lahan }}</p>
                        <p><strong>Pemilik Lahan:</strong> {{ $lahan->pemilik_lahan }}</p>
                        <p><strong>Alamat Lahan:</strong> {{ $lahan->alamat_lahan }}</p>
                        <p><strong>Hasil Panen:</strong> {{ $lahan->hasil_panen }} Kg</p>
                        <p><strong>Awal Tanam:</strong> {{ $lahan->awal_tanam }}</p>
                        <p><strong>Akhir Tanam:</strong> {{ $lahan->akhir_tanam }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Gambar Lahan:</strong></p>
                        <img src="{{ asset('/storage/uploads/' . $lahan->gambar) }}" alt="Gambar Lahan"
                            style="width: 100%; height: auto;">
                    </div>
                </div>

            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>List Alokasi Pupuk</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penanggung Jawab</th>
                            <th>Jabatan Penanggung Jawab</th>
                            <th>Musim Tanam Ke</th>
                            <th>Total Nilai Alokasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lahan->alokasi_pupuk as $index => $alokasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $alokasi->nama_penanggung_jawab }}</td>
                                <td>{{ $alokasi->jabatan_penanggung_jawab }}</td>
                                <td>{{ $alokasi->musim_tanam }}</td>
                                <td>Rp. {{ number_format($alokasi->list_pupuk->sum('total_nilai_subsidi')) }}</td>
                                <td>
                                    <!-- Button Detail -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $alokasi->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @foreach ($lahan->alokasi_pupuk as $index => $alokasi)
            <!-- Modal Detail -->
            <div class="modal fade" id="detailModal{{ $alokasi->id }}" tabindex="-1"
                aria-labelledby="detailModalLabel{{ $alokasi->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $alokasi->id }}">Detail Alokasi Pupuk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Tampilkan detail alokasi pupuk -->
                            <p><strong>Nama Penanggung Jawab:</strong> {{ $alokasi->nama_penanggung_jawab }}</p>
                            <p><strong>Jabatan Penanggung Jawab:</strong> {{ $alokasi->jabatan_penanggung_jawab }}</p>
                            <p><strong>Musim Tanam Ke:</strong> {{ $alokasi->musim_tanam }}</p>

                            <!-- Tampilkan data list pupuk dalam bentuk tabel -->
                            <h6>List Pupuk:</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Jenis Pupuk</th>
                                        <th>Jumlah Pupuk (Kg)</th>
                                        <th>Harga Pupuk (Rp/Kg)</th>
                                        <th>Total Nilai Subsidi (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalNilaiSubsidi = 0;
                                    @endphp
                                    @foreach ($alokasi->list_pupuk as $list)
                                        <tr>
                                            <td>{{ $list->jenis_pupuk }}</td>
                                            <td>{{ number_format($list->jumlah_alokasi) }}</td>
                                            <td>Rp. {{ number_format($list->harga_pupuk) }}</td>
                                            <td>Rp. {{ number_format($list->total_nilai_subsidi) }}</td>
                                        </tr>
                                        @php
                                            $totalNilaiSubsidi += $list->total_nilai_subsidi;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th>Rp. {{ number_format($totalNilaiSubsidi) }}</th>
                                    </tr>
                                </tfoot>
                            </table>


                            <!-- Tambahkan gambar bukti distribusi -->
                            <p><strong>Foto Bukti Distribusi:</strong></p>
                            <img src="{{ Storage::url('uploads/' . $alokasi->foto_bukti_distribusi) }}"
                                alt="Foto Bukti Distribusi" class="img-fluid mb-3">

                            <!-- Tambahkan gambar tanda tangan -->
                            <p><strong>Foto Tanda Tangan:</strong></p>
                            <img src="{{ Storage::url('uploads/' . $alokasi->foto_tanda_tangan) }}" alt="Foto Tanda Tangan"
                                class="img-fluid mb-3">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="card">
            <div class="card-header">
                <h4>Peta Lokasi Lahan</h4>
            </div>
            <div class="card-body">
                <div id="map" style="height: 800px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/leaflet/leaflet.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .leaflet-container {
            z-index: 1;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendors/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('geojson/leaflet.ajax.js') }}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

        // Leaflet Map
        var map = L.map('map');

        // Layer OpenStreetMap
        var openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        // Layer Google Maps (satellite)
        var googleMaps = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: '&copy; <a href="https://www.google.com/maps">Google Maps</a>'
        });

        // Layer Google Maps (hybrid)
        var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: '&copy; <a href="https://www.google.com/maps">Google Maps</a>'
        });

        // Tambahkan OpenStreetMap sebagai peta awal
        googleMaps.addTo(map);

        // Opsi untuk basemap (peta dasar)
        var baseMaps = {
        "OpenStreetMap": openStreetMap,
        "Google Maps (Satellite)": googleMaps,
        "Google Maps (Hybrid)": googleHybrid
        };

        // Tambahkan kontrol layer ke peta
        L.control.layers(baseMaps).addTo(map);

        // Array to store all bounds
        var allBounds = [];

        @if ($lahan->denah_lahan)
            var geojsonData = {
                "type": "Feature",
                "geometry": {
                    "type": "MultiPolygon",
                    "coordinates": {!! $lahan->denah_lahan !!}
                },
                "properties": {
                    "name": "{{ $lahan->nama_lahan }}"
                }
            };

            // Add GeoJSON layer and get its bounds
            var geoJsonLayer = L.geoJSON(geojsonData).addTo(map).bindPopup(`
                    <div style="width: 300px;">
                        <h4>{{ $lahan->nama_lahan }}</h4>
                        <p><b>Nama Kelompok Tani:</b> {{ $lahan->nama_kelompok_tani }}</p>
                        <p><b>Nomor Kartu Tani:</b> {{ $lahan->nomor_kartu_tani ? $lahan->nomor_kartu_tani : '-' }}</p>
                        <p><b>Luas Lahan:</b> {{ $lahan->luas_lahan }} M2</p>
                        <p><b>Isi Lahan:</b> {{ $lahan->isi_lahan }}</p>
                        <p><b>Pemilik Lahan:</b> {{ $lahan->pemilik_lahan }}</p>
                        <p><b>Alamat Lahan:</b> {{ $lahan->alamat_lahan }}</p>
                        <p><b>Hasil Panen:</b> {{ $lahan->hasil_panen }} Kg</p>
                        <p><b>Awal Tanam:</b> {{ $lahan->awal_tanam }}</p>
                        <p><b>Akhir Tanam:</b> {{ $lahan->akhir_tanam }}</p>
                        <p><b>Gambar:</b></p>
                        <img src="{{ asset('/storage/uploads/' . $lahan->gambar) }}" alt="Gambar Lahan" style="width: 100%; height: auto;">
                    </div>
                `);
            allBounds.push(geoJsonLayer.getBounds());
        @endif

        // Fit the map to show all bounds
        if (allBounds.length > 0) {
            if (allBounds.length === 1) {
                map.fitBounds(allBounds[0]);
            } else {
                var combinedBounds = allBounds[0];
                for (var i = 1; i < allBounds.length; i++) {
                    combinedBounds.extend(allBounds[i]);
                }
                map.fitBounds(combinedBounds);
            }
        } else {
            // Set default view if no geometries are present
            map.setView([-6.927806803218691, 106.93018482302313], 13);
        }


        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif

        // Menggunakan class atau attribute selector untuk mengikat event listener ke elemen input
        document.querySelectorAll('.jumlah-pupuk, .harga-pupuk').forEach(function(input) {
            input.addEventListener('input', calculateTotalSubsidi);
        });

        function calculateTotalSubsidi() {
            // Mendapatkan elemen input terkait dari elemen yang sedang diubah
            const form = this.closest('form');
            let jumlah = parseFloat(form.querySelector('.jumlah-pupuk').value) || 0;
            let harga = parseFloat(form.querySelector('.harga-pupuk').value) || 0;
            let total = jumlah * harga;
            form.querySelector('.total-nilai-subsidi').value = total;
        }

        document.getElementById('jumlah_pupuk').addEventListener('input', calculateTotalSubsidi2);
        document.getElementById('harga_pupuk').addEventListener('input', calculateTotalSubsidi2);

        function calculateTotalSubsidi2() {
            let jumlah = parseFloat(document.getElementById('jumlah_pupuk').value) || 0;
            let harga = parseFloat(document.getElementById('harga_pupuk').value) || 0;
            let total = jumlah * harga;
            document.getElementById('total_nilai_subsidi').value = total;
        }


        function setupUpdateFormListeners(alokasiId) {
            const jumlahInput = document.getElementById(`jumlah_pupuk${alokasiId}`);
            const hargaInput = document.getElementById(`harga_pupuk${alokasiId}`);
            const totalInput = document.getElementById(`total_nilai_subsidi${alokasiId}`);

            function calculateTotalSubsidi() {
                let jumlah = parseFloat(jumlahInput.value) || 0;
                let harga = parseFloat(hargaInput.value) || 0;
                let total = jumlah * harga;
                totalInput.value = total;
            }

            jumlahInput.addEventListener('input', calculateTotalSubsidi);
            hargaInput.addEventListener('input', calculateTotalSubsidi);
        }
    </script>
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                html: `
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pupukPerM2 = {
                'padi': {
                    'urea': 0.025,
                    'npk': 0.03,
                    'kcl': 0.0075,
                    'sp36': 0.015,
                    'poska': 0.025
                },
                'cabai': {
                    'urea': 0.02,
                    'npk': 0.03,
                    'kcl': 0.01,
                    'sp36': 0.015,
                    'poska': 0
                },
                'jagung': {
                    'urea': 0.03,
                    'npk': 0.02,
                    'kcl': 0.0075,
                    'sp36': 0.01,
                    'poska': 0
                }
            };

            const hargaPupuk = {
                'urea': 2250,
                'npk': 2300,
                'kcl': 2300,
                'sp36': 2400,
                'poska': 2300
            };

            function updatePupukRow(row) {
                const jenisPupuk = row.querySelector('.jenis-pupuk').value;
                const jumlahPupuk = row.querySelector('.jumlah-pupuk');
                const hargaPupukField = row.querySelector('.harga-pupuk');
                const totalNilaiSubsidi = row.querySelector('.total-nilai-subsidi');
                const luasLahan = parseFloat('{{ $lahan->luas_lahan }}');
                const isiLahan = '{{ $lahan->isi_lahan }}';

                if (jenisPupuk && luasLahan && isiLahan) {
                    const pupukPerM2ForLahan = pupukPerM2[isiLahan] || {};
                    const jumlah = luasLahan * (pupukPerM2ForLahan[jenisPupuk] || 0);
                    jumlahPupuk.value = jumlah.toFixed(2);
                    hargaPupukField.value = hargaPupuk[jenisPupuk] || 0;
                    totalNilaiSubsidi.value = (jumlah * (hargaPupuk[jenisPupuk] || 0)).toFixed(2);
                }
            }

            document.querySelector('#add-row').addEventListener('click', function() {
                const row = document.querySelector('#pupuk-table tbody tr');
                const clone = row.cloneNode(true);
                row.parentNode.appendChild(clone);
                clone.querySelector('.jenis-pupuk').value = '';
                clone.querySelector('.jumlah-pupuk').value = '';
                clone.querySelector('.harga-pupuk').value = '';
                clone.querySelector('.total-nilai-subsidi').value = '';
            });

            document.querySelector('#pupuk-table').addEventListener('change', function(e) {
                if (e.target.matches('.jenis-pupuk')) {
                    updatePupukRow(e.target.closest('tr'));
                }
            });

            document.querySelector('#pupuk-table').addEventListener('click', function(e) {
                if (e.target.matches('.remove-row')) {
                    e.target.closest('tr').remove();
                }
            });

            // Initial calculation
            updatePupukRow(document.querySelector('#pupuk-table tbody tr'));
        });
    </script>
@endpush
