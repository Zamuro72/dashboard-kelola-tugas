<?php

namespace App\Http\Controllers;

use App\Models\NotaPerjalananDinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class NotaPerdinController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data = [
            'title' => 'Nota Perhitungan Perjalanan Dinas',
            'menuNotaPerdin' => 'active',
            'notas' => NotaPerjalananDinas::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(),
        ];

        return view('karyawan.nota-perdin.index', $data);
    }

    public function create()
    {
        $user = Auth::user();

        $data = [
            'title' => 'Buat Nota Perhitungan',
            'menuNotaPerdin' => 'active',
            'user' => $user,
        ];

        return view('karyawan.nota-perdin.create', $data);
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'jabatan' => 'required|string|max:255',
        'unit_kerja' => 'required|string|max:255',
        'tanggal_berangkat' => 'required|date',
        'jam_berangkat' => 'required',
        'tanggal_kembali' => 'required|date',
        'jam_kembali' => 'required',
        'tujuan_keperluan' => 'required|string',
        'km_kendaraan' => 'nullable|integer|min:0',
        'km_x_rp' => 'nullable|integer|min:0',
        'uang_saku_hari' => 'nullable|integer|min:0',
        'hari_x_rp' => 'nullable|integer|min:0',
        'potongan_uang_muka' => 'nullable|integer|min:0',
    ]);

    $user = Auth::user();

    // Parse detail biaya dari form
    $detailBiaya = [];
    if ($request->has('detail_tanggal')) {
        foreach ($request->detail_tanggal as $index => $tanggal) {
            if (!empty($tanggal)) {
                $detailBiaya[] = [
                    'tanggal' => $tanggal,
                    'keterangan' => $request->detail_keterangan[$index] ?? '',
                    'taxi_bensin_tol' => (int) ($request->detail_taxi[$index] ?? 0),
                    'pesawat_ka_bus' => (int) ($request->detail_pesawat[$index] ?? 0),
                    'hotel' => (int) ($request->detail_hotel[$index] ?? 0),
                    'makan' => (int) ($request->detail_makan[$index] ?? 0),
                    'lain_lain' => (int) ($request->detail_lain[$index] ?? 0),
                    'jumlah' => (int) ($request->detail_jumlah[$index] ?? 0),
                ];
            }
        }
    }

    // Perhitungan tanpa desimal
    $subTotalBiaya = (int) ($request->sub_total_biaya ?? 0);
    $kmKendaraan = (int) ($request->km_kendaraan ?? 0);
    $kmXRp = (int) ($request->km_x_rp ?? 0);
    $uangSakuHari = (int) ($request->uang_saku_hari ?? 0);
    $hariXRp = (int) ($request->hari_x_rp ?? 0);
    $subTotal = $subTotalBiaya + $kmXRp + $hariXRp;
    $potonganUangMuka = (int) ($request->potongan_uang_muka ?? 0);
    $total = $subTotal - $potonganUangMuka;

    NotaPerjalananDinas::create([
        'user_id' => $user->id,
        'nama' => $request->nama,
        'jabatan' => $request->jabatan,
        'unit_kerja' => $request->unit_kerja,
        'tanggal_berangkat' => $request->tanggal_berangkat,
        'jam_berangkat' => $request->jam_berangkat,
        'tanggal_kembali' => $request->tanggal_kembali,
        'jam_kembali' => $request->jam_kembali,
        'tujuan_keperluan' => $request->tujuan_keperluan,
        'detail_biaya' => $detailBiaya,
        'sub_total_biaya' => $subTotalBiaya,
        'km_kendaraan' => $kmKendaraan,
        'km_x_rp' => $kmXRp,
        'uang_saku_hari' => $uangSakuHari,
        'hari_x_rp' => $hariXRp,
        'sub_total' => $subTotal,
        'potongan_uang_muka' => $potonganUangMuka,
        'total' => $total,
        'lokasi_pengajuan' => $request->lokasi_pengajuan ?? 'Jakarta',
        'tanggal_pengajuan' => now(),
    ]);

    return redirect()->route('notaPerdin')->with('success', 'Nota perhitungan berhasil dibuat');
}

    public function show($id)
    {
        $user = Auth::user();
        $nota = NotaPerjalananDinas::where('user_id', $user->id)->findOrFail($id);

        $data = [
            'title' => 'Detail Nota Perhitungan',
            'menuNotaPerdin' => 'active',
            'nota' => $nota,
        ];

        return view('karyawan.nota-perdin.show', $data);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $nota = NotaPerjalananDinas::where('user_id', $user->id)->findOrFail($id);
        $nota->delete();

        return redirect()->route('notaPerdin')->with('success', 'Nota perhitungan berhasil dihapus');
    }

    public function pdf($id)
    {
        $user = Auth::user();
        $nota = NotaPerjalananDinas::where('user_id', $user->id)->findOrFail($id);

        $filename = 'Nota_Perdin_' . $nota->nama . '_' . Carbon::parse($nota->tanggal_berangkat)->format('d-m-Y') . '.pdf';

        $data = [
            'nota' => $nota,
        ];

        $pdf = Pdf::loadView('karyawan.nota-perdin.pdf', $data);
        return $pdf->setPaper('a4', 'portrait')->stream($filename);
    }
}