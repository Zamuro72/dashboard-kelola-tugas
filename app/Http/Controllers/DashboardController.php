<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peserta;
use App\Models\Klien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = array(
            "title"                 => "Dashboard",
            "menuDashboard"         => "active",
            "jumlahUser"            => User::count(),
            "jumlahAdmin"           => User::where('jabatan', 'Admin')->count(),
            "jumlahKaryawan"        => User::where('jabatan', 'karyawan')->count(),
            "jumlahDitugaskan"      => User::where('jabatan', 'Karyawan')->where('is_tugas', True)->count(),
            "jumlahPeserta"         => Peserta::count(),
            "jumlahPesertaBNSP"     => Peserta::where('skema', 'like', '%BNSP%')->count(),
            "jumlahPesertaKemnaker" => Peserta::where('skema', 'like', '%Kemnaker RI%')->count(),
            "jumlahAkanExpired"     => Peserta::akanExpired()->count(),
            "jumlahSudahExpired"    => Peserta::sudahExpired()->count(),
            "jumlahKlienAktif"      => User::where('id', Auth::id())->first()->jabatan == 'Admin'
                ? Klien::aktif()->count()
                : Klien::where('user_id', Auth::id())->aktif()->count(),
            "jumlahKlienExpired"    => User::where('id', Auth::id())->first()->jabatan == 'Admin'
                ? Klien::sudahExpired()->count()
                : Klien::where('user_id', Auth::id())->sudahExpired()->count(),
            "jumlahKlienProses"     => User::where('id', Auth::id())->first()->jabatan == 'Admin'
                ? Klien::whereNull('sertifikat_terbit')->count()
                : Klien::where('user_id', Auth::id())->whereNull('sertifikat_terbit')->count(),
        );
        return view('dashboard', $data);
    }
}
