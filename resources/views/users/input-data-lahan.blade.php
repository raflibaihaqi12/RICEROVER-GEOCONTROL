@extends('layout.master')

@section('title')
    INPUT DATA LAHAN
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Form Tambah Lahan</h3>
    </div>
    <div class="page-content">
        <div class="row">
            <!-- Form Input -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Input Data Lahan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="map" style="width: 600px; height: 400px;"></div>
                            </div>
                            <div class="col-md-6">
                                <form action="/submit-data-lahan" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nama_kelompok_tani">Nama Petani</label>
                                        <input type="text" id="nama_kelompok_tani" name="nama_kelompok_tani"
                                            value="{{ Auth::user()->nama_kelompok_tani }}" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nomor_kartu_tani">Nomor Kartu Tani (Jika Ada)</label>
                                        <input type="number" id="nomor_kartu_tani" name="nomor_kartu_tani"
                                            value="{{ Auth::user()->nomor_kartu_tani }}" class="form-control" readonly>
                                        @error('nomor_kartu_tani')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lahan">Nama Lahan</label>
                                        <input type="text" id="nama_lahan" name="nama_lahan"
                                            value="{{ old('nama_lahan') }}"
                                            class="form-control @error('nama_lahan') is-invalid @enderror"
                                            placeholder="Beri Sesuai Dengan Tanaman Yang Di Tanami *contoh: Lahan Padi">
                                        @error('nama_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="luas_lahan">Luas Lahan (M2)</label>
                                        <input type="text" id="luas_lahan" name="luas_lahan"
                                            value="{{ old('luas_lahan') }}"
                                            class="form-control @error('luas_lahan') is-invalid @enderror"
                                            oninput="validateInput(this)" readonly>
                                        @error('luas_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="luas_tanam">Luas Tanam (M2)</label>
                                        <input type="text" id="luas_tanam" name="luas_tanam"
                                            value="{{ old('luas_tanam') }}"
                                            class="form-control @error('luas_tanam') is-invalid @enderror">
                                        @error('luas_tanam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="isi_lahan">Isi Lahan</label>
                                        <select id="isi_lahan" name="isi_lahan"
                                            class="form-control @error('isi_lahan') is-invalid @enderror">
                                            <option {{ old('isi_lahan') == null ? 'selected' : '' }} disabled>Pilih Isi
                                                Lahan</option>
                                            <option value="padi" {{ old('isi_lahan') == 'padi' ? 'selected' : '' }}>Padi
                                            </option>
                                            <option value="jagung" {{ old('isi_lahan') == 'jagung' ? 'selected' : '' }}>
                                                Jagung</option>
                                            <option value="cabai" {{ old('isi_lahan') == 'cabai' ? 'selected' : '' }}>
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
                                            class="form-control @error('pemilik_lahan') is-invalid @enderror"
                                            autocomplete="off">
                                        <div id="autocomplete-list" class="autocomplete-items"></div>
                                        @error('pemilik_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat_lahan">Alamat Lahan</label>
                                        <textarea id="alamat_lahan" name="alamat_lahan" class="form-control @error('alamat_lahan') is-invalid @enderror">{{ old('alamat_lahan') }}</textarea>
                                        @error('alamat_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="denah_lahan">Denah Lahan</label>
                                        <input type="text" id="denah_lahan" name="denah_lahan"
                                            value="{{ old('denah_lahan') }}"
                                            class="form-control @error('denah_lahan') is-invalid @enderror"
                                            placeholder="Klik Di Peta / Pilih Lokasi Saat Ini" readonly>
                                        @error('denah_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar">Gambar</label>
                                        <input type="file" id="gambar" name="gambar"
                                            class="form-control @error('gambar') is-invalid @enderror">
                                        @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="hasil_panen">Total Hasil Panen (Kg)</label>
                                        <input type="number" id="hasil_panen" name="hasil_panen"
                                            value="{{ old('hasil_panen') }}"
                                            class="form-control @error('hasil_panen') is-invalid @enderror">
                                        @error('hasil_panen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="awal_tanam">Awal Tanam</label>
                                        <input type="date" id="awal_tanam" name="awal_tanam"
                                            value="{{ old('awal_tanam') }}"
                                            class="form-control @error('awal_tanam') is-invalid @enderror">
                                        @error('awal_tanam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="akhir_tanam">Akhir Tanam</label>
                                        <input type="date" id="akhir_tanam" name="akhir_tanam"
                                            value="{{ old('akhir_tanam') }}"
                                            class="form-control @error('akhir_tanam') is-invalid @enderror">
                                        @error('akhir_tanam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .leaflet-container {
            z-index: 1;
            max-width: 100%;
            max-height: 100%;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #ddd;
            border-top: none;
            z-index: 99;
            background-color: #fff;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
        }

        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            background-color: #e9e9e9;
            color: #000;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="{{ asset('geojson/leaflet.ajax.js') }}"></script>
    <script>
        function validateInput(input) {
            // Hanya izinkan angka, koma, dan satu titik koma
            input.value = input.value.replace(/[^0-9,]/g, '');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('pemilik_lahan');
            const autocompleteList = document.getElementById('autocomplete-list');

            // Sample data (replace this with actual data from your backend)
            const names = @json($nama_pemilik);

            input.addEventListener('input', function() {
                const query = this.value;
                autocompleteList.innerHTML = ''; // Clear previous suggestions
                if (query) {
                    const filteredNames = names.filter(name => name.toLowerCase().includes(query
                        .toLowerCase()));
                    filteredNames.forEach(name => {
                        const item = document.createElement('div');
                        item.innerHTML = name;
                        item.addEventListener('click', () => {
                            input.value = name;
                            autocompleteList.innerHTML =
                                ''; // Clear suggestions after selection
                        });
                        autocompleteList.appendChild(item);
                    });
                }
            });

            // Close the autocomplete list if the user clicks outside of it
            document.addEventListener('click', function(e) {
                if (e.target !== input) {
                    autocompleteList.innerHTML = '';
                }
            });

            // Allow manual input if the name is not in the list
            input.addEventListener('blur', function() {
                if (!names.includes(this.value)) {
                    // Optional: Add logic to handle new input, e.g., save to database
                    console.log('New name input: ', this.value);
                }
            });
        });
    </script>
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

        var jsonTest = new L.GeoJSON.AJAX(["{{ asset('geojson/data2.geojson') }}"], {
            onEachFeature: popUp
        }).addTo(map);

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
