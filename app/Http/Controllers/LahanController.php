<?php

namespace App\Http\Controllers;

use App\Models\AlokasiPupuk;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LahanController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $lahans = Lahan::all();

            return view('admin.data-lahan', ['lahans' => $lahans]);
        } else {
            $lahans = Lahan::where('user_id', Auth::id())->get();

            return view('users.data-lahan', ['lahans' => $lahans]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok_tani' => 'required|string|max:255',
            'nomor_kartu_tani' => 'nullable|string|max:255',
            'nama_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'luas_tanam' => 'required|numeric',
            'isi_lahan' => 'required|string|max:255',
            'pemilik_lahan' => 'required|string|max:255',
            'alamat_lahan' => 'required|string|max:255',
            'denah_lahan' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hasil_panen' => 'required|numeric',
            'awal_tanam' => 'required|date',
            'akhir_tanam' => 'required|date|after_or_equal:awal_tanam',
        ]);

        $check_lahan = Lahan::where('denah_lahan', $request->denah_lahan)->where('isi_lahan', $request->isi_lahan)->count();
        if ($check_lahan != 0) {
            return redirect()->back()->with('error', 'Pada lahan ini, data untuk tanaman ' . $request->isi_lahan . ' sudah ada dan prosesnya belum selesai')->withInput();
        }

        $lahan = new Lahan();

        $lahan->nama_kelompok_tani = $request->nama_kelompok_tani;
        $lahan->nomor_kartu_tani = $request->nomor_kartu_tani;
        $lahan->nama_lahan = $request->nama_lahan;
        $lahan->luas_lahan = $request->luas_lahan;
        $lahan->luas_tanam = $request->luas_tanam;
        $lahan->isi_lahan = $request->isi_lahan;
        $lahan->pemilik_lahan = $request->pemilik_lahan;
        $lahan->alamat_lahan = $request->alamat_lahan;
        $lahan->denah_lahan = $request->denah_lahan;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
            $lahan->gambar = $filename;
        }
        $lahan->hasil_panen = $request->hasil_panen;
        $lahan->awal_tanam = $request->awal_tanam;
        $lahan->akhir_tanam = $request->akhir_tanam;
        $lahan->status = 'berjalan';
        $lahan->user_id = Auth::id();

        $lahan->save();

        return redirect('/user/data-lahan')->with('success', 'Data Lahan Berhasil Disimpan');
    }

    public function edit_lahan($id)
    {
        $lahan = Lahan::find($id);

        return view('users.update-data', ['lahan' => $lahan]);
    }

    public function update_status($id)
    {
        $lahan = Lahan::find($id);
        $lahan->status = 'selesai';
        $lahan->save();

        return redirect()->back()->with('success', 'Status Lahan Berhasil Diubah');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok_tani' => 'required|string|max:255',
            'nomor_kartu_tani' => 'nullable|string|max:255',
            'nama_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'isi_lahan' => 'required|string|max:255',
            'pemilik_lahan' => 'required|string|max:255',
            'alamat_lahan' => 'required|string|max:255',
            'denah_lahan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hasil_panen' => 'required|numeric',
            'awal_tanam' => 'required|date',
            'akhir_tanam' => 'required|date|after_or_equal:awal_tanam',
        ]);

        $lahan = Lahan::findOrFail($id);

        $lahan->nama_kelompok_tani = $request->nama_kelompok_tani;
        $lahan->nomor_kartu_tani = $request->nomor_kartu_tani;
        $lahan->nama_lahan = $request->nama_lahan;
        $lahan->luas_lahan = $request->luas_lahan;
        $lahan->isi_lahan = $request->isi_lahan;
        $lahan->pemilik_lahan = $request->pemilik_lahan;
        $lahan->alamat_lahan = $request->alamat_lahan;
        $lahan->denah_lahan = $request->denah_lahan;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($lahan->gambar) {
                Storage::disk('public')->delete('uploads/' . $lahan->gambar);
            }

            // Simpan gambar baru
            $file = $request->file('gambar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
            $lahan->gambar = $filename;
        }

        $lahan->hasil_panen = $request->hasil_panen;
        $lahan->awal_tanam = $request->awal_tanam;
        $lahan->akhir_tanam = $request->akhir_tanam;
        $lahan->user_id = Auth::id();

        $lahan->save();

        return redirect('/user/data-lahan')->with('success', 'Data Lahan Berhasil Diperbarui');
    }

    public function detail_lahan($id)
    {

        if (Auth::user()->role == 'admin') {
            $lahan = Lahan::where('denah_lahan', $id)->where('status', 'berjalan')->get();
            $nama_penanggung_jawab = AlokasiPupuk::pluck('nama_penanggung_jawab')->unique()->toArray();
            // dd($lahan);
            return view('admin.alokasi-lahan', ['lahan' => $lahan, 'id' => $id, 'nama_penanggung_jawab' => $nama_penanggung_jawab]);
        } else {
            $lahan = Lahan::find($id);
            return view('users.alokasi-lahan', ['lahan' => $lahan, 'id' => $id]);
        }
    }
}
