<?php

namespace App\Http\Controllers;

use App\Models\AlokasiPupuk;
use App\Models\Lahan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'admin'){

            $total_lahan = Lahan::all()->count();
            $alokasi = AlokasiPupuk::all()->count();
            $penggarap = User::where('role', 'user')->count();
            $lahan_selesai = Lahan::where('status', 'selesai')->count();
            $lahans = Lahan::all();
            return view('admin.dashboard', ['total_lahan'=> $total_lahan, 'alokasi' => $alokasi, 'penggarap' => $penggarap, 'lahan_selesai' => $lahan_selesai, 'lahans' => $lahans]);
        }else{
            $total_lahan = Lahan::all()->count();
            $alokasi = AlokasiPupuk::all()->count();
            $penggarap = User::where('role', 'user')->count();
            $lahan_selesai = Lahan::where('status', 'selesai')->count();
            $lahans = Lahan::all();
            return view('users.dashboard', ['total_lahan'=> $total_lahan, 'alokasi' => $alokasi, 'penggarap' => $penggarap, 'lahan_selesai' => $lahan_selesai, 'lahans' => $lahans]);
        }
    }
}
