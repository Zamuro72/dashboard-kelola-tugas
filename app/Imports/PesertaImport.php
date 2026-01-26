<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Peserta;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PesertaImport implements ToModel, WithHeadingRow, WithMapping, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
    protected $tahun;
    private $lastNamaPerusahaan;
    private $lastSkema;
    private $failures = [];

    public function __construct($tahun = null)
    {
        $this->tahun = $tahun;
    }

    /**
     * Helper to parse date from various formats
     */
    private function parseDate($value)
    {
        if (empty($value)) return null;

        try {
            // 1. Try Excel Serial Date (numeric)
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
            }

            // 2. Try generic Carbon parse (handles Y-m-d, m/d/Y, d-m-Y, etc.)
            return Carbon::parse($value);
        } catch (\Exception $e) {
            try {
                // 3. Try specifically for Indonesian format d/m/Y if needed
                return Carbon::createFromFormat('d/m/Y', $value);
            } catch (\Exception $e2) {
                // Return null if all fails
                return null;
            }
        }
    }

    /**
     * Validate and clean email
     */
    private function cleanEmail($email)
    {
        if (empty($email)) {
            return null;
        }

        $email = trim((string)$email);
        
        // If empty after trim
        if ($email === '') {
            return null;
        }

        // Basic email validation
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }

        // If not valid email, return null instead of error
        return null;
    }

    /**
     * @param array $row
     *
     * @return array
     */
    public function map($row): array
    {
        // 0. Ignore empty rows (based on Nama)
        if (empty($row['nama'])) {
            return $row;
        }

        // 1. Handle Fill Down for Nama Perusahaan (Merged Cells)
        if (!empty($row['nama_perusahaan'])) {
            $this->lastNamaPerusahaan = $row['nama_perusahaan'];
        } elseif ($this->lastNamaPerusahaan) {
            $row['nama_perusahaan'] = $this->lastNamaPerusahaan;
        }

        // 2. Handle Fill Down for Skema (Merged Cells)
        if (!empty($row['skema'])) {
            $this->lastSkema = $row['skema'];
        } elseif ($this->lastSkema) {
            $row['skema'] = $this->lastSkema;
        }

        // 3. Handle Tahun from Filename
        if (empty($row['tahun']) && $this->tahun) {
            $row['tahun'] = $this->tahun;
        }

        // 4. Sanitize WhatsApp number (Pre-validation)
        if (isset($row['no_whatsapp'])) {
            $val = (string)$row['no_whatsapp'];
            if (str_starts_with($val, "'")) {
                $val = substr($val, 1);
            }
            $row['no_whatsapp'] = $val;
        }

        // 5. Clean email field - validate and clean
        $row['email'] = $this->cleanEmail($row['email'] ?? null);

        return $row;
    }

    public function model(array $row)
    {
        // 0. Filter Empty Rows Manually
        if (empty($row['nama'])) {
            return null;
        }

        // Tahun sudah di-handle di map()
        $tahunValue = $row['tahun'] ?? $this->tahun;

        // Validasi Manual: Tahun wajib ada untuk row yang valid
        if (empty($tahunValue)) {
            // Skip row instead of throwing error
            return null;
        }

        // Handle parsing tanggal
        $tanggalLahir = $this->parseDate($row['tanggal_lahir']);
        $tanggalSertifikat = $this->parseDate($row['tanggal_sertifikat_diterima']);

        return new Peserta([
            'tahun'                        => $tahunValue,
            'nama'                         => $row['nama'],
            'nama_perusahaan'              => $row['nama_perusahaan'] ?? null,
            'email'                        => $row['email'], // Already cleaned and validated
            'no_whatsapp'                  => $row['no_whatsapp'] ?? null,
            'tanggal_lahir'                => $tanggalLahir,
            'skema'                        => $row['skema'] ?? null,
            'tanggal_sertifikat_diterima'  => $tanggalSertifikat,
            'suka_telat_bayar'             => isset($row['suka_telat_bayar']) && strtolower($row['suka_telat_bayar']) === 'ya' ? true : false,
        ]);
    }

    /**
     * Handle errors
     */
    public function onError(\Throwable $e)
    {
        // Log error but don't stop import
        Log::error('Import error: ' . $e->getMessage());
    }

    /**
     * Handle validation failures
     */
    public function onFailure(Failure ...$failures)
    {
        $this->failures = array_merge($this->failures, $failures);
    }

    /**
     * Get failures
     */
    public function getFailures()
    {
        return $this->failures;
    }
}