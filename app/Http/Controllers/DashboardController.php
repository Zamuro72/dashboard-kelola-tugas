<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peserta;
use App\Models\Klien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function getChartData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $period = $request->input('period', 'monthly'); // monthly or weekly

        $user = Auth::user();

        // Base query with active scope
        $query = Klien::with('jasa')->aktif();

        // Filter by year (based on sertifikat_terbit year for now, or use the 'tahun' column?)
        $query->where('tahun', $year);

        if ($user->jabatan === 'Marketing') {
            $query->where('user_id', $user->id);
        }

        $data = $query->get();

        // Get all Jasa for series
        $allJasa = \App\Models\Jasa::all();

        // Prepare series data
        $series = [];
        $colors = [
            '#4e73df',
            '#1cc88a',
            '#36b9cc',
            '#f6c23e',
            '#e74a3b',
            '#858796',
            '#5a5c69',
            '#f8f9fc',
            '#2e59d9',
            '#17a673'
        ]; // Example colors, can be dynamic

        $categories = [];
        if ($period === 'monthly') {
            $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        } else {
            for ($i = 1; $i <= 52; $i++) {
                $categories[] = 'W' . $i;
            }
        }

        foreach ($allJasa as $index => $jasa) {
            $jasaData = [];

            if ($period === 'monthly') {
                for ($m = 1; $m <= 12; $m++) {
                    // Filter data for this Jasa and Month
                    $count = $data->filter(function ($item) use ($jasa, $m) {
                        return $item->jasa_id == $jasa->id &&
                            Carbon::parse($item->sertifikat_terbit)->month == $m;
                    })->count();
                    $jasaData[] = $count;
                }
            } else {
                for ($w = 1; $w <= 52; $w++) {
                    $count = $data->filter(function ($item) use ($jasa, $w) {
                        return $item->jasa_id == $jasa->id &&
                            Carbon::parse($item->sertifikat_terbit)->weekOfYear == $w;
                    })->count();
                    $jasaData[] = $count;
                }
            }

            // Custom color override
            $color = $colors[$index % count($colors)];
            if (strtoupper($jasa->nama_jasa) == 'ANDALALIN') {
                $color = '#A52A2A'; // Brown
            }
            if (strpos(strtoupper($jasa->nama_jasa), 'GREENSHIP') !== false) {
                $color = '#800080'; // Purple
            }

            $series[] = [
                'name' => $jasa->nama_jasa,
                'data' => $jasaData,
                'color' => $color
            ];
        }

        return response()->json([
            'series' => $series,
            'xaxis' => [
                'categories' => $categories
            ],
            'years' => Klien::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun')
        ]);
    }

    public function getChartDetails(Request $request)
    {
        $year = $request->input('year');
        $jasaName = $request->input('jasa');
        $period = $request->input('period'); // monthly or weekly
        $index = $request->input('index'); // month index (0-11) or week index (0-51)

        $user = Auth::user();

        $query = Klien::with(['jasa', 'user'])->aktif()->where('tahun', $year);

        if ($user->jabatan === 'Marketing') {
            $query->where('user_id', $user->id);
        }

        $query->whereHas('jasa', function ($q) use ($jasaName) {
            $q->where('nama_jasa', $jasaName);
        });

        if ($period === 'monthly') {
            $month = $index + 1;
            $query->whereMonth('sertifikat_terbit', $month);
        } else {
            $week = $index + 1;
            $query->whereRaw('WEEKOFYEAR(sertifikat_terbit) = ?', [$week]);
        }

        $data = $query->get()->map(function ($item) {
            return [
                'nama_klien' => $item->tipe_klien == 'Perusahaan' ? $item->nama_perusahaan : $item->nama_klien,
                'tipe_klien' => $item->tipe_klien,
                'pemilik_data' => $item->user->nama . ' (' . $item->user->jabatan . ')',
                'sertifikat_terbit' => $item->sertifikat_terbit->format('d M Y'),
            ];
        });

        return response()->json($data);
    }

    public function getPieChartData(Request $request)
    {
        $user = Auth::user();
        $year = $request->input('year', 'all');

        // Fetch ALL active clients first (Consistent with Bar Chart logic)
        $query = Klien::aktif();

        if ($user->jabatan === 'Marketing') {
            $query->where('kliens.user_id', $user->id);
        }

        // Filter by Year if specific year selected
        if ($year !== 'all') {
            // Check if tahun column is ambiguous (it shouldn't be with scope scopeAktif using join)
            // But scoping it to kliens.tahun is safer
            $query->where('kliens.tahun', $year);
        }

        $activeClients = $query->get();
        $allJasa = \App\Models\Jasa::all();

        $series = [];
        $labels = [];
        $colors = [];

        $defaultColors = [
            '#4e73df',
            '#1cc88a',
            '#36b9cc',
            '#f6c23e',
            '#e74a3b',
            '#858796',
            '#5a5c69',
            '#f8f9fc',
            '#2e59d9',
            '#17a673'
        ];

        foreach ($allJasa as $index => $jasa) {
            // Count in memory using Collection where()
            $count = $activeClients->where('jasa_id', $jasa->id)->count();

            // Logic colors consistent with bar chart
            $color = $defaultColors[$index % count($defaultColors)];
            if (strtoupper($jasa->nama_jasa) == 'ANDALALIN') {
                $color = '#A52A2A'; // Brown
            }
            if (strpos(strtoupper($jasa->nama_jasa), 'GREENSHIP') !== false) {
                $color = '#800080'; // Purple
            }

            // Always add to series as requested (including 0)
            $series[] = (int)$count;
            $labels[] = $jasa->nama_jasa;
            $colors[] = $color;
        }

        // Get available years for the filter
        $yearsQuery = Klien::select('tahun')->distinct()->orderBy('tahun', 'desc');
        if ($user->jabatan === 'Marketing') {
            $yearsQuery->where('user_id', $user->id);
        }
        $availableYears = $yearsQuery->pluck('tahun');

        return response()->json([
            'series' => $series,
            'labels' => $labels,
            'colors' => $colors,
            'years' => $availableYears
        ]);
    }
}
