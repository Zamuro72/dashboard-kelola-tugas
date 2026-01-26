<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use App\Exports\PesertaExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = date('Y');

        if ($request->has('tahun')) {
            $tahunTerpilih = $request->get('tahun');
        } else {
            $existsCurrentYear = Peserta::where('tahun', $currentYear)->exists();
            if ($existsCurrentYear) {
                $tahunTerpilih = $currentYear;
            } else {
                $latestYear = Peserta::max('tahun');
                $tahunTerpilih = $latestYear ?? $currentYear;
            }
        }

        $skemaTerpilih = $request->get('skema', '');

        $daftarTahun = Peserta::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $daftarSkema = ['BNSP', 'Kemnaker RI'];

        $jumlahAkanExpired  = Peserta::akanExpired()->count();
        $jumlahSudahExpired = Peserta::sudahExpired()->count();

        $query = Peserta::where('tahun', $tahunTerpilih);
        if ($skemaTerpilih) {
            $query->where('skema', 'like', '%' . $skemaTerpilih . '%');
        }

        $data = array(
            'title'                => 'Data Peserta',
            'menuAdminPeserta'     => 'active',
            'peserta'              => $query->orderBy('nama', 'asc')->get(),
            'daftarTahun'          => $daftarTahun,
            'daftarSkema'          => $daftarSkema,
            'tahunTerpilih'        => $tahunTerpilih,
            'skemaTerpilih'        => $skemaTerpilih,
            'jumlahAkanExpired'    => $jumlahAkanExpired,
            'jumlahSudahExpired'   => $jumlahSudahExpired,
        );
        return view('admin/peserta/index', $data);
    }

    public function notifikasi()
    {
        $pesertaAkanExpired = Peserta::akanExpired()->orderBy('tanggal_sertifikat_diterima')->get();
        $pesertaSudahExpired = Peserta::sudahExpired()->orderBy('tanggal_sertifikat_diterima')->get();

        $data = array(
            'title'                 => 'Notifikasi Sertifikat',
            'menuAdminPeserta'      => 'active',
            'pesertaAkanExpired'    => $pesertaAkanExpired,
            'pesertaSudahExpired'   => $pesertaSudahExpired,
        );
        return view('admin/peserta/notifikasi', $data);
    }

    public function create()
    {
        $data = array(
            'title'              => 'Tambah Data Peserta',
            'menuAdminPeserta'   => 'active',
        );
        return view('admin/peserta/create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun'                        => 'required|digits:4',
            'nama'                         => 'required',
            'nama_perusahaan'              => 'nullable',
            'no_whatsapp'                  => 'nullable',
            'tanggal_lahir'                => 'nullable|date',
            'skema'                        => 'nullable',
            'tanggal_sertifikat_diterima'  => 'nullable|date',
        ], [
            'tahun.required'                        => 'Tahun tidak boleh kosong',
            'tahun.digits'                          => 'Tahun harus 4 digit',
            'nama.required'                         => 'Nama tidak boleh kosong',
            'nama_perusahaan.required'              => 'Nama perusahaan tidak boleh kosong',
            'no_whatsapp.required'                  => 'No WhatsApp tidak boleh kosong',
            'tanggal_lahir.required'                => 'Tanggal lahir tidak boleh kosong',
            'tanggal_lahir.date'                    => 'Format tanggal lahir tidak valid',
            'skema.required'                        => 'Skema tidak boleh kosong',
            'tanggal_sertifikat_diterima.required'  => 'Tanggal sertifikat diterima tidak boleh kosong',
            'tanggal_sertifikat_diterima.date'      => 'Format tanggal tidak valid',
        ]);

        $peserta = new Peserta;
        $peserta->tahun                        = $request->tahun;
        $peserta->nama                         = $request->nama;
        $peserta->nama_perusahaan              = $request->nama_perusahaan;
        $peserta->no_whatsapp                  = $request->no_whatsapp;
        $peserta->tanggal_lahir                = $request->tanggal_lahir;
        $peserta->skema                        = $request->skema;
        $peserta->tanggal_sertifikat_diterima  = $request->tanggal_sertifikat_diterima;
        $peserta->suka_telat_bayar             = $request->has('suka_telat_bayar');
        $peserta->save();

        return redirect()->route('peserta', ['tahun' => $peserta->tahun])->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = array(
            'title'              => 'Edit Data Peserta',
            'menuAdminPeserta'   => 'active',
            'peserta'            => Peserta::findOrFail($id),
        );
        return view('admin/peserta/edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun'                        => 'required|digits:4',
            'nama'                         => 'required',
            'nama_perusahaan'              => 'nullable',
            'no_whatsapp'                  => 'nullable',
            'tanggal_lahir'                => 'nullable|date',
            'skema'                        => 'nullable',
            'tanggal_sertifikat_diterima'  => 'nullable|date',
        ], [
            'tahun.required'                        => 'Tahun tidak boleh kosong',
            'tahun.digits'                          => 'Tahun harus 4 digit',
            'nama.required'                         => 'Nama tidak boleh kosong',
            'nama_perusahaan.required'              => 'Nama perusahaan tidak boleh kosong',
            'no_whatsapp.required'                  => 'No WhatsApp tidak boleh kosong',
            'tanggal_lahir.required'                => 'Tanggal lahir tidak boleh kosong',
            'tanggal_lahir.date'                    => 'Format tanggal lahir tidak valid',
            'skema.required'                        => 'Skema tidak boleh kosong',
            'tanggal_sertifikat_diterima.required'  => 'Tanggal sertifikat diterima tidak boleh kosong',
            'tanggal_sertifikat_diterima.date'      => 'Format tanggal tidak valid',
        ]);

        $peserta = Peserta::findOrFail($id);
        $peserta->tahun                        = $request->tahun;
        $peserta->nama                         = $request->nama;
        $peserta->nama_perusahaan              = $request->nama_perusahaan;
        $peserta->no_whatsapp                  = $request->no_whatsapp;
        $peserta->tanggal_lahir                = $request->tanggal_lahir;
        $peserta->skema                        = $request->skema;
        $peserta->tanggal_sertifikat_diterima  = $request->tanggal_sertifikat_diterima;
        $peserta->suka_telat_bayar             = $request->has('suka_telat_bayar');
        $peserta->save();

        return redirect()->route('peserta', ['tahun' => $peserta->tahun])->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $tahun   = $peserta->tahun;
        $peserta->delete();

        return redirect()->route('peserta', ['tahun' => $tahun])->with('success', 'Data berhasil dihapus');
    }

    public function destroyByTahun($tahun)
    {
        $deleted = Peserta::where('tahun', $tahun)->delete();

        if ($deleted) {
            return redirect()->back()->with('success', "Semua data peserta tahun $tahun berhasil dihapus ($deleted data)");
        } else {
            return redirect()->back()->with('error', "Tidak ada data peserta untuk tahun $tahun");
        }
    }

    public function toggleTelatBayar($id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->suka_telat_bayar = !$peserta->suka_telat_bayar;
        $peserta->save();

        $status = $peserta->suka_telat_bayar ? 'ditandai suka telat bayar' : 'ditandai tidak telat bayar';
        return redirect()->back()->with('success', 'Peserta berhasil ' . $status);
    }

    public function excel(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $skema = $request->get('skema', '');
        $filename = now()->format('d-m-y_H.i.s');
        return Excel::download(new PesertaExport($tahun, $skema), 'DataPeserta_' . $tahun . '_' . $filename . '.xlsx');
    }

    public function pdf(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $skema = $request->get('skema', '');
        $filename = now()->format('d-m-y_H.i.s');

        $query = Peserta::where('tahun', $tahun);
        if ($skema) {
            $query->where('skema', 'like', '%' . $skema . '%');
        }

        $data = array(
            'peserta'  => $query->orderBy('nama', 'asc')->get(),
            'tahun'    => $tahun,
            'skema'    => $skema,
            'tanggal'  => now()->format('d-m-y'),
            'jam'      => now()->format('H.i.s'),
        );

        $pdf = Pdf::loadView('admin/peserta/pdf', $data);
        return $pdf->setPaper('a4', 'landscape')->stream('DataPeserta_' . $tahun . '_' . $filename . '.pdf');
    }

    public function importForm()
    {
        $data = array(
            'title'              => 'Import Data Peserta',
            'menuAdminPeserta'   => 'active',
        );
        return view('admin/peserta/import', $data);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120'
        ], [
            'file.required' => 'File harus dipilih',
            'file.mimes'    => 'File harus bertipe Excel (.xlsx, .xls, .csv)',
            'file.max'      => 'Ukuran file maksimal 5MB'
        ]);

        try {
            $filename = $request->file('file')->getClientOriginalName();
            $tahunFromFilename = $this->extractTahunFromFilename($filename);

            Excel::import(new \App\Imports\PesertaImport($tahunFromFilename), $request->file('file'));

            $redirectToYear = $tahunFromFilename ?? date('Y');
            return redirect()->route('peserta', ['tahun' => $redirectToYear])->with('success', 'Data peserta berhasil diimport');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport file: ' . $e->getMessage());
        }
    }

    private function extractTahunFromFilename($filename)
    {
        if (preg_match('/\b(19|20)\d{2}\b/', $filename, $matches)) {
            return $matches[0];
        }
        return null;
    }
}