<?php

namespace App\Http\Controllers;

use App\Models\KlienTidakAktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KlienTidakAktifController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->jabatan == 'Admin';

        $query = KlienTidakAktif::query();

        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_klien', 'like', "%{$search}%")
                    ->orWhere('nama_perusahaan', 'like', "%{$search}%")
                    ->orWhere('nama_penanggung_jawab', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        if ($isAdmin) {
            $query->with('user');
        }

        $kliens = $query->orderBy('created_at', 'desc')->paginate(30)->withQueryString();

        $data = [
            'title' => 'Data Klien Tidak Aktif',
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
            'kliens' => $kliens,
        ];

        if ($isAdmin) {
            return view('admin.klien_tidak_aktif.index', $data);
        } else {
            return view('marketing.klien_tidak_aktif.index', $data);
        }
    }

    public function create()
    {
        $user = Auth::user();
        $isAdmin = $user->jabatan == 'Admin';

        $data = [
            'title' => 'Tambah Data Klien Tidak Aktif',
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
        ];

        if ($isAdmin) {
            return view('admin.klien_tidak_aktif.create', $data);
        } else {
            return view('marketing.klien_tidak_aktif.create', $data);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_klien' => 'required|in:Personal,Perusahaan',
            'tahun' => 'required|digits:4',
            'status' => 'required|in:ongoing proses deal,belum jelas,follow up',
            'nama_klien' => 'required_if:tipe_klien,Personal',
            'tanggal_lahir' => 'nullable|date',
            'nama_perusahaan' => 'required_if:tipe_klien,Perusahaan',
            'nama_penanggung_jawab' => 'nullable',
            'email' => 'nullable|email',
            'no_whatsapp' => 'nullable',
        ]);

        KlienTidakAktif::create([
            'user_id' => Auth::id(),
            'tipe_klien' => $request->tipe_klien,
            'tahun' => $request->tahun,
            'nama_klien' => $request->tipe_klien == 'Personal' ? $request->nama_klien : null,
            'tanggal_lahir' => $request->tipe_klien == 'Personal' ? $request->tanggal_lahir : null,
            'nama_perusahaan' => $request->tipe_klien == 'Perusahaan' ? $request->nama_perusahaan : null,
            'nama_penanggung_jawab' => $request->tipe_klien == 'Perusahaan' ? $request->nama_penanggung_jawab : null,
            'email' => $request->email,
            'no_whatsapp' => $request->no_whatsapp,
            'status' => $request->status,
        ]);

        return redirect()->route('klien-tidak-aktif.index')->with('success', 'Data klien tidak aktif berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $isAdmin = $user->jabatan == 'Admin';

        $klien = KlienTidakAktif::findOrFail($id);

        // Cek kepemilikan untuk marketing
        if (!$isAdmin && $klien->user_id != $user->id) {
            abort(403);
        }

        $data = [
            'title' => 'Edit Data Klien Tidak Aktif',
            'menuAdminKlien' => 'active',
            'menuMarketingKlien' => 'active',
            'klien' => $klien,
        ];

        if ($isAdmin) {
            return view('admin.klien_tidak_aktif.edit', $data);
        } else {
            return view('marketing.klien_tidak_aktif.edit', $data);
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $isAdmin = $user->jabatan == 'Admin';

        $klien = KlienTidakAktif::findOrFail($id);

        if (!$isAdmin && $klien->user_id != $user->id) {
            abort(403);
        }

        $request->validate([
            'tipe_klien' => 'required|in:Personal,Perusahaan',
            'tahun' => 'required|digits:4',
            'status' => 'required|in:ongoing proses deal,belum jelas,follow up',
            'nama_klien' => 'required_if:tipe_klien,Personal',
            'tanggal_lahir' => 'nullable|date',
            'nama_perusahaan' => 'required_if:tipe_klien,Perusahaan',
            'nama_penanggung_jawab' => 'nullable',
            'email' => 'nullable|email',
            'no_whatsapp' => 'nullable',
        ]);

        $klien->update([
            'tipe_klien' => $request->tipe_klien,
            'tahun' => $request->tahun,
            'nama_klien' => $request->tipe_klien == 'Personal' ? $request->nama_klien : null,
            'tanggal_lahir' => $request->tipe_klien == 'Personal' ? $request->tanggal_lahir : null,
            'nama_perusahaan' => $request->tipe_klien == 'Perusahaan' ? $request->nama_perusahaan : null,
            'nama_penanggung_jawab' => $request->tipe_klien == 'Perusahaan' ? $request->nama_penanggung_jawab : null,
            'email' => $request->email,
            'no_whatsapp' => $request->no_whatsapp,
            'status' => $request->status,
        ]);

        return redirect()->route('klien-tidak-aktif.index')->with('success', 'Data klien tidak aktif berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $isAdmin = $user->jabatan == 'Admin';

        $klien = KlienTidakAktif::findOrFail($id);

        if (!$isAdmin && $klien->user_id != $user->id) {
            abort(403);
        }

        $klien->delete();

        return redirect()->route('klien-tidak-aktif.index')->with('success', 'Data klien tidak aktif berhasil dihapus.');
    }
}
