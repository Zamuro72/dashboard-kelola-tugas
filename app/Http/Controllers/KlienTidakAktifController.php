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
                    ->orWhere('bidang_usaha', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%")
                    ->orWhere('pic_sales', 'like', "%{$search}%")
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
            'tahun' => 'required|digits:4',
            'status' => 'required|in:ongoing proses deal,belum jelas,follow up,belum dihubungi,sudah diblasting,menunggu respon,deal,tidak berminat',
            'nama_klien' => 'nullable|string|max:255',
            'nama_perusahaan' => 'nullable|string|max:255',
            'bidang_usaha' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'no_whatsapp' => 'nullable|string|max:20',
            'produk_minat' => 'nullable|string|max:255',
            'pic_sales' => 'nullable|string|max:255',
        ]);

        KlienTidakAktif::create([
            'user_id' => Auth::id(),
            'tahun' => $request->tahun,
            'nama_klien' => $request->nama_klien,
            'nama_perusahaan' => $request->nama_perusahaan,
            'bidang_usaha' => $request->bidang_usaha,
            'kota' => $request->kota,
            'email' => $request->email,
            'no_whatsapp' => $request->no_whatsapp,
            'produk_minat' => $request->produk_minat,
            'pic_sales' => $request->pic_sales,
            'status' => $request->status,
        ]);

        return redirect()->route('klien.index')->with('success', 'Data klien tidak aktif berhasil ditambahkan.');
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
            'tahun' => 'required|digits:4',
            'status' => 'required|in:ongoing proses deal,belum jelas,follow up,belum dihubungi,sudah diblasting,menunggu respon,deal,tidak berminat',
            'nama_klien' => 'nullable|string|max:255',
            'nama_perusahaan' => 'nullable|string|max:255',
            'bidang_usaha' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'no_whatsapp' => 'nullable|string|max:20',
            'produk_minat' => 'nullable|string|max:255',
            'pic_sales' => 'nullable|string|max:255',
        ]);

        $klien->update([
            'tahun' => $request->tahun,
            'nama_klien' => $request->nama_klien,
            'nama_perusahaan' => $request->nama_perusahaan,
            'bidang_usaha' => $request->bidang_usaha,
            'kota' => $request->kota,
            'email' => $request->email,
            'no_whatsapp' => $request->no_whatsapp,
            'produk_minat' => $request->produk_minat,
            'pic_sales' => $request->pic_sales,
            'status' => $request->status,
        ]);

        return redirect()->route('klien-tidak-aktif.index')->with('success', 'Data klien tidak aktif berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        $isAdmin = $user->jabatan == 'Admin';

        $klien = KlienTidakAktif::findOrFail($id);

        if (!$isAdmin && $klien->user_id != $user->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:ongoing proses deal,belum jelas,follow up,belum dihubungi,sudah diblasting,menunggu respon,deal,tidak berminat',
        ]);

        $klien->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function blastingWa($id)
    {
        $user = Auth::user();
        $isAdmin = $user->jabatan == 'Admin';

        $klien = KlienTidakAktif::findOrFail($id);

        if (!$isAdmin && $klien->user_id != $user->id) {
            abort(403);
        }

        $klien->update(['terakhir_blasting_wa' => now()]);

        if ($klien->no_whatsapp) {
            $phone = preg_replace('/[^0-9]/', '', $klien->no_whatsapp);
            if (substr($phone, 0, 1) == '0') {
                $phone = '62' . substr($phone, 1);
            }
            return redirect('https://wa.me/' . $phone);
        }

        return redirect()->back()->with('success', 'Waktu blasting WA berhasil dicatat.');
    }

    public function blastingEmail($id)
    {
        $user = Auth::user();
        $isAdmin = $user->jabatan == 'Admin';

        $klien = KlienTidakAktif::findOrFail($id);

        if (!$isAdmin && $klien->user_id != $user->id) {
            abort(403);
        }

        $klien->update(['terakhir_blasting_email' => now()]);

        return redirect()->back()->with('success', 'Waktu blasting Email berhasil dicatat.');
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
