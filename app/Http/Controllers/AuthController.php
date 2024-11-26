<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registrasi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string|max:500',
            'nama_kelompok_tani' => 'required|string|max:500',
            'nomor_kartu_tani' => 'required|numeric',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nama_kelompok_tani.required' => 'Nama Kelompok Tani Wajib Diisi',
            'nomor_kartu_tani.required' => 'Nomor Kartu Tani Wajib Diisi',
            'nomor_kartu_tani.numeric' => 'Nomor Kartu Tani Harus Angka'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'role' => 'user',
            'nama_kelompok_tani' => $request->nama_kelompok_tani,
            'nomor_kartu_tani' => $request->nomor_kartu_tani
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect('/')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        // Validasi input pengguna
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek kredensial pengguna
        $credentials = $request->only('username', 'password');

        $remember = $request->has('remember'); // Cek jika remember me dicentang

        if (Auth::attempt($credentials, $remember)) {
            // Autentikasi berhasil, redirect ke halaman yang sesuai
            if(Auth::user()->role == 'admin'){
                return redirect('/admin/dashboard')->with('success', 'Login berhasil!');
            }else{
                return redirect('/user/dashboard')->with('success', 'Login berhasil!');
            }
        }

        // Jika login gagal, redirect kembali dengan error
        return redirect()->back()->withErrors([
            'username' => 'Username atau kata sandi salah.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
