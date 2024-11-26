@extends('layout.master')

@section('title')
    UPDATE DATA LAHAN
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Form Update Lahan</h3>
    </div>
    <div class="page-content">
        <div class="row">
            <!-- Form Input -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Update Data Lahan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="map" style="width: 100%; height: 400px;"></div>
                            </div>
                            <div class="col-md-6">
                                <form action="/update-data-lahan/{{ $lahan->id }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="nama_lahan">Nama Petani / Kelompok Tani</label>
                                        <input type="text" id="nama_kelompok_tani" name="nama_kelompok_tani"
                                            value="{{ $lahan->nama_kelompok_tani }}" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lahan">Nomor Kartu Tani (Jika Ada)</label>
                                        <input type="number" id="nomor_kartu_tani" name="nomor_kartu_tani"
                                            value="{{ $lahan->nomor_kartu_tani }}" class="form-control" readonly>
                                        @error('nomor_kartu_tani')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lahan">Nama Lahan</label>
                                        <input type="text" id="nama_lahan" name="nama_lahan"
                                            value="{{ $lahan->nama_lahan }}"
                                            class="form-control @error('nama_lahan') is-invalid @enderror">
                                        @error('nama_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="luas_lahan">Luas Lahan (M2)</label>
                                        <input type="number" id="luas_lahan" name="luas_lahan"
                                            value="{{ $lahan->luas_lahan }}"
                                            class="form-control @error('luas_lahan') is-invalid @enderror">
                                        @error('luas_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="isi_lahan">Isi Lahan</label>
                                        <select id="isi_lahan" name="isi_lahan"
                                            class="form-control @error('isi_lahan') is-invalid @enderror">
                                            <option value="padi" {{ $lahan->isi_lahan == 'padi' ? 'selected' : '' }}>Padi
                                            </option>
                                            <option value="jagung" {{ $lahan->isi_lahan == 'jagung' ? 'selected' : '' }}>
                                                Jagung</option>
                                            <option value="cabai" {{ $lahan->isi_lahan == 'cabai' ? 'selected' : '' }}>
                                                Cabai
                                            </option>
                                        </select>
                                        @error('isi_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pemilik_lahan">Pemilik Lahan</label>
                                        <input type="text" id="pemilik_lahan" name="pemilik_lahan"
                                            value="{{ $lahan->pemilik_lahan }}"
                                            class="form-control @error('pemilik_lahan') is-invalid @enderror">
                                        @error('pemilik_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat_lahan">Alamat Lahan</label>
                                        <textarea id="alamat_lahan" name="alamat_lahan" class="form-control @error('alamat_lahan') is-invalid @enderror">{{ $lahan->alamat_lahan }}</textarea>
                                        @error('alamat_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="denah_lahan">Denah Lahan</label>
                                        <input type="text" id="denah_lahan" name="denah_lahan"
                                            value="{{ $lahan->denah_lahan }}"
                                            class="form-control @error('denah_lahan') is-invalid @enderror"
                                            placeholder="Klik Di Peta / Pilih Lokasi Saat Ini" readonly>
                                        @error('denah_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar">Gambar (Kosongkan jika tidak ingin mengubah)</label>
                                        <input type="file" id="gambar" name="gambar"
                                            class="form-control @error('gambar') is-invalid @enderror">
                                        @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if ($lahan->gambar)
                                        <div class="form-group mt-2">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#gambarModal">Lihat
                                                Gambar Saat Ini</a>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="hasil_panen">Total Hasil Panen (Kg)</label>
                                        <input type="number" id="hasil_panen" name="hasil_panen"
                                            value="{{ $lahan->hasil_panen }}"
                                            class="form-control @error('hasil_panen') is-invalid @enderror">
                                        @error('hasil_panen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="awal_tanam">Awal Tanam</label>
                                        <input type="date" id="awal_tanam" name="awal_tanam"
                                            value="{{ $lahan->awal_tanam }}"
                                            class="form-control @error('awal_tanam') is-invalid @enderror">
                                        @error('awal_tanam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="akhir_tanam">Akhir Tanam</label>
                                        <input type="date" id="akhir_tanam" name="akhir_tanam"
                                            value="{{ $lahan->akhir_tanam }}"
                                            class="form-control @error('akhir_tanam') is-invalid @enderror">
                                        @error('akhir_tanam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="gambarModal" tabindex="-1" aria-labelledby="gambarModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="gambarModalLabel">Gambar Saat Ini</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if ($lahan->gambar)
                                        <img src="{{ asset('storage/uploads/' . $lahan->gambar) }}" alt="Gambar Lahan"
                                            style="width: 100%;">
                                    @else
                                        <p>Tidak ada gambar yang tersedia.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .leaflet-container {
            z-index: 1;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="{{ asset('geojson/leaflet.ajax.js') }}"></script>
    <script>
        var map = L.map('map').setView([-6.933758333939422, 106.96270033569287], 16);

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

        function popUp(f, l) {
            var out = [];
            if (f.properties) {
                for (key in f.properties) {
                    out.push(key + ": " + f.properties[key]);
                }
                l.bindPopup(out.join("<br />"));
            }

            // Tambahkan event listener untuk klik pada polygon
            l.on('click', function() {
                // Mengisi field form dengan data dari geojson
                document.getElementById('luas_lahan').value = f.properties.LUASPETA;
                document.getElementById('pemilik_lahan').value = f.properties.Pemilik;

                // Format koordinat multipolygon untuk denah lahan
                document.getElementById('denah_lahan').value = JSON.stringify(f.geometry.coordinates);
            });
        }

        // Tambahkan layer untuk seluruh data GeoJSON dengan gaya default
        var jsonTest = new L.GeoJSON.AJAX(["{{ asset('geojson/data2.geojson') }}"], {
            onEachFeature: popUp,
            style: function(feature) {
                return {
                    color: 'blue',
                    weight: 2,
                    opacity: 0.5
                }; // Gaya default untuk seluruh data GeoJSON
            }
        }).addTo(map);

        // Tambahkan layer untuk koordinat saat ini dengan warna berbeda dan transparansi
        @if ($lahan->denah_lahan)
            var currentLahan = {
                "type": "Feature",
                "geometry": {
                    "type": "MultiPolygon",
                    "coordinates": {!! $lahan->denah_lahan !!}
                },
                "properties": {
                    "name": "Koordinat Saat Ini"
                }
            };
            L.geoJSON(currentLahan, {
                style: function() {
                    return {
                        color: 'red', // Warna untuk geometri saat ini
                        weight: 3, // Ketebalan border
                        opacity: 0.7, // Transparansi border
                        fillOpacity: 0.2 // Transparansi isi
                    };
                }
            }).addTo(map);
        @endif
    </script>
@endpush
