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
        $user = Auth::user();
        
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
            "jumlahKlienAktif"      => $user->jabatan == 'Admin'
                ? Klien::aktif()->count()
                : Klien::where('user_id', $user->id)->aktif()->count(),
            "jumlahKlienExpired"    => $user->jabatan == 'Admin'
                ? Klien::sudahExpired()->count()
                : Klien::where('user_id', $user->id)->sudahExpired()->count(),
            "jumlahKlienProses"     => $user->jabatan == 'Admin'
                ? Klien::prosesTerbit()->count()
                : Klien::where('user_id', $user->id)->prosesTerbit()->count(),
            "jumlahKlienOngoingProsesDeal" => $user->jabatan == 'Admin'
                ? Klien::ongoingProsesDeal()->count()
                : Klien::where('user_id', $user->id)->ongoingProsesDeal()->count(),
            "jumlahKlienBelumJelas" => $user->jabatan == 'Admin'
                ? Klien::belumJelas()->count()
                : Klien::where('user_id', $user->id)->belumJelas()->count(),
            "jumlahKlienFollowUp" => $user->jabatan == 'Admin'
                ? Klien::followUp()->count()
                : Klien::where('user_id', $user->id)->followUp()->count(),
        );
        return view('dashboard', $data);
    }
    public function getChartData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $period = $request->input('period', 'monthly'); // monthly or weekly

        $user = Auth::user();

        // Base query WITHOUT aktif scope - show all statuses
        $query = Klien::with(['jasa'])->where('tahun', $year);

        if ($user->jabatan === 'Marketing') {
            $query->where('user_id', $user->id);
        }

        $data = $query->get();

        // Calculate status for each klien
        $data->each(function ($item) {
            $item->computed_status = $this->getKlienStatusLabel($item);
        });

        // Get all Jasa for series
        $allJasa = \App\Models\Jasa::all();

        // Prepare series data
        $series = [];
        $statusBreakdown = []; // status breakdown per jasa per period for tooltip
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
        ];

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
            $jasaStatusBreakdown = [];

            if ($period === 'monthly') {
                for ($m = 1; $m <= 12; $m++) {
                    $filtered = $data->filter(function ($item) use ($jasa, $m) {
                        return $item->jasa_id == $jasa->id &&
                            $item->sertifikat_terbit &&
                            Carbon::parse($item->sertifikat_terbit)->month == $m;
                    });
                    // Also count items without sertifikat_terbit (proses terbit etc) - assign to current month if applicable
                    $filteredNoDate = $data->filter(function ($item) use ($jasa, $m) {
                        return $item->jasa_id == $jasa->id &&
                            !$item->sertifikat_terbit &&
                            Carbon::parse($item->created_at)->month == $m;
                    });
                    $allFiltered = $filtered->merge($filteredNoDate);
                    $jasaData[] = $allFiltered->count();

                    // Build status breakdown
                    $breakdown = $allFiltered->groupBy('computed_status')->map->count()->toArray();
                    $jasaStatusBreakdown[] = $breakdown;
                }
            } else {
                for ($w = 1; $w <= 52; $w++) {
                    $filtered = $data->filter(function ($item) use ($jasa, $w) {
                        return $item->jasa_id == $jasa->id &&
                            $item->sertifikat_terbit &&
                            Carbon::parse($item->sertifikat_terbit)->weekOfYear == $w;
                    });
                    $filteredNoDate = $data->filter(function ($item) use ($jasa, $w) {
                        return $item->jasa_id == $jasa->id &&
                            !$item->sertifikat_terbit &&
                            Carbon::parse($item->created_at)->weekOfYear == $w;
                    });
                    $allFiltered = $filtered->merge($filteredNoDate);
                    $jasaData[] = $allFiltered->count();

                    $breakdown = $allFiltered->groupBy('computed_status')->map->count()->toArray();
                    $jasaStatusBreakdown[] = $breakdown;
                }
            }

            // Custom color override
            $color = $colors[$index % count($colors)];
            if (strtoupper($jasa->nama_jasa) == 'ANDALALIN') {
                $color = '#A52A2A';
            }
            if (strpos(strtoupper($jasa->nama_jasa), 'GREENSHIP') !== false) {
                $color = '#800080';
            }

            $series[] = [
                'name' => $jasa->nama_jasa,
                'data' => $jasaData,
                'color' => $color
            ];
            $statusBreakdown[$jasa->nama_jasa] = $jasaStatusBreakdown;
        }

        return response()->json([
            'series' => $series,
            'xaxis' => [
                'categories' => $categories
            ],
            'years' => Klien::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun'),
            'statusBreakdown' => $statusBreakdown
        ]);
    }

    /**
     * Helper: Get status label for a Klien instance
     */
    private function getKlienStatusLabel(Klien $klien): string
    {
        if ($klien->status_manual) {
            if ($klien->status_manual == 'ongoing proses deal') return 'Ongoing Proses Deal';
            if ($klien->status_manual == 'belum jelas') return 'Belum Jelas';
            if ($klien->status_manual == 'proses terbit') return 'Proses Terbit';
            if ($klien->status_manual == 'follow up') return 'Follow Up';
        }

        if (!$klien->sertifikat_terbit) {
            return 'Proses Terbit';
        }

        if ($klien->isSertifikatExpired()) {
            return 'Expired';
        } elseif ($klien->isSertifikatAkanExpired()) {
            return 'Akan Expired';
        } else {
            return 'Aktif';
        }
    }

    public function getChartDetails(Request $request)
    {
        $year = $request->input('year');
        $jasaName = $request->input('jasa');
        $period = $request->input('period'); // monthly or weekly
        $index = $request->input('index'); // month index (0-11) or week index (0-51)

        $user = Auth::user();

        // Remove aktif() scope - show all statuses
        $query = Klien::with(['jasa', 'user', 'skema'])->where('tahun', $year);

        if ($user->jabatan === 'Marketing') {
            $query->where('user_id', $user->id);
        }

        $query->whereHas('jasa', function ($q) use ($jasaName) {
            $q->where('nama_jasa', $jasaName);
        });

        if ($period === 'monthly') {
            $month = $index + 1;
            $query->where(function ($q) use ($month) {
                $q->whereMonth('sertifikat_terbit', $month)
                  ->orWhere(function ($q2) use ($month) {
                      $q2->whereNull('sertifikat_terbit')
                         ->whereMonth('created_at', $month);
                  });
            });
        } else {
            $week = $index + 1;
            $query->where(function ($q) use ($week) {
                $q->whereRaw('WEEKOFYEAR(sertifikat_terbit) = ?', [$week])
                  ->orWhere(function ($q2) use ($week) {
                      $q2->whereNull('sertifikat_terbit')
                         ->whereRaw('WEEKOFYEAR(created_at) = ?', [$week]);
                  });
            });
        }

        $data = $query->get()->map(function ($item) {
            return [
                'nama_klien' => $item->tipe_klien == 'Perusahaan' ? $item->nama_perusahaan : $item->nama_klien,
                'tipe_klien' => $item->tipe_klien,
                'skema' => $item->skema ? $item->skema->nama_skema : '-',
                'pemilik_data' => $item->user->nama . ' (' . $item->user->jabatan . ')',
                'sertifikat_terbit' => $item->sertifikat_terbit ? $item->sertifikat_terbit->format('d M Y') : '-',
                'status' => $this->getKlienStatusLabel($item),
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
