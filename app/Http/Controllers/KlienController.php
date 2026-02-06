<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Klien;
use App\Models\Skema;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KlienExport;
use Illuminate\Support\Facades\DB;

class KlienController extends Controller
{
    /**
     * Menampilkan daftar jasa
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // Hitung notifikasi expired
        $jumlahAkanExpired = Klien::where('user_id', $user->id)
            ->akanExpired()
            ->count();

        $jumlahSudahExpired = Klien::where('user_id', $user->id)
            ->sudahExpired()
            ->count();

        $data = [
            'title' => 'Data Klien',
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
            'jasaList' => Jasa::with('skema')->get(),
            'jumlahAkanExpired' => $jumlahAkanExpired,
            'jumlahSudahExpired' => $jumlahSudahExpired,
        ];

        if ($user->jabatan == 'Admin') {
            return view('admin.klien.index', $data);
        } else {
            return view('marketing.klien.index', $data);
        }
    }

    /**
     * Menampilkan pilihan tahun untuk jasa tertentu
     */
    public function showTahun($jasaId)
    {
        /** @var User $user */
        $user = Auth::user();
        $jasa = Jasa::findOrFail($jasaId);

        // Ambil daftar tahun dari data klien
        $tahunList = Klien::where('user_id', $user->id)
            ->where('jasa_id', $jasaId)
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $data = [
            'title' => 'Pilih Tahun - ' . $jasa->nama_jasa,
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
            'jasa' => $jasa,
            'tahunList' => $tahunList,
        ];

        if ($user->jabatan == 'Admin') {
            return view('admin.klien.tahun', $data);
        } else {
            return view('marketing.klien.tahun', $data);
        }
    }

    /**
     * Menampilkan skema untuk jasa tertentu dengan tahun
     */
    public function showSkema($jasaId, $tahun)
    {
        $jasa = Jasa::findOrFail($jasaId);

        if (!$jasa->has_skema) {
            // Jika jasa tidak punya skema, langsung ke data klien
            return redirect()->route('klien.data', ['jasaId' => $jasaId, 'tahun' => $tahun]);
        }

        /** @var User $user */
        $user = Auth::user();

        $data = [
            'title' => 'Skema ' . $jasa->nama_jasa . ' - Tahun ' . $tahun,
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
            'jasa' => $jasa,
            'tahun' => $tahun,
            'skemaList' => Skema::where('jasa_id', $jasaId)
                ->withCount(['kliens' => function ($query) use ($user, $tahun) {
                    $query->where('user_id', $user->id)
                        ->where('tahun', $tahun);
                }])
                ->get(),
        ];

        if ($user->jabatan == 'Admin') {
            return view('admin.klien.skema', $data);
        } else {
            return view('marketing.klien.skema', $data);
        }
    }

    /**
     * Menampilkan data klien
     */
    public function showData(Request $request, $jasaId, $tahun, $skemaId = null)
    {
        /** @var User $user */
        $user = Auth::user();
        $jasa = Jasa::findOrFail($jasaId);
        $skema = $skemaId ? Skema::findOrFail($skemaId) : null;

        $query = Klien::where('user_id', $user->id)
            ->where('jasa_id', $jasaId)
            ->where('tahun', $tahun);

        if ($skemaId) {
            $query->where('skema_id', $skemaId);
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_klien', 'like', '%' . $search . '%')
                    ->orWhere('nama_perusahaan', 'like', '%' . $search . '%')
                    ->orWhere('nama_penanggung_jawab', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_whatsapp', 'like', '%' . $search . '%');
            });
        }

        // Filter by tipe_klien
        if ($request->has('tipe_klien') && $request->tipe_klien != '') {
            $query->where('tipe_klien', $request->tipe_klien);
        }

        $kliens = $query->orderBy('created_at', 'desc')->paginate(30)->withQueryString();

        $data = [
            'title' => 'Data Klien - ' . $jasa->nama_jasa . ' - Tahun ' . $tahun . ($skema ? ' - ' . $skema->nama_skema : ''),
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
            'jasa' => $jasa,
            'tahun' => $tahun,
            'skema' => $skema,
            'kliens' => $kliens,
        ];

        if ($user->jabatan == 'Admin') {
            return view('admin.klien.data', $data);
        } else {
            return view('marketing.klien.data', $data);
        }
    }

    /**
     * Form tambah klien
     */
    public function create($jasaId, $tahun, $skemaId = null)
    {
        $jasa = Jasa::findOrFail($jasaId);
        $skema = $skemaId ? Skema::findOrFail($skemaId) : null;

        $data = [
            'title' => 'Tambah Klien - ' . $jasa->nama_jasa . ' - Tahun ' . $tahun . ($skema ? ' - ' . $skema->nama_skema : ''),
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
            'jasa' => $jasa,
            'tahun' => $tahun,
            'skema' => $skema,
        ];

        /** @var User $user */
        $user = Auth::user();
        if ($user->jabatan == 'Admin') {
            return view('admin.klien.create', $data);
        } else {
            return view('marketing.klien.create', $data);
        }
    }

    /**
     * Simpan data klien
     */
    public function store(Request $request, $jasaId, $tahun, $skemaId = null)
    {
        $jasa = Jasa::findOrFail($jasaId);

        $rules = [
            'tipe_klien' => 'required|in:Personal,Perusahaan',
            'email' => 'nullable|email',
            'no_whatsapp' => 'nullable',
            'sertifikat_terbit' => 'nullable|date',
        ];

        if ($request->tipe_klien == 'Personal') {
            $rules['nama_klien'] = 'required|string|max:255';
            $rules['nama_perusahaan'] = 'nullable|string|max:255';
        } else {
            $rules['nama_perusahaan'] = 'required|string|max:255';
            $rules['nama_penanggung_jawab'] = 'required|string|max:255';
        }

        $request->validate($rules, [
            'tipe_klien.required' => 'Tipe klien harus dipilih',
            'nama_klien.required' => 'Nama klien tidak boleh kosong',
            'nama_perusahaan.required' => 'Nama perusahaan tidak boleh kosong',
            'nama_penanggung_jawab.required' => 'Nama penanggung jawab tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'sertifikat_terbit.date' => 'Format tanggal tidak valid',
        ]);

        Klien::create([
            'user_id' => Auth::id(),
            'jasa_id' => $jasaId,
            'skema_id' => $skemaId,
            'tahun' => $tahun,
            'tipe_klien' => $request->tipe_klien,
            'nama_klien' => $request->nama_klien,
            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
            'email' => $request->email,
            'no_whatsapp' => $request->no_whatsapp,
            'sertifikat_terbit' => $request->sertifikat_terbit,
        ]);

        if ($skemaId) {
            return redirect()->route('klien.data', ['jasaId' => $jasaId, 'tahun' => $tahun, 'skemaId' => $skemaId])
                ->with('success', 'Data klien berhasil ditambahkan');
        } else {
            return redirect()->route('klien.data', ['jasaId' => $jasaId, 'tahun' => $tahun])
                ->with('success', 'Data klien berhasil ditambahkan');
        }
    }

    /**
     * Edit klien
     */
    public function edit($id)
    {
        $klien = Klien::where('user_id', Auth::id())->findOrFail($id);

        $data = [
            'title' => 'Edit Klien',
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
            'klien' => $klien,
        ];

        /** @var User $user */
        $user = Auth::user();
        if ($user->jabatan == 'Admin') {
            return view('admin.klien.edit', $data);
        } else {
            return view('marketing.klien.edit', $data);
        }
    }

    /**
     * Update klien
     */
    public function update(Request $request, $id)
    {
        $klien = Klien::where('user_id', Auth::id())->findOrFail($id);

        $rules = [
            'tipe_klien' => 'required|in:Personal,Perusahaan',
            'email' => 'nullable|email',
            'no_whatsapp' => 'nullable',
            'sertifikat_terbit' => 'nullable|date',
        ];

        if ($request->tipe_klien == 'Personal') {
            $rules['nama_klien'] = 'required|string|max:255';
            $rules['nama_perusahaan'] = 'nullable|string|max:255';
        } else {
            $rules['nama_perusahaan'] = 'required|string|max:255';
            $rules['nama_penanggung_jawab'] = 'required|string|max:255';
        }

        $request->validate($rules, [
            'tipe_klien.required' => 'Tipe klien harus dipilih',
            'nama_klien.required' => 'Nama klien tidak boleh kosong',
            'nama_perusahaan.required' => 'Nama perusahaan tidak boleh kosong',
            'nama_penanggung_jawab.required' => 'Nama penanggung jawab tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'sertifikat_terbit.date' => 'Format tanggal tidak valid',
        ]);

        $klien->update([
            'tipe_klien' => $request->tipe_klien,
            'nama_klien' => $request->nama_klien,
            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
            'email' => $request->email,
            'no_whatsapp' => $request->no_whatsapp,
            'sertifikat_terbit' => $request->sertifikat_terbit,
        ]);

        if ($klien->skema_id) {
            return redirect()->route('klien.data', ['jasaId' => $klien->jasa_id, 'tahun' => $klien->tahun, 'skemaId' => $klien->skema_id])
                ->with('success', 'Data klien berhasil diupdate');
        } else {
            return redirect()->route('klien.data', ['jasaId' => $klien->jasa_id, 'tahun' => $klien->tahun])
                ->with('success', 'Data klien berhasil diupdate');
        }
    }

    /**
     * Hapus klien
     */
    public function destroy($id)
    {
        $klien = Klien::where('user_id', Auth::id())->findOrFail($id);
        $jasaId = $klien->jasa_id;
        $tahun = $klien->tahun;
        $skemaId = $klien->skema_id;

        $klien->delete();

        if ($skemaId) {
            return redirect()->route('klien.data', ['jasaId' => $jasaId, 'tahun' => $tahun, 'skemaId' => $skemaId])
                ->with('success', 'Data klien berhasil dihapus');
        } else {
            return redirect()->route('klien.data', ['jasaId' => $jasaId, 'tahun' => $tahun])
                ->with('success', 'Data klien berhasil dihapus');
        }
    }

    /**
     * Notifikasi expired
     */
    public function notifikasi()
    {
        /** @var User $user */
        $user = Auth::user();

        $klienAkanExpired = Klien::where('user_id', $user->id)
            ->akanExpired()
            ->with(['jasa', 'skema'])
            ->orderBy('sertifikat_terbit')
            ->get();

        $klienSudahExpired = Klien::where('user_id', $user->id)
            ->sudahExpired()
            ->with(['jasa', 'skema'])
            ->orderBy('sertifikat_terbit')
            ->get();

        $data = [
            'title' => 'Notifikasi Sertifikat Klien',
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
            'klienAkanExpired' => $klienAkanExpired,
            'klienSudahExpired' => $klienSudahExpired,
        ];

        if ($user->jabatan == 'Admin') {
            return view('admin.klien.notifikasi', $data);
        } else {
            return view('marketing.klien.notifikasi', $data);
        }
    }

    /**
     * Export Excel
     */
    public function excel($jasaId, $tahun, $skemaId = null)
    {
        /** @var User $user */
        $user = Auth::user();
        $jasa = Jasa::findOrFail($jasaId);
        $skema = $skemaId ? Skema::findOrFail($skemaId) : null;

        $filename = 'DataKlien_' . $jasa->nama_jasa . '_' . $tahun . ($skema ? '_' . $skema->nama_skema : '') . '_' . now()->format('d-m-Y_H.i.s') . '.xlsx';

        return Excel::download(new KlienExport($user->id, $jasaId, $tahun, $skemaId), $filename);
    }

    /**
     * Export PDF
     */
    public function pdf($jasaId, $tahun, $skemaId = null)
    {
        /** @var User $user */
        $user = Auth::user();
        $jasa = Jasa::findOrFail($jasaId);
        $skema = $skemaId ? Skema::findOrFail($skemaId) : null;

        $query = Klien::where('user_id', $user->id)
            ->where('jasa_id', $jasaId)
            ->where('tahun', $tahun);

        if ($skemaId) {
            $query->where('skema_id', $skemaId);
        }

        $kliens = $query->orderBy('created_at', 'desc')->get();

        $data = [
            'kliens' => $kliens,
            'jasa' => $jasa,
            'tahun' => $tahun,
            'skema' => $skema,
            'tanggal' => now()->format('d-m-Y'),
            'jam' => now()->format('H.i.s'),
        ];

        $filename = 'DataKlien_' . $jasa->nama_jasa . '_' . $tahun . ($skema ? '_' . $skema->nama_skema : '') . '_' . now()->format('d-m-Y_H.i.s') . '.pdf';

        $pdf = Pdf::loadView('admin.klien.pdf', $data);
        return $pdf->setPaper('a4', 'landscape')->stream($filename);
    }

    /**
     * Form import
     */
    public function importForm()
    {
        $data = [
            'title' => 'Import Data Klien',
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
        ];

        /** @var User $user */
        $user = Auth::user();
        if ($user->jabatan == 'Admin') {
            return view('admin.klien.import', $data);
        } else {
            return view('marketing.klien.import', $data);
        }
    }

    /**
     * Import Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120'
        ], [
            'file.required' => 'File harus dipilih',
            'file.mimes' => 'File harus bertipe Excel (.xlsx, .xls, .csv)',
            'file.max' => 'Ukuran file maksimal 5MB'
        ]);

        try {
            Excel::import(new \App\Imports\KlienImport(Auth::id()), $request->file('file'));

            return redirect()->route('klien.index')->with('success', 'Data klien berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport file: ' . $e->getMessage());
        }
    }
    /**
     * Filter Klien by Status
     */
    public function filterByStatus($status)
    {
        /** @var User $user */
        $user = Auth::user();
        $query = Klien::with(['jasa', 'skema']);

        if ($user->jabatan != 'Admin') {
            $query->where('user_id', $user->id);
        }

        $title = '';
        switch ($status) {
            case 'aktif':
                $query->aktif();
                $title = 'Data Klien Aktif';
                break;
            case 'expired':
                $query->sudahExpired();
                $title = 'Data Klien Expired';
                break;
            case 'proses':
                $query->prosesTerbit();
                $title = 'Data Klien Proses Terbit';
                break;
            default:
                abort(404);
        }

        $kliens = $query->paginate(30);

        if ($user->jabatan == 'Admin') {
            return view('admin.klien.filter_status', compact('kliens', 'title', 'status'));
        } else {
            return view('marketing.klien.filter_status', compact('kliens', 'title', 'status'));
        }
    }
}
