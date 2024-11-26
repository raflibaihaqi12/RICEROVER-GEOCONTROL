@extends('layout.master')

@section('title')
    DASHBOARD
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Profile Statistics</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon purple">
                                            <i class="iconly-boldHome"></i> <!-- Ikon untuk Total Lahan Terdaftar -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Lahan Terdaftar</h6>
                                        <h6 class="font-extrabold mb-0">{{ $total_lahan }}</h6>
                                        <!-- Ganti dengan data dinamis -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldTick-Square"></i> <!-- Ikon untuk Alokasi Terealisasi -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Alokasi Terealisasi</h6>
                                        <h6 class="font-extrabold mb-0">{{ $alokasi }}</h6>
                                        <!-- Ganti dengan data dinamis -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="iconly-boldUser1"></i> <!-- Ikon untuk Jumlah Penggarap -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Jumlah Penggarap</h6>
                                        <h6 class="font-extrabold mb-0">{{ $penggarap }}</h6>
                                        <!-- Ganti dengan data dinamis -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldCalendar"></i> <!-- Ikon untuk Lahan Selesai Masa Panen -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Lahan Selesai Masa Panen</h6>
                                        <h6 class="font-extrabold mb-0">{{ $lahan_selesai }}</h6>
                                        <!-- Ganti dengan data dinamis -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-5">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                @if (Auth::user()->avatar != '')
                                    <img src="{{ asset('storage/uploads/' . Auth::user()->avatar) }}" alt="Face 1">
                                @else
                                    <img src="{{ asset('assets/images/faces/1.jpg') }}" alt="Face 1">
                                @endif
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                                <h6 class="text-muted mb-0">{{ '@' . Auth::user()->username }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lokasi Lahan</h5>
                        <div id="map" style="height: 500px;"></div> <!-- Ukuran peta ditentukan oleh height -->
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/leaflet/leaflet.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendors/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('geojson/leaflet.ajax.js') }}"></script>
    <script>
        // Leaflet Map
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
        }
        var jsonTest = new L.GeoJSON.AJAX(["{{ asset('geojson/data2.geojson') }}"], {
            onEachFeature: popUp
        }).addTo(map);


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
