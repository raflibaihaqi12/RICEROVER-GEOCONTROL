@extends('layout.master')

@section('title')
    DATA LAHAN
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Data Lahan</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Table Data Lahan</span>
                    <a href="/user/add-lahan" class="btn btn-primary">Tambah Lahan</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lahan</th>
                            <th>Luas Lahan</th>
                            <th>Luas Tanam</th>
                            <th>Isi Lahan</th>
                            <th>Pemilik Lahan</th>
                            <th>Total Hasil Panen</th>
                            <th>Status Lahan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lahans as $index => $lahan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $lahan->nama_lahan }}</td>
                                <td>{{ $lahan->luas_lahan }} M&sup2;</td>
                                <td>{{ $lahan->luas_tanam }} M&sup2;</td>
                                <td>{{ $lahan->isi_lahan }}</td>
                                <td>{{ $lahan->pemilik_lahan }}</td>
                                <td>{{ $lahan->hasil_panen }} Kg</td>
                                <td>{{ $lahan->status == 'berjalan' ? 'Belum Selesai Masa Panen' : 'Selesai Masa Panen' }}
                                </td>
                                <td>
                                    <a href="/user/update-data-lahan/{{ $lahan->id }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="/user/data-alokasi/{{ $lahan->id }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if ($lahan->status == 'berjalan')
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#modalSelesai{{ $lahan->id }}">
                                            <i class="bi bi-check2-circle"></i>
                                        </button>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Peta Lokasi Lahan</h4>
            </div>
            <div class="card-body">
                <div id="map" style="height: 800px;"></div>
            </div>
        </div>
    </div>

    @foreach ($lahans as $lahan)
        @if ($lahan->status == 'berjalan')
            <!-- Modal -->
            <div class="modal fade" id="modalSelesai{{ $lahan->id }}" tabindex="-1"
                aria-labelledby="modalSelesaiLabel{{ $lahan->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSelesaiLabel{{ $lahan->id }}">Konfirmasi Selesai Masa Panen
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin mengubah status lahan <strong>{{ $lahan->nama_lahan }}</strong> menjadi
                            "Selesai Masa Panen"? Action ini tidak dapat di kembalikan dan lahan ini tidak akan mendapat
                            alokasi pupuk lagi.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="/update-status-lahan/{{ $lahan->id }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Ya, Ubah Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
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
        /* Mengubah warna ikon prev dan next */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(50, 44, 44, 0.8);
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

        // Leaflet Map Initialization
        var map = L.map('map').setView([-6.927806803218691, 106.93018482302313], 13);

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

        // Object to store grouped lahan by coordinates
        var groupedLahans = {};

        // Loop through lahan data and group by coordinates
        @foreach ($lahans as $lahan)
            @if ($lahan->denah_lahan && $lahan->status == 'berjalan')
                var coordinates = {!! $lahan->denah_lahan !!};
                var key = JSON.stringify(coordinates); // Use coordinates as the key

                // Group lahan by coordinates
                if (!groupedLahans[key]) {
                    groupedLahans[key] = [];
                }

                groupedLahans[key].push({
                    "nama_lahan": "{{ $lahan->nama_lahan }}",
                    "nama_kelompok_tani": "{{ $lahan->nama_kelompok_tani }}",
                    "nomor_kartu_tani": "{{ $lahan->nomor_kartu_tani ? $lahan->nomor_kartu_tani : '-' }}",
                    "luas_lahan": "{{ $lahan->luas_lahan }}",
                    "luas_tanam": "{{ $lahan->luas_tanam }}",
                    "isi_lahan": "{{ $lahan->isi_lahan }}",
                    "pemilik_lahan": "{{ $lahan->pemilik_lahan }}",
                    "alamat_lahan": "{{ $lahan->alamat_lahan }}",
                    "hasil_panen": "{{ $lahan->hasil_panen }}",
                    "awal_tanam": "{{ $lahan->awal_tanam }}",
                    "akhir_tanam": "{{ $lahan->akhir_tanam }}",
                    "gambar": "{{ asset('/storage/uploads/' . $lahan->gambar) }}"
                });
            @endif
        @endforeach

        // Function to create carousel content
        function getCarouselContent(lahanList) {
            var carouselItems = lahanList.map((lahan, index) => {
                var isActive = index === 0 ? 'active' : ''; // Set first item as active
                return `
                    <div class="carousel-item ${isActive}">
                        <h4>${lahan.nama_lahan}</h4>
                        <p><b>Nama Kelompok Tani:</b> ${lahan.nama_kelompok_tani}</p>
                        <p><b>Nomor Kartu Tani:</b> ${lahan.nomor_kartu_tani}</p>
                        <p><b>Luas Lahan:</b> ${lahan.luas_lahan} M&sup2;</p>
                        <p><b>Luas Tanam:</b> ${lahan.luas_tanam} M&sup2;</p>
                        <p><b>Isi Lahan:</b> ${lahan.isi_lahan}</p>
                        <p><b>Pemilik Lahan:</b> ${lahan.pemilik_lahan}</p>
                        <p><b>Alamat Lahan:</b> ${lahan.alamat_lahan}</p>
                        <p><b>Hasil Panen:</b> ${lahan.hasil_panen} Kg</p>
                        <p><b>Awal Tanam:</b> ${lahan.awal_tanam}</p>
                        <p><b>Akhir Tanam:</b> ${lahan.akhir_tanam}</p>
                        <p><b>Gambar:</b></p>
                        <img src="${lahan.gambar}" alt="Gambar Lahan" style="width: 100%; height: auto;">
                    </div>
                `;
            }).join('');

            return `
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        ${carouselItems}
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </a>
                </div>
            `;
        }

        var lahanList = [];

        // Loop through groupedLahans and add to map
        Object.keys(groupedLahans).forEach(function(key) {
            lahanList = groupedLahans[key];
            var geojsonData = {
                "type": "Feature",
                "geometry": {
                    "type": "MultiPolygon",
                    "coordinates": JSON.parse(key)
                }
            };

            // Create a layer for each grouped lahan
            var layerGroup = L.layerGroup();
            var geoJsonLayer = L.geoJSON(geojsonData).addTo(layerGroup);

            // Bind popup to the lahan group
            geoJsonLayer.bindPopup(getCarouselContent(lahanList), {
                maxWidth: 400
            }); // Use carousel in popup

            // Add layer group to map
            layerGroup.addTo(map);

            // Store bounds for fitBounds
            allBounds.push(geoJsonLayer.getBounds());
        });

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
    </script>
@endpush
