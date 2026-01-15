<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peserta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = array(
            "title"                 => "Dashboard",
            "menuDashboard"         => "active",
            "jumlahUser"            => User::count(),
            "jumlahAdmin"           => User::where('jabatan','Admin')->count(),
            "jumlahKaryawan"        => User::where('jabatan','karyawan')->count(),
            "jumlahDitugaskan"      => User::where('jabatan','Karyawan')->where('is_tugas',True)->count(),
            "jumlahPeserta"         => Peserta::count(),
            "jumlahPesertaBNSP"     => Peserta::where('skema', 'like', '%BNSP%')->count(),
            "jumlahPesertaKemnaker" => Peserta::where('skema', 'like', '%Kemnaker RI%')->count(),
            "jumlahAkanExpired"     => Peserta::akanExpired()->count(),
            "jumlahSudahExpired"    => Peserta::sudahExpired()->count(),
        );
        return view('dashboard', $data);
    }
    
}
