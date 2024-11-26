<?php

namespace App\Http\Controllers;

use App\Models\AlokasiPupuk;
use App\Models\Lahan;
use App\Models\ListPupuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlokasiController extends Controller
{
    public function store(Request $request, $id)
    {
        // Validasi input form
        $request->validate([
            'nama_penanggung_jawab' => 'required|string|max:255',

            'jenis_pupuk_padi' => 'nullable|array',
            'jenis_pupuk_padi.*' => 'nullable|string|max:255',
            'jumlah_pupuk_padi' => 'nullable|array',
            'jumlah_pupuk_padi.*' => 'nullable|numeric',
            'harga_pupuk_padi' => 'nullable|array',
            'harga_pupuk_padi.*' => 'nullable|integer',

            'jenis_pupuk_jagung' => 'nullable|array',
            'jenis_pupuk_jagung.*' => 'nullable|string|max:255',
            'jumlah_pupuk_jagung' => 'nullable|array',
            'jumlah_pupuk_jagung.*' => 'nullable|numeric',
            'harga_pupuk_jagung' => 'nullable|array',
            'harga_pupuk_jagung.*' => 'nullable|integer',

            'jenis_pupuk_cabai' => 'nullable|array',
            'jenis_pupuk_cabai.*' => 'nullable|string|max:255',
            'jumlah_pupuk_cabai' => 'nullable|array',
            'jumlah_pupuk_cabai.*' => 'nullable|numeric',
            'harga_pupuk_cabai' => 'nullable|array',
            'harga_pupuk_cabai.*' => 'nullable|integer',

            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ttd' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [], [
            'after' => function ($validator) use ($request) {
                if (empty($request->jenis_pupuk_padi) && empty($request->jenis_pupuk_jagung) && empty($request->jenis_pupuk_cabai)) {
                    $validator->errors()->add('jenis_pupuk', 'Setidaknya salah satu jenis pupuk harus diisi.');
                }
            }
        ]);


        // Simpan foto bukti distribusi dengan nama UUID
        if ($request->hasFile('foto_bukti')) {
            $fotoBukti = $request->file('foto_bukti');
            $fotoBuktiName = Str::uuid() . '.' . $fotoBukti->getClientOriginalExtension();
            $fotoBukti->storeAs('uploads', $fotoBuktiName, 'public');
        }

        // Simpan foto tanda tangan dengan nama UUID
        if ($request->hasFile('foto_ttd')) {
            $fotoTTD = $request->file('foto_ttd');
            $fotoTTDName = Str::uuid() . '.' . $fotoTTD->getClientOriginalExtension();
            $fotoTTD->storeAs('uploads', $fotoTTDName, 'public');
        }

        $lahan = Lahan::where('denah_lahan', $id)->where('status', 'berjalan')->get();

        foreach ($lahan as $item) {
            if ($item->isi_lahan == 'padi' && $request->filled('jenis_pupuk_padi')) {

                // Simpan data alokasi pupuk
                // Filter array untuk menghapus entri kosong
                $validPupuk = array_filter($request->jenis_pupuk_padi, function ($jenis, $index) use ($request) {
                    return !empty($jenis) && !empty($request->jumlah_pupuk_padi[$index]) && !empty($request->harga_pupuk_padi[$index]);
                }, ARRAY_FILTER_USE_BOTH);

                // Hanya simpan alokasi pupuk jika ada pupuk yang valid
                if (!empty($validPupuk)) {
                    // Simpan data alokasi pupuk
                    $alokasiPupuk = new AlokasiPupuk();
                    $alokasiPupuk->nama_penanggung_jawab = $request->nama_penanggung_jawab;
                    $alokasiPupuk->jabatan_penanggung_jawab = $request->jabatan_penanggung_jawab;

                    $musim_ke = AlokasiPupuk::where('lahan_id', $item->id)->count();
                    $alokasiPupuk->musim_tanam = $musim_ke + 1;
                    $alokasiPupuk->foto_bukti_distribusi = $fotoBuktiName;
                    $alokasiPupuk->foto_tanda_tangan = $fotoTTDName;
                    $alokasiPupuk->lahan_id = $item->id;
                    $alokasiPupuk->save();

                    // Simpan data list pupuk ke dalam tabel `list_pupuk`
                    foreach ($validPupuk as $index => $jenis) {
                        $listPupuk = new ListPupuk();
                        $listPupuk->jenis_pupuk = $jenis;
                        $listPupuk->jumlah_alokasi = $request->jumlah_pupuk_padi[$index];
                        $listPupuk->harga_pupuk = $request->harga_pupuk_padi[$index];
                        $listPupuk->total_nilai_subsidi = $request->jumlah_pupuk_padi[$index] * $request->harga_pupuk_padi[$index];
                        $listPupuk->alokasi_id = $alokasiPupuk->id;
                        $listPupuk->save();
                    }
                }
            } else if ($item->isi_lahan == 'jagung' &&  $request->filled('jenis_pupuk_jagung')) {

                // Filter array untuk menghapus entri kosong
                $validPupuk = array_filter($request->jenis_pupuk_jagung, function ($jenis, $index) use ($request) {
                    return !empty($jenis) && !empty($request->jumlah_pupuk_jagung[$index]) && !empty($request->harga_pupuk_jagung[$index]);
                }, ARRAY_FILTER_USE_BOTH);

                // Hanya simpan alokasi pupuk jika ada pupuk yang valid
                if (!empty($validPupuk)) {
                    // Simpan data alokasi pupuk
                    $alokasiPupuk = new AlokasiPupuk();
                    $alokasiPupuk->nama_penanggung_jawab = $request->nama_penanggung_jawab;
                    $alokasiPupuk->jabatan_penanggung_jawab = $request->jabatan_penanggung_jawab;

                    $musim_ke = AlokasiPupuk::where('lahan_id', $item->id)->count();
                    $alokasiPupuk->musim_tanam = $musim_ke + 1;
                    $alokasiPupuk->foto_bukti_distribusi = $fotoBuktiName;
                    $alokasiPupuk->foto_tanda_tangan = $fotoTTDName;
                    $alokasiPupuk->lahan_id = $item->id;
                    $alokasiPupuk->save();

                    // Simpan data list pupuk ke dalam tabel `list_pupuk`
                    foreach ($validPupuk as $index => $jenis) {
                        $listPupuk = new ListPupuk();
                        $listPupuk->jenis_pupuk = $jenis; // Akses jenis pupuk dari validPupuk
                        $listPupuk->jumlah_alokasi = $request->jumlah_pupuk_jagung[$index]; // Akses jumlah pupuk dari array request
                        $listPupuk->harga_pupuk = $request->harga_pupuk_jagung[$index]; // Akses harga pupuk dari array request
                        $listPupuk->total_nilai_subsidi = $request->jumlah_pupuk_jagung[$index] * $request->harga_pupuk_jagung[$index];
                        $listPupuk->alokasi_id = $alokasiPupuk->id;
                        $listPupuk->save();
                    }
                }
            } else if ($item->isi_lahan == 'cabai' &&  $request->filled('jenis_pupuk_cabai')) {
                // Simpan data alokasi pupuk
                // Filter array untuk menghapus entri kosong
                $validPupuk = array_filter($request->jenis_pupuk_cabai, function ($jenis, $index) use ($request) {
                    return !empty($jenis) && !empty($request->jumlah_pupuk_cabai[$index]) && !empty($request->harga_pupuk_cabai[$index]);
                }, ARRAY_FILTER_USE_BOTH);

                // Hanya simpan alokasi pupuk jika ada pupuk yang valid
                if (!empty($validPupuk)) {
                    // Simpan data alokasi pupuk
                    $alokasiPupuk = new AlokasiPupuk();
                    $alokasiPupuk->nama_penanggung_jawab = $request->nama_penanggung_jawab;
                    $alokasiPupuk->jabatan_penanggung_jawab = $request->jabatan_penanggung_jawab;

                    $musim_ke = AlokasiPupuk::where('lahan_id', $item->id)->count();
                    $alokasiPupuk->musim_tanam = $musim_ke + 1;
                    $alokasiPupuk->foto_bukti_distribusi = $fotoBuktiName;
                    $alokasiPupuk->foto_tanda_tangan = $fotoTTDName;
                    $alokasiPupuk->lahan_id = $item->id;
                    $alokasiPupuk->save();

                    // Simpan data list pupuk ke dalam tabel `list_pupuk`
                    foreach ($validPupuk as $index => $jenis) {
                        $listPupuk = new ListPupuk();
                        $listPupuk->jenis_pupuk = $jenis;
                        $listPupuk->jumlah_alokasi = $request->jumlah_pupuk_cabai[$index];
                        $listPupuk->harga_pupuk = $request->harga_pupuk_cabai[$index];
                        $listPupuk->total_nilai_subsidi = $request->jumlah_pupuk_cabai[$index] * $request->harga_pupuk_cabai[$index];
                        $listPupuk->alokasi_id = $alokasiPupuk->id;
                        $listPupuk->save();
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Alokasi pupuk berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_penanggung_jawab' => 'required|string|max:255',
            'musim_tanam' => 'required|integer',
            'jenis_pupuk' => 'required|string|max:255',
            'jumlah_pupuk' => 'required|numeric',
            'harga_pupuk' => 'required|numeric',
            'total_nilai_subsidi' => 'required|numeric',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Ambil data alokasi yang akan diupdate
        $alokasi = AlokasiPupuk::findOrFail($id);

        // Update data alokasi
        $alokasi->nama_penanggung_jawab = $request->input('nama_penanggung_jawab');
        $alokasi->musim_tanam = $request->input('musim_tanam');
        $alokasi->jenis_pupuk = $request->input('jenis_pupuk');
        $alokasi->jumlah_pupuk = $request->input('jumlah_pupuk');
        $alokasi->harga_pupuk = $request->input('harga_pupuk');
        $alokasi->total_nilai_subsidi = $request->input('total_nilai_subsidi');

        // Proses upload dan update file foto bukti distribusi
        if ($request->hasFile('foto_bukti')) {
            // Hapus file lama jika ada
            if ($alokasi->foto_bukti_distribusi && Storage::disk('public')->exists('uploads/' . $alokasi->foto_bukti_distribusi)) {
                Storage::disk('public')->delete('uploads/' . $alokasi->foto_bukti_distribusi);
            }

            // Simpan file baru dengan UUID
            $fotoBukti = $request->file('foto_bukti');
            $fotoBuktiName = Str::uuid() . '.' . $fotoBukti->getClientOriginalExtension();
            $fotoBukti->storeAs('uploads', $fotoBuktiName, 'public');
            $alokasi->foto_bukti_distribusi = $fotoBuktiName;
        }

        // Proses upload dan update file foto tanda tangan
        if ($request->hasFile('foto_ttd')) {
            // Hapus file lama jika ada
            if ($alokasi->foto_tanda_tangan && Storage::disk('public')->exists('uploads/' . $alokasi->foto_tanda_tangan)) {
                Storage::disk('public')->delete('uploads/' . $alokasi->foto_tanda_tangan);
            }

            // Simpan file baru dengan UUID
            $fotoTtd = $request->file('foto_ttd');
            $fotoTtdName = Str::uuid() . '.' . $fotoTtd->getClientOriginalExtension();
            $fotoTtd->storeAs('uploads', $fotoTtdName, 'public');
            $alokasi->foto_tanda_tangan = $fotoTtdName;
        }

        // Simpan perubahan pada alokasi
        $alokasi->save();

        // Redirect atau kembalikan respons sesuai kebutuhan
        return redirect()->back()->with('success', 'Data alokasi pupuk berhasil diperbarui.');
    }
}
