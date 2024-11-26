<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageUserController extends Controller
{
    public function index()
    {
        // Mengambil semua data user
        $users = User::all();

        // Mengembalikan view dengan data users
        return view('admin.manage-user', compact('users'));
    }

    public function store(Request $request)
    {
        // Validasi data
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'role' => 'required|in:admin,user',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = Str::uuid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('uploads', $filename, 'public');
        }

        // Membuat user baru
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->username),
            'alamat' => $request->alamat,
            'avatar' => $filename,
            'role' => $request->role,
        ]);

        // Redirect kembali ke halaman manage user dengan pesan sukses
        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role' => 'required|in:admin,user',
            'alamat' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:8', // Validasi password opsional
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete('uploads/' . $user->avatar);
            }

            $avatar = $request->file('avatar');
            $filename = Str::uuid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('uploads', $filename, 'public');
        } else {
            $filename = $user->avatar;
        }

        // Update data user
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'alamat' => $request->alamat,
            'avatar' => $filename,
            'role' => $request->role,
        ]);

        // Jika password tidak kosong, update password
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Redirect kembali ke halaman manage user dengan pesan sukses
        return redirect()->back()->with('success', 'User berhasil diperbarui');
    }


    public function destroy($id)
    {
        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus avatar jika ada
        if ($user->avatar) {
            Storage::disk('public')->delete('uploads/' . $user->avatar);
        }

        // Hapus user
        $user->delete();

        // Redirect kembali ke halaman manage user dengan pesan sukses
        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
