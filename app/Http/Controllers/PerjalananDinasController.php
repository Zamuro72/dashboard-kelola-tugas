<?php

namespace App\Http\Controllers;

use App\Models\PerjalananDinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PerjalananDinasController extends Controller
{
    /**
     * Menampilkan daftar perjalanan dinas
     */
    public function index()
    {
        $user = Auth::user();

        $data = array(
            'title' => 'Perjalanan Dinas',
            'menuKaryawanPerdin' => 'active',
            'perdins' => PerjalananDinas::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(),
        );

        return view('karyawan/perdin/index', $data);
    }

    /**
     * Form perjalanan dinas baru
     */
    public function create()
    {
        $user = Auth::user();

        $data = array(
            'title' => 'Buat Izin Perjalanan Dinas',
            'menuKaryawanPerdin' => 'active',
            'user' => $user,
        );

        return view('karyawan/perdin/create', $data);
    }

    /**
     * Menyimpan perjalanan dinas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tujuan_perjalanan' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
            'transportasi' => 'required|string|max:255',
            'uang_muka' => 'nullable|numeric|min:0',
        ], [
            'tujuan_perjalanan.required' => 'Tujuan perjalanan tidak boleh kosong',
            'lokasi.required' => 'Lokasi tidak boleh kosong',
            'tanggal_berangkat.required' => 'Tanggal berangkat tidak boleh kosong',
            'tanggal_kembali.required' => 'Tanggal kembali tidak boleh kosong',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah atau sama dengan tanggal berangkat',
            'transportasi.required' => 'Transportasi tidak boleh kosong',
        ]);

        $user = Auth::user();

        $perdin = new PerjalananDinas();
        $perdin->user_id = $user->id;
        $perdin->tujuan_perjalanan = $request->tujuan_perjalanan;
        $perdin->lokasi = $request->lokasi;
        $perdin->tanggal_berangkat = $request->tanggal_berangkat;
        $perdin->tanggal_kembali = $request->tanggal_kembali;
        $perdin->transportasi = $request->transportasi;
        $perdin->uang_muka = $request->uang_muka ?? 0;
        $perdin->save();

        return redirect()->route('perdin')->with('success', 'Perjalanan dinas berhasil dibuat');
    }

    /**
     * Menampilkan detail perjalanan dinas
     */
    public function show($id)
    {
        $user = Auth::user();
        $perdin = PerjalananDinas::with('user')->where('user_id', $user->id)->findOrFail($id);

        $data = array(
            'title' => 'Detail Perjalanan Dinas',
            'menuKaryawanPerdin' => 'active',
            'perdin' => $perdin,
        );

        return view('karyawan/perdin/show', $data);
    }

    /**
     * Form edit perjalanan dinas
     */
    public function edit($id)
    {
        $user = Auth::user();
        $perdin = PerjalananDinas::where('user_id', $user->id)->findOrFail($id);

        $data = array(
            'title' => 'Edit Perjalanan Dinas',
            'menuKaryawanPerdin' => 'active',
            'perdin' => $perdin,
            'user' => $user,
        );

        return view('karyawan/perdin/edit', $data);
    }

    /**
     * Update perjalanan dinas
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tujuan_perjalanan' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
            'transportasi' => 'required|string|max:255',
            'uang_muka' => 'nullable|numeric|min:0',
        ], [
            'tujuan_perjalanan.required' => 'Tujuan perjalanan tidak boleh kosong',
            'lokasi.required' => 'Lokasi tidak boleh kosong',
            'tanggal_berangkat.required' => 'Tanggal berangkat tidak boleh kosong',
            'tanggal_kembali.required' => 'Tanggal kembali tidak boleh kosong',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah atau sama dengan tanggal berangkat',
            'transportasi.required' => 'Transportasi tidak boleh kosong',
        ]);

        $user = Auth::user();
        $perdin = PerjalananDinas::where('user_id', $user->id)->findOrFail($id);

        $perdin->tujuan_perjalanan = $request->tujuan_perjalanan;
        $perdin->lokasi = $request->lokasi;
        $perdin->tanggal_berangkat = $request->tanggal_berangkat;
        $perdin->tanggal_kembali = $request->tanggal_kembali;
        $perdin->transportasi = $request->transportasi;
        $perdin->uang_muka = $request->uang_muka ?? 0;
        $perdin->save();

        return redirect()->route('perdin')->with('success', 'Perjalanan dinas berhasil diupdate');
    }

    /**
     * Hapus perjalanan dinas
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $perdin = PerjalananDinas::where('user_id', $user->id)->findOrFail($id);
        $perdin->delete();

        return redirect()->route('perdin')->with('success', 'Perjalanan dinas berhasil dihapus');
    }

    /**
     * Export perjalanan dinas ke PDF
     */
    public function pdf($id)
    {
        $user = Auth::user();
        $perdin = PerjalananDinas::with('user')->where('user_id', $user->id)->findOrFail($id);

        $filename = 'PerjalananDinas_' . $perdin->user->nama . '_' . Carbon::parse($perdin->tanggal_berangkat)->format('d-m-Y') . '.pdf';

        $data = array(
            'perdin' => $perdin,
        );

        $pdf = Pdf::loadView('karyawan/perdin/pdf', $data);
        return $pdf->setPaper('a4', 'portrait')->stream($filename);
    }
}
