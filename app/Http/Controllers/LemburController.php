<?php

namespace App\Http\Controllers;

use App\Models\PengajuanLembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LemburController extends Controller
{
    /**
     * Menampilkan daftar pengajuan lembur
     */
    public function index()
    {
        $user = Auth::user();

        $data = array(
            'title' => 'Pengajuan Lembur',
            'menuKaryawanLembur' => 'active',
            'lemburs' => PengajuanLembur::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(),
        );

        return view('karyawan/lembur/index', $data);
    }

    /**
     * Form pengajuan lembur baru
     */
    public function create()
    {
        $user = Auth::user();

        $data = array(
            'title' => 'Buat Pengajuan Lembur',
            'menuKaryawanLembur' => 'active',
            'user' => $user,
        );

        return view('karyawan/lembur/create', $data);
    }

    /**
     * Menyimpan pengajuan lembur baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pelaksanaan'   => 'required|date',
            'jam_kerja_mulai'       => 'required',
            'jam_kerja_selesai'     => 'required',
            'jam_lembur_mulai'      => 'required',
            'jam_lembur_selesai'    => 'required',
            'lokasi'                => 'required|string|max:255',
            'uraian_pekerjaan'      => 'required|string',
        ], [
            'tanggal_pelaksanaan.required'      => 'Tanggal pelaksanaan tidak boleh kosong',
            'jam_kerja_mulai.required'          => 'Jam kerja mulai tidak boleh kosong',
            'jam_kerja_selesai.required'        => 'Jam kerja selesai tidak boleh kosong',
            'jam_lembur_mulai.required'         => 'Jam lembur mulai tidak boleh kosong',
            'jam_lembur_selesai.required'       => 'Jam lembur selesai tidak boleh kosong',
            'lokasi.required'                   => 'Lokasi tidak boleh kosong',
            'uraian_pekerjaan.required'         => 'Uraian pekerjaan tidak boleh kosong',
        ]);

        $user = Auth::user();

        // Hitung nama hari dari tanggal
        $tanggal = Carbon::parse($request->tanggal_pelaksanaan);
        $hari = $tanggal->locale('id')->dayName;

        // Hitung total jam lembur
        $jamLemburMulai = Carbon::parse($request->jam_lembur_mulai);
        $jamLemburSelesai = Carbon::parse($request->jam_lembur_selesai);
        $totalJamLembur = abs($jamLemburSelesai->diffInMinutes($jamLemburMulai) / 60);

        $lembur = new PengajuanLembur();
        $lembur->user_id =               $user->id;
        $lembur->tanggal_pelaksanaan =   $request->tanggal_pelaksanaan;
        $lembur->hari =                  $hari;
        $lembur->jam_kerja_mulai =       $request->jam_kerja_mulai;
        $lembur->jam_kerja_selesai =     $request->jam_kerja_selesai;
        $lembur->jam_lembur_mulai =      $request->jam_lembur_mulai;
        $lembur->jam_lembur_selesai =    $request->jam_lembur_selesai;
        $lembur->total_jam_lembur =      $totalJamLembur;
        $lembur->lokasi =                $request->lokasi;
        $lembur->uraian_pekerjaan =      $request->uraian_pekerjaan;
        $lembur->save();

        return redirect()->route('lembur')->with('success', 'Pengajuan lembur berhasil dibuat');
    }

    /**
     * Menampilkan detail pengajuan lembur
     */
    public function show($id)
    {
        $user = Auth::user();
        $lembur = PengajuanLembur::with('user')->where('user_id', $user->id)->findOrFail($id);

        $data = array(
            'title' => 'Detail Pengajuan Lembur',
            'menuKaryawanLembur' => 'active',
            'lembur' => $lembur,
        );

        return view('karyawan/lembur/show', $data);
    }

    /**
     * Form edit pengajuan lembur
     */
    public function edit($id)
    {
        $user = Auth::user();
        $lembur = PengajuanLembur::where('user_id', $user->id)->findOrFail($id);

        $data = array(
            'title' => 'Edit Pengajuan Lembur',
            'menuKaryawanLembur' => 'active',
            'lembur' => $lembur,
            'user' => $user,
        );

        return view('karyawan/lembur/edit', $data);
    }

    /**
     * Update pengajuan lembur
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pelaksanaan'   => 'required|date',
            'jam_kerja_mulai'       => 'required',
            'jam_kerja_selesai'     => 'required',
            'jam_lembur_mulai'      => 'required',
            'jam_lembur_selesai'    => 'required',
            'lokasi'                => 'required|string|max:255',
            'uraian_pekerjaan'      => 'required|string',
        ], [
            'tanggal_pelaksanaan.required'      => 'Tanggal pelaksanaan tidak boleh kosong',
            'jam_kerja_mulai.required'          => 'Jam kerja mulai tidak boleh kosong',
            'jam_kerja_selesai.required'        => 'Jam kerja selesai tidak boleh kosong',
            'jam_lembur_mulai.required'         => 'Jam lembur mulai tidak boleh kosong',
            'jam_lembur_selesai.required'       => 'Jam lembur selesai tidak boleh kosong',
            'lokasi.required'                   => 'Lokasi tidak boleh kosong',
            'uraian_pekerjaan.required'         => 'Uraian pekerjaan tidak boleh kosong',
        ]);

        $user = Auth::user();
        $lembur = PengajuanLembur::where('user_id', $user->id)->findOrFail($id);

        // Hitung nama hari dari tanggal
        $tanggal = Carbon::parse($request->tanggal_pelaksanaan);
        $hari = $tanggal->locale('id')->dayName;

        // Hitung total jam lembur
        $jamLemburMulai = Carbon::parse($request->jam_lembur_mulai);
        $jamLemburSelesai = Carbon::parse($request->jam_lembur_selesai);
        $totalJamLembur = abs($jamLemburSelesai->diffInMinutes($jamLemburMulai) / 60);

        $lembur->tanggal_pelaksanaan = $request->tanggal_pelaksanaan;
        $lembur->hari = $hari;
        $lembur->jam_kerja_mulai = $request->jam_kerja_mulai;
        $lembur->jam_kerja_selesai = $request->jam_kerja_selesai;
        $lembur->jam_lembur_mulai = $request->jam_lembur_mulai;
        $lembur->jam_lembur_selesai = $request->jam_lembur_selesai;
        $lembur->total_jam_lembur = $totalJamLembur;
        $lembur->lokasi = $request->lokasi;
        $lembur->uraian_pekerjaan = $request->uraian_pekerjaan;
        $lembur->save();

        return redirect()->route('lembur')->with('success', 'Pengajuan lembur berhasil diupdate');
    }

    /**
     * Hapus pengajuan lembur
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $lembur = PengajuanLembur::where('user_id', $user->id)->findOrFail($id);
        $lembur->delete();

        return redirect()->route('lembur')->with('success', 'Pengajuan lembur berhasil dihapus');
    }

    /**
     * Export pengajuan lembur ke PDF
     */
    public function pdf($id)
    {
        $user = Auth::user();
        $lembur = PengajuanLembur::with('user')->where('user_id', $user->id)->findOrFail($id);

        $filename = 'SPL_' . $lembur->user->nama . '_' . Carbon::parse($lembur->tanggal_pelaksanaan)->format('d-m-Y') . '.pdf';

        $data = array(
            'lembur' => $lembur,
        );

        $pdf = Pdf::loadView('karyawan/lembur/pdf', $data);
        return $pdf->setPaper('a4', 'portrait')->stream($filename);
    }
}
