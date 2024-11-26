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
                        <p><strong>Penggarap Lahan:</strong>
                            @php
                                $penggarap = []; // Array untuk menyimpan nama yang sudah ditampilkan

                                // Mengumpulkan nama unik
                                foreach ($lahan as $item) {
                                    if (!in_array($item->user->name, $penggarap)) {
                                        $penggarap[] = $item->user->name;
                                    }
                                }

                                // Tampilkan nama-nama unik dan tambahkan koma jika lebih dari satu
                                $totalNames = count($penggarap);

                                foreach ($penggarap as $index => $name) {
                                    echo $name;

                                    // Tampilkan koma jika bukan item terakhir
                                    if ($index < $totalNames - 1) {
                                        echo ', ';
                                    }
                                }
                            @endphp
                        <p><strong>Nama Lahan:</strong>
                            @php
                                foreach ($lahan as $no => $item) {
                                    echo $item->nama_lahan;
                                    if (isset($lahan[$no + 1])) {
                                        echo ', ';
                                    }
                                }
                            @endphp</p>
                        <p><strong>Luas Lahan:</strong> {{ $lahan[0]->luas_lahan }} M&sup2;</p>
                        @php
                            $luas_tanam = 0;
                            foreach ($lahan as $item) {
                                $luas_tanam += $item->luas_tanam;
                            }
                        @endphp
                        <p><strong>Luas Tanam:</strong> {{ $luas_tanam }} M&sup2;</p>
                        <p><strong>Isi Lahan:</strong>
                            @php
                                foreach ($lahan as $no => $item) {
                                    echo ucwords($item->isi_lahan . '(' . $item->luas_tanam . ' M²)');
                                    if (isset($lahan[$no + 1])) {
                                        echo ', ';
                                    }
                                }
                            @endphp</p>
                        <p><strong>Pemilik Lahan:</strong>
                            @php
                                $pemilik = []; // Array untuk menyimpan nama yang sudah ditampilkan

                                // Mengumpulkan nama unik
                                foreach ($lahan as $item) {
                                    if (!in_array($item->pemilik_lahan, $pemilik)) {
                                        $pemilik[] = $item->pemilik_lahan;
                                    }
                                }

                                // Tampilkan nama-nama unik dan tambahkan koma jika lebih dari satu
                                $totalNames = count($pemilik);

                                foreach ($pemilik as $index => $name) {
                                    echo $name;

                                    // Tampilkan koma jika bukan item terakhir
                                    if ($index < $totalNames - 1) {
                                        echo ', ';
                                    }
                                }
                            @endphp</p>
                        <p><strong>Alamat Lahan:</strong> {{ $lahan[0]->alamat_lahan }}</p>
                        <p><strong>Hasil Panen:</strong>
                            @php
                                foreach ($lahan as $no => $item) {
                                    echo $item->hasil_panen . 'Kg (' . ucwords($item->isi_lahan) . ')';
                                    if (isset($lahan[$no + 1])) {
                                        echo ', ';
                                    }
                                }
                            @endphp</p>
                        <p><strong>Awal Tanam:</strong>
                            @php
                                foreach ($lahan as $no => $item) {
                                    echo $item->awal_tanam . ' (' . ucwords($item->isi_lahan) . ')';
                                    if (isset($lahan[$no + 1])) {
                                        echo ', ';
                                    }
                                }
                            @endphp</p>
                        <p><strong>Akhir Tanam:</strong>
                            @php
                                foreach ($lahan as $no => $item) {
                                    echo $item->akhir_tanam . ' (' . ucwords($item->isi_lahan) . ')';
                                    if (isset($lahan[$no + 1])) {
                                        echo ', ';
                                    }
                                }
                            @endphp</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Gambar Lahan:</strong></p>
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($lahan as $index => $item)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('/storage/uploads/' . $item->gambar) }}" class="d-block w-100"
                                            alt="Gambar Lahan">
                                    </div>
                                @endforeach
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
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                    data-bs-target="#tambahAlokasiModal">
                    Tambah Alokasi Pupuk
                </button>
                <h4>List Alokasi Pupuk</h4>
                <!-- Button untuk memanggil modal -->
            </div>
            <div class="card-body">
                @foreach ($lahan as $no => $item)
                    <center><strong>Table Alokasi Pupuk {{ ucwords($item->isi_lahan) }}</strong></center>
                    <div class="mt-3">
                        <table class="table table-striped" id="table{{ $no + 1 }}">
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
                                @foreach ($item->alokasi_pupuk as $index => $alokasi)
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
                @endforeach
            </div>
        </div>
        @foreach ($lahan as $item)
            @foreach ($item->alokasi_pupuk as $index => $alokasi)
                <!-- Modal Detail -->
                <div class="modal fade" id="detailModal{{ $alokasi->id }}" tabindex="-1"
                    aria-labelledby="detailModalLabel{{ $alokasi->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel{{ $alokasi->id }}">Detail Alokasi Pupuk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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
                                <img src="{{ Storage::url('uploads/' . $alokasi->foto_tanda_tangan) }}"
                                    alt="Foto Tanda Tangan" class="img-fluid mb-3">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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

    <!-- Modal Tambah Alokasi Pupuk -->
    <div class="modal fade" id="tambahAlokasiModal" tabindex="-1" aria-labelledby="tambahAlokasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="/alokasi-pupuk/store/{{ $id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahAlokasiModalLabel">Tambah Alokasi Pupuk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="penanggung_jawab" class="form-label">Nama Penanggung Jawab</label>
                            <input type="text" class="form-control" id="penanggung_jawab"
                                name="nama_penanggung_jawab" required>
                            <div id="autocomplete-list" class="autocomplete-items"></div>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan_penanggung_jawab" class="form-label">Jabatan Penanggung Jawab</label>
                            <select class="form-control" id="jabatan_penanggung_jawab" name="jabatan_penanggung_jawab"
                                required>
                                <option selected disabled>- Pilih Jabatan -</option>
                                <option value="Staff Pemerintahan">Staff Pemerintahan</option>
                                <option value="Kelompok Tani">Kelompok Tani</option>
                                <option value="Penanggung Jawab Lapangan">Penanggung Jawab Lapangan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="foto_bukti" class="form-label">Foto Bukti Distribusi</label>
                            <input type="file" class="form-control" id="foto_bukti" name="foto_bukti" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto_ttd" class="form-label">Foto Tanda Tangan</label>
                            <input type="file" class="form-control" id="foto_ttd" name="foto_ttd" required>
                        </div>

                        @php
                            $tanaman = []; // Array untuk menyimpan nama yang sudah ditampilkan
                            // Mengumpulkan nama unik
                            foreach ($lahan as $item) {
                                $tanaman[] = $item->isi_lahan;
                            }
                        @endphp

                        @if (in_array('padi', $tanaman))
                            <div class="mb-3">
                                <label for="pupuk_alokasi" class="form-label">Alokasi Pupuk Padi</label>
                                <table class="table" id="pupuk-table-padi">
                                    <thead>
                                        <tr>
                                            <th>Jenis Pupuk</th>
                                            <th>Jumlah Pupuk (Kg)</th>
                                            <th>Harga Pupuk (Rp/Kg)</th>
                                            <th>Total Nilai Subsidi (Rp)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control jenis-pupuk-padi" name="jenis_pupuk_padi[]">
                                                    <option value="">Pilih Jenis Pupuk</option>
                                                    <option value="Urea">Urea</option>
                                                    <option value="NPK">NPK</option>
                                                    <option value="KCL">KCL</option>
                                                    <option value="SP36">SP36</option>
                                                    <option value="Poska">Poska</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control jumlah-pupuk-padi"
                                                    name="jumlah_pupuk_padi[]" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control harga-pupuk-padi"
                                                    name="harga_pupuk_padi[]" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control total-nilai-subsidi-padi"
                                                    name="total_nilai_subsidi_padi[]" readonly>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger remove-row-padi">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" id="add-row-padi">Tambah Baris</button>
                            </div>
                        @endif

                        @if (in_array('jagung', $tanaman))
                            <div class="mb-3">
                                <label for="pupuk_alokasi" class="form-label">Alokasi Pupuk Jagung</label>
                                <table class="table" id="pupuk-table-jagung">
                                    <thead>
                                        <tr>
                                            <th>Jenis Pupuk</th>
                                            <th>Jumlah Pupuk (Kg)</th>
                                            <th>Harga Pupuk (Rp/Kg)</th>
                                            <th>Total Nilai Subsidi (Rp)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control jenis-pupuk-jagung"
                                                    name="jenis_pupuk_jagung[]">
                                                    <option value="">Pilih Jenis Pupuk</option>
                                                    <option value="Urea">Urea</option>
                                                    <option value="NPK">NPK</option>
                                                    <option value="KCL">KCL</option>
                                                    <option value="SP36">SP36</option>
                                                    <option value="Poska">Poska</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control jumlah-pupuk-jagung"
                                                    name="jumlah_pupuk_jagung[]" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control harga-pupuk-jagung"
                                                    name="harga_pupuk_jagung[]" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control total-nilai-subsidi-jagung"
                                                    name="total_nilai_subsidi_jagung[]" readonly>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger remove-row-jagung">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" id="add-row-jagung">Tambah Baris</button>
                            </div>
                        @endif
                        @if (in_array('cabai', $tanaman))
                            <div class="mb-3">
                                <label for="pupuk_alokasi" class="form-label">Alokasi Pupuk Cabai</label>
                                <table class="table" id="pupuk-table-cabai">
                                    <thead>
                                        <tr>
                                            <th>Jenis Pupuk</th>
                                            <th>Jumlah Pupuk (Kg)</th>
                                            <th>Harga Pupuk (Rp/Kg)</th>
                                            <th>Total Nilai Subsidi (Rp)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control jenis-pupuk-cabai" name="jenis_pupuk_cabai[]">
                                                    <option value="">Pilih Jenis Pupuk</option>
                                                    <option value="Urea">Urea</option>
                                                    <option value="NPK">NPK</option>
                                                    <option value="KCL">KCL</option>
                                                    <option value="SP36">SP36</option>
                                                    <option value="Poska">Poska</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control jumlah-pupuk-cabai"
                                                    name="jumlah_pupuk_cabai[]" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control harga-pupuk-cabai"
                                                    name="harga_pupuk_cabai[]" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control total-nilai-subsidi-cabai"
                                                    name="total_nilai_subsidi_cabai[]" readonly>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger remove-row-cabai">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" id="add-row-cabai">Tambah Baris</button>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendors/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('geojson/leaflet.ajax.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('penanggung_jawab');
            const autocompleteList = document.getElementById('autocomplete-list');

            // Sample data (replace this with actual data from your backend)
            const names = @json($nama_penanggung_jawab);

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

        // Simple Datatable
        let table1 = document.querySelector('#table1');
        if (table1) {
            let dataTable1 = new simpleDatatables.DataTable(table1);
        }

        let table2 = document.querySelector('#table2');
        if (table2) {
            let dataTable2 = new simpleDatatables.DataTable(table2);
        }

        let table3 = document.querySelector('#table3');
        if (table3) {
            let dataTable3 = new simpleDatatables.DataTable(table3);
        }


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
        // Array to store all bounds
        var allBounds = [];

        // Object to store grouped lahan by coordinates
        var groupedLahans = {};

        // Loop through lahan data and group by coordinates
        @foreach ($lahan as $item)
            @if ($item->denah_lahan && $item->status == 'berjalan')
                var coordinates = {!! $item->denah_lahan !!};
                var key = JSON.stringify(coordinates); // Use coordinates as the key

                // Group lahan by coordinates
                if (!groupedLahans[key]) {
                    groupedLahans[key] = [];
                }

                groupedLahans[key].push({
                    "nama_lahan": "{{ $item->nama_lahan }}",
                    "nama_kelompok_tani": "{{ $item->nama_kelompok_tani }}",
                    "nomor_kartu_tani": "{{ $item->nomor_kartu_tani ? $item->nomor_kartu_tani : '-' }}",
                    "luas_lahan": "{{ $item->luas_lahan }}",
                    "luas_tanam": "{{ $item->luas_tanam }}",
                    "isi_lahan": "{{ $item->isi_lahan }}",
                    "pemilik_lahan": "{{ $item->pemilik_lahan }}",
                    "alamat_lahan": "{{ $item->alamat_lahan }}",
                    "hasil_panen": "{{ $item->hasil_panen }}",
                    "awal_tanam": "{{ $item->awal_tanam }}",
                    "akhir_tanam": "{{ $item->akhir_tanam }}",
                    "gambar": "{{ asset('/storage/uploads/' . $item->gambar) }}"
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
                <div id="test" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        ${carouselItems}
                    </div>
                    <a class="carousel-control-prev" href="#test" role="button"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#test" role="button"
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

        // // Menggunakan class atau attribute selector untuk mengikat event listener ke elemen input
        // document.querySelectorAll('.jumlah-pupuk, .harga-pupuk').forEach(function(input) {
        //     input.addEventListener('input', calculateTotalSubsidi);
        // });

        // function calculateTotalSubsidi() {
        //     // Mendapatkan elemen input terkait dari elemen yang sedang diubah
        //     const form = this.closest('form');
        //     let jumlah = parseFloat(form.querySelector('.jumlah-pupuk').value) || 0;
        //     let harga = parseFloat(form.querySelector('.harga-pupuk').value) || 0;
        //     let total = jumlah * harga;
        //     form.querySelector('.total-nilai-subsidi').value = total;
        // }

        // document.getElementById('jumlah_pupuk').addEventListener('input', calculateTotalSubsidi2);
        // document.getElementById('harga_pupuk').addEventListener('input', calculateTotalSubsidi2);

        // function calculateTotalSubsidi2() {
        //     let jumlah = parseFloat(document.getElementById('jumlah_pupuk').value) || 0;
        //     let harga = parseFloat(document.getElementById('harga_pupuk').value) || 0;
        //     let total = jumlah * harga;
        //     document.getElementById('total_nilai_subsidi').value = total;
        // }


        // function setupUpdateFormListeners(alokasiId) {
        //     const jumlahInput = document.getElementById(`jumlah_pupuk${alokasiId}`);
        //     const hargaInput = document.getElementById(`harga_pupuk${alokasiId}`);
        //     const totalInput = document.getElementById(`total_nilai_subsidi${alokasiId}`);

        //     function calculateTotalSubsidi() {
        //         let jumlah = parseFloat(jumlahInput.value) || 0;
        //         let harga = parseFloat(hargaInput.value) || 0;
        //         let total = jumlah * harga;
        //         totalInput.value = total;
        //     }

        //     jumlahInput.addEventListener('input', calculateTotalSubsidi);
        //     hargaInput.addEventListener('input', calculateTotalSubsidi);
        // }
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
                    'Urea': 0.025,
                    'NPK': 0.03,
                    'KCL': 0.0075,
                    'SP36': 0.015,
                    'Poska': 0.025
                },
                'cabai': {
                    'Urea': 0.02,
                    'NPK': 0.03,
                    'KCL': 0.01,
                    'SP36': 0.015,
                    'Poska': 0
                },
                'jagung': {
                    'Urea': 0.03,
                    'NPK': 0.02,
                    'KCL': 0.0075,
                    'SP36': 0.01,
                    'Poska': 0
                }
            };

            const hargaPupuk = {
                'Urea': 2250,
                'NPK': 2300,
                'KCL': 2300,
                'SP36': 2400,
                'Poska': 2300
            };
            @if (in_array('padi', $tanaman))
                //buat padi
                function updatePupukRowPadi(row) {
                    const jenisPupuk = row.querySelector('.jenis-pupuk-padi').value;
                    const jumlahPupuk = row.querySelector('.jumlah-pupuk-padi');
                    const hargaPupukField = row.querySelector('.harga-pupuk-padi');
                    const totalNilaiSubsidi = row.querySelector('.total-nilai-subsidi-padi');
                    const luasTanam = parseFloat('{{ $lahan[0]->luas_tanam }}');
                    const isiLahan = 'padi';

                    if (jenisPupuk && luasTanam && isiLahan) {
                        const pupukPerM2ForLahan = pupukPerM2[isiLahan] || {};
                        const jumlah = luasTanam * (pupukPerM2ForLahan[jenisPupuk] || 0);
                        jumlahPupuk.value = jumlah.toFixed(2);
                        hargaPupukField.value = hargaPupuk[jenisPupuk] || 0;
                        totalNilaiSubsidi.value = (jumlah * (hargaPupuk[jenisPupuk] || 0)).toFixed(2);
                    }
                }

                document.querySelector('#add-row-padi').addEventListener('click', function() {
                    const row = document.querySelector('#pupuk-table-padi tbody tr');
                    const clone = row.cloneNode(true);
                    row.parentNode.appendChild(clone);
                    clone.querySelector('.jenis-pupuk-padi').value = '';
                    clone.querySelector('.jumlah-pupuk-padi').value = '';
                    clone.querySelector('.harga-pupuk-padi').value = '';
                    clone.querySelector('.total-nilai-subsidi-padi').value = '';
                });

                document.querySelector('#pupuk-table-padi').addEventListener('change', function(e) {
                    if (e.target.matches('.jenis-pupuk-padi')) {
                        updatePupukRowPadi(e.target.closest('tr'));
                    }
                });

                document.querySelector('#pupuk-table-padi').addEventListener('click', function(e) {
                    if (e.target.matches('.remove-row-padi')) {
                        e.target.closest('tr').remove();
                    }
                });

                // Initial calculation
                updatePupukRowPadi(document.querySelector('#pupuk-table-padi tbody tr'));
            @endif

            @if (in_array('jagung', $tanaman))
                //buat jagung
                function updatePupukRowJagung(row) {
                    const jenisPupuk = row.querySelector('.jenis-pupuk-jagung').value;
                    const jumlahPupuk = row.querySelector('.jumlah-pupuk-jagung');
                    const hargaPupukField = row.querySelector('.harga-pupuk-jagung');
                    const totalNilaiSubsidi = row.querySelector('.total-nilai-subsidi-jagung');
                    const luasTanam = parseFloat('{{ $lahan[0]->luas_tanam }}');
                    const isiLahan = 'jagung';

                    if (jenisPupuk && luasTanam && isiLahan) {
                        const pupukPerM2ForLahan = pupukPerM2[isiLahan] || {};
                        const jumlah = luasTanam * (pupukPerM2ForLahan[jenisPupuk] || 0);
                        jumlahPupuk.value = jumlah.toFixed(2);
                        hargaPupukField.value = hargaPupuk[jenisPupuk] || 0;
                        totalNilaiSubsidi.value = (jumlah * (hargaPupuk[jenisPupuk] || 0)).toFixed(2);
                    }
                }

                document.querySelector('#add-row-jagung').addEventListener('click', function() {
                    const row = document.querySelector('#pupuk-table-jagung tbody tr');
                    const clone = row.cloneNode(true);
                    row.parentNode.appendChild(clone);
                    clone.querySelector('.jenis-pupuk-jagung').value = '';
                    clone.querySelector('.jumlah-pupuk-jagung').value = '';
                    clone.querySelector('.harga-pupuk-jagung').value = '';
                    clone.querySelector('.total-nilai-subsidi-jagung').value = '';
                });

                document.querySelector('#pupuk-table-jagung').addEventListener('change', function(e) {
                    if (e.target.matches('.jenis-pupuk-jagung')) {
                        updatePupukRowJagung(e.target.closest('tr'));
                    }
                });

                document.querySelector('#pupuk-table-jagung').addEventListener('click', function(e) {
                    if (e.target.matches('.remove-row-jagung')) {
                        e.target.closest('tr').remove();
                    }
                });

                // Initial calculation
                updatePupukRowJagung(document.querySelector('#pupuk-table-jagung tbody tr'));
            @endif

            @if (in_array('cabai', $tanaman))
                function updatePupukRowCabai(row) {
                    const jenisPupuk = row.querySelector('.jenis-pupuk-cabai').value;
                    const jumlahPupuk = row.querySelector('.jumlah-pupuk-cabai');
                    const hargaPupukField = row.querySelector('.harga-pupuk-cabai');
                    const totalNilaiSubsidi = row.querySelector('.total-nilai-subsidi-cabai');
                    const luasTanam = parseFloat('{{ $lahan[0]->luas_tanam }}');
                    const isiLahan = 'cabai';

                    if (jenisPupuk && luasTanam && isiLahan) {
                        const pupukPerM2ForLahan = pupukPerM2[isiLahan] || {};
                        const jumlah = luasTanam * (pupukPerM2ForLahan[jenisPupuk] || 0);
                        jumlahPupuk.value = jumlah.toFixed(2);
                        hargaPupukField.value = hargaPupuk[jenisPupuk] || 0;
                        totalNilaiSubsidi.value = (jumlah * (hargaPupuk[jenisPupuk] || 0)).toFixed(2);
                    }
                }

                document.querySelector('#add-row-cabai').addEventListener('click', function() {
                    const row = document.querySelector('#pupuk-table-cabai tbody tr');
                    const clone = row.cloneNode(true);
                    row.parentNode.appendChild(clone);
                    clone.querySelector('.jenis-pupuk-cabai').value = '';
                    clone.querySelector('.jumlah-pupuk-cabai').value = '';
                    clone.querySelector('.harga-pupuk-cabai').value = '';
                    clone.querySelector('.total-nilai-subsidi-cabai').value = '';
                });

                document.querySelector('#pupuk-table-cabai').addEventListener('change', function(e) {
                    if (e.target.matches('.jenis-pupuk-cabai')) {
                        updatePupukRowCabai(e.target.closest('tr'));
                    }
                });

                document.querySelector('#pupuk-table-cabai').addEventListener('click', function(e) {
                    if (e.target.matches('.remove-row-cabai')) {
                        e.target.closest('tr').remove();
                    }
                });

                // Initial calculation
                updatePupukRowCabai(document.querySelector('#pupuk-table-cabai tbody tr'));
            @endif
            //buat cabai
        });
    </script>
@endpush
