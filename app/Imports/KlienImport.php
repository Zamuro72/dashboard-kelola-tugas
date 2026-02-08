<?php

namespace App\Imports;

use App\Models\Klien;
use App\Models\Jasa;
use App\Models\Skema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class KlienImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithMapping
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function map($row): array
    {
        return array_map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        }, $row);
    }

    public function model(array $row)
    {
        // Deteksi jasa dan skema dari nama skema
        $jasaId = null;
        $skemaId = null;
        $namaSkema = trim($row['skema'] ?? '');

        // Mapping skema BNSP
        $schemaBNSP = [
            'PPPA & POPAL',
            'PPPA',
            'POPAL',
            'PPPU & POIPPU',
            'PPPU',
            'POIPPU',
            'OPLB3 & MPLB3',
            'OPLB3',
            'MPLB3',
            'PCUA',
            'Auditor Energi',
            'Manajer Energi Industri & Bangunan Gedung',
            'Petugas P3K BNSP',
            'Ahli K3 Umum BNSP',
            'Ahli K3 Listrik BNSP',
            'Petugas Investigasi Insiden',
            'Pengkaji Teknis Proteksi Kebakaran',
            'Pengawas K3 Laboratorium',
            'POP POM & Pertambangan Minerba',
            'POP POM',
            'Pertambangan Minerba',
            'Fire Safety Manager',
        ];

        // Mapping skema Kemnaker RI
        $schemaKemnaker = [
            'Ahli K3 Muda Lingkungan Kerja',
            'Operator Forklift Kelas 2',
            'Operator Forklift Kelas 1',
            'Petugas Pemadam Kebakaran (Kelas D)',
            'Regu Penanggulangan Kebakaran (Kelas C)',
            'Ahli Muda K3 Konstruksi',
            'Petugas P3K Kemnaker',
            'Petugas P3K Kemnaker RI',
            'Ahli K3 Umum Kemnaker',
            'Ahli K3 Umum Kemnaker RI',
            'Auditor SMK3',
            'Teknisi K3 Listrik',
            'Ahli K3 Listrik Kemnaker',
            'Ahli K3 Listrik Kemnaker RI',
            'Supervisor Perancah',
            'Petugas K3 Penyelamat Ruang Terbatas',
            'Teknisi Deteksi Gas Ruang Terbatas',
            'Teknisi K3 Ruang Terbatas',
            'Tenaga Kerja Bangunan Tinggi Tingkat 2',
            'Tenaga Kerja Pada Ketinggian Tingkat 1',
            'Teknisi K3 Perancah',
        ];

        // Mapping skema ISO
        $schemaISO = [
            '9001',
            'ISO 9001',
            '14001',
            'ISO 14001',
            '45001',
            'ISO 45001',
            '27001',
            'ISO 27001',
        ];

        // Cek apakah termasuk BNSP
        foreach ($schemaBNSP as $schema) {
            if (stripos($namaSkema, $schema) !== false) {
                $jasa = Jasa::where('nama_jasa', 'BNSP')->first();
                if ($jasa) {
                    $jasaId = $jasa->id;

                    // Cari skema yang cocok
                    $skemaObj = Skema::where('jasa_id', $jasaId)
                        ->where(function ($q) use ($namaSkema) {
                            $q->where('nama_skema', 'LIKE', '%' . $namaSkema . '%')
                                ->orWhereRaw('? LIKE CONCAT("%", nama_skema, "%")', [$namaSkema]);
                        })
                        ->first();

                    if (!$skemaObj) {
                        // Jika tidak ditemukan, coba cari berdasarkan keyword
                        if (stripos($namaSkema, 'Ahli K3 Umum') !== false) {
                            $skemaObj = Skema::where('jasa_id', $jasaId)->where('nama_skema', 'Ahli K3 Umum')->first();
                        } elseif (stripos($namaSkema, 'Ahli K3 Listrik') !== false) {
                            $skemaObj = Skema::where('jasa_id', $jasaId)->where('nama_skema', 'Ahli K3 Listrik')->first();
                        } elseif (stripos($namaSkema, 'Petugas P3K') !== false) {
                            $skemaObj = Skema::where('jasa_id', $jasaId)->where('nama_skema', 'Petugas P3K')->first();
                        }
                    }

                    $skemaId = $skemaObj ? $skemaObj->id : null;
                }
                break;
            }
        }

        // Cek apakah termasuk Kemnaker RI
        if (!$jasaId) {
            foreach ($schemaKemnaker as $schema) {
                if (
                    stripos($namaSkema, $schema) !== false ||
                    stripos($namaSkema, 'Kemnaker') !== false ||
                    stripos($namaSkema, 'Kemnaker RI') !== false
                ) {

                    $jasa = Jasa::where('nama_jasa', 'Kemnaker RI')->first();
                    if ($jasa) {
                        $jasaId = $jasa->id;

                        // Cari skema yang cocok
                        $skemaObj = Skema::where('jasa_id', $jasaId)
                            ->where(function ($q) use ($namaSkema) {
                                $q->where('nama_skema', 'LIKE', '%' . $namaSkema . '%')
                                    ->orWhereRaw('? LIKE CONCAT("%", nama_skema, "%")', [$namaSkema]);
                            })
                            ->first();

                        if (!$skemaObj) {
                            // Jika tidak ditemukan, coba cari berdasarkan keyword
                            if (stripos($namaSkema, 'Ahli K3 Umum') !== false) {
                                $skemaObj = Skema::where('jasa_id', $jasaId)->where('nama_skema', 'Ahli K3 Umum')->first();
                            } elseif (stripos($namaSkema, 'Ahli K3 Listrik') !== false) {
                                $skemaObj = Skema::where('jasa_id', $jasaId)->where('nama_skema', 'Ahli K3 Listrik')->first();
                            } elseif (stripos($namaSkema, 'Petugas P3K') !== false) {
                                $skemaObj = Skema::where('jasa_id', $jasaId)->where('nama_skema', 'Petugas P3K')->first();
                            }
                        }

                        $skemaId = $skemaObj ? $skemaObj->id : null;
                    }
                    break;
                }
            }
        }

        // Cek apakah termasuk ISO
        if (!$jasaId) {
            foreach ($schemaISO as $schema) {
                if (stripos($namaSkema, $schema) !== false || stripos($namaSkema, 'ISO') !== false) {
                    $jasa = Jasa::where('nama_jasa', 'ISO')->first();
                    if ($jasa) {
                        $jasaId = $jasa->id;

                        // Extract nomor ISO (9001, 14001, etc)
                        if (preg_match('/(\d{5})/', $namaSkema, $matches)) {
                            $isoNumber = $matches[1];
                            $skemaObj = Skema::where('jasa_id', $jasaId)
                                ->where('nama_skema', $isoNumber)
                                ->first();
                            $skemaId = $skemaObj ? $skemaObj->id : null;
                        }
                    }
                    break;
                }
            }
        }

        if (!$jasaId && isset($row['jasa'])) {
            $namaJasa = trim($row['jasa']);
            $jasa = Jasa::where('nama_jasa', 'LIKE', '%' . $namaJasa . '%')->first();
            if ($jasa) {
                $jasaId = $jasa->id;
            }
        }

        // Jika jasaId sudah ketemu tapi skemaId belum, coba cari skema berdasarkan nama_skema di row dan jasaId
        if ($jasaId && !$skemaId && !empty($namaSkema)) {
            $skemaObj = Skema::where('jasa_id', $jasaId)
                ->where(function ($q) use ($namaSkema) {
                    $q->where('nama_skema', 'LIKE', '%' . $namaSkema . '%')
                        ->orWhereRaw('? LIKE CONCAT("%", nama_skema, "%")', [$namaSkema]);
                })
                ->first();

            // Fallback khusus untuk Ahli K3 Umum jika tidak ketemu exact match
            if (!$skemaObj) {
                if (stripos($namaSkema, 'Ahli K3 Umum') !== false) {
                    $skemaObj = Skema::where('jasa_id', $jasaId)->where('nama_skema', 'Ahli K3 Umum')->first();
                } elseif (stripos($namaSkema, 'Ahli K3 Listrik') !== false) {
                    $skemaObj = Skema::where('jasa_id', $jasaId)->where('nama_skema', 'Ahli K3 Listrik')->first();
                } elseif (stripos($namaSkema, 'Petugas P3K') !== false) {
                    $skemaObj = Skema::where('jasa_id', $jasaId)->where('nama_skema', 'Petugas P3K')->first();
                }
            }

            $skemaId = $skemaObj ? $skemaObj->id : null;
        }

        // Jika tidak ada jasa yang terdeteksi, skip row ini
        if (!$jasaId) {
            return null;
        }

        // Jika skema kosong, skip row ini (karena validation kita buat nullable untuk handle empty row)
        if (empty($namaSkema)) {
            return null;
        }

        // Parse tanggal sertifikat terbit
        $sertifikatTerbit = null;
        if (!empty($row['sertifikat_terbit'])) {
            try {
                if (is_numeric($row['sertifikat_terbit'])) {
                    $sertifikatTerbit = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['sertifikat_terbit'])->format('Y-m-d');
                } else {
                    $sertifikatTerbit = Carbon::parse($row['sertifikat_terbit'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $sertifikatTerbit = null;
            }
        }

        // Parse tanggal lahir
        $tanggalLahir = null;
        if (!empty($row['tanggal_lahir'])) {
            try {
                if (is_numeric($row['tanggal_lahir'])) {
                    $tanggalLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');
                } else {
                    $tanggalLahir = Carbon::parse($row['tanggal_lahir'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $tanggalLahir = null;
            }
        }

        // Tentukan tahun dari sertifikat terbit atau tahun sekarang
        $tahun = $sertifikatTerbit ? Carbon::parse($sertifikatTerbit)->year : now()->year;

        // Tentukan tipe klien
        $tipeKlien = 'Perusahaan';
        if (isset($row['tipe_klien'])) {
            $tipeKlien = ucfirst(strtolower(trim($row['tipe_klien'])));
        } elseif (!empty($row['nama_klien'])) {
            $tipeKlien = 'Personal';
        }

        return new Klien([
            'user_id' => $this->userId,
            'jasa_id' => $jasaId,
            'skema_id' => $skemaId,
            'tahun' => $tahun,
            'tipe_klien' => $tipeKlien,
            'nama_klien' => $row['nama_klien'] ?? null,
            'nama_perusahaan' => $row['nama_perusahaan'] ?? null,
            'nama_penanggung_jawab' => $row['nama_penanggung_jawab'] ?? null,
            'email' => !empty($row['email']) ? trim($row['email']) : null,
            'no_whatsapp' => $row['no_whatsapp'] ?? null,
            'sertifikat_terbit' => $sertifikatTerbit,
            'tanggal_lahir' => $tanggalLahir,
        ]);
    }

    public function rules(): array
    {
        return [
            'skema' => 'nullable',
            'nama_klien' => 'nullable|string',
            'nama_perusahaan' => 'nullable|string',
            'nama_penanggung_jawab' => 'nullable|string',
            'email' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!$value) return;
                    $cleanValue = trim($value);
                    if ($cleanValue === '') return; // Allow whitespace-only (treated as null)

                    if (!filter_var($cleanValue, FILTER_VALIDATE_EMAIL)) {
                        $fail('Format email tidak valid (' . htmlspecialchars($cleanValue) . ')');
                    }
                }
            ],
            'no_whatsapp' => 'nullable|string',
            'sertifikat_terbit' => 'nullable',
            'tanggal_lahir' => 'nullable',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'skema.required' => 'Kolom skema tidak boleh kosong',
        ];
    }
}
