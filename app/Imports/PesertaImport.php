<?php

namespace App\Imports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PesertaImport implements ToModel, WithHeadingRow, WithValidation, WithMapping, SkipsEmptyRows
{
    protected $tahun;
    private $lastNamaPerusahaan;
    private $lastSkema;

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
            // We do this FIRST because Carbon::parse(numeric) interprets it as Timestamp (1970)
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
     * @param array $row
     *
     * @return array
     */
    public function map($row): array
    {
        // 0. Ignore empty rows (based on Nama)
        // If nama is empty, we don't fill down, so it remains empty and Excel will ignore it.
        // Or if it's passed validations, it will fail on 'nama required' anyway but we shouldn't fill down.
        if (empty($row['nama'])) {
            return $row;
        }

        // 1. Handle Fill Down for Nama Perusahaan (Merged Cells)
        // Jika ada isi, update last value. Jika kosong, pakai last value (jika ada).
        if (!empty($row['nama_perusahaan'])) {
            $this->lastNamaPerusahaan = $row['nama_perusahaan'];
        } elseif ($this->lastNamaPerusahaan) {
            $row['nama_perusahaan'] = $this->lastNamaPerusahaan;
        }

        // 2. Handle Fill Down for Skema (Merged Cells)
        // Jika ada isi, update last value. Jika kosong, pakai last value (jika ada).
        if (!empty($row['skema'])) {
            $this->lastSkema = $row['skema'];
        } elseif ($this->lastSkema) {
            $row['skema'] = $this->lastSkema;
        }

        // 3. Handle Tahun from Filename
        // Jika di excel kosong, tapi kita punya tahun dari filename, pakai itu.
        if (empty($row['tahun']) && $this->tahun) {
            $row['tahun'] = $this->tahun;
        }

        // 4. Sanitize WhatsApp number (Pre-validation)
        // Remove leading ' if exists and ensure it is a string
        if (isset($row['no_whatsapp'])) {
            $val = (string)$row['no_whatsapp'];
            if (str_starts_with($val, "'")) {
                $val = substr($val, 1);
            }
            $row['no_whatsapp'] = $val;
        }

        return $row;
    }

    public function model(array $row)
    {
        // 0. Filter Empty Rows Manually
        // Rows with empty Name are considered noise/garbage (e.g. only Row Number filled)
        if (empty($row['nama'])) {
            return null;
        }

        // Tahun sudah di-handle di map(), tapi untuk aman:
        $tahunValue = $row['tahun'] ?? $this->tahun;

        // Validasi Manual: Tahun wajib ada untuk row yang valid (berlama)
        if (empty($tahunValue)) {
            // Kita bisa skip atau lempar error.
            // Karena user ingin "detect otomatis", jika gagal deteksi dan kolom kosong = Error.
            throw new \Exception("Tahun tidak ditemukan untuk peserta: " . $row['nama'] . ". Pastikan nama file mengandung tahun 4 digit atau kolom tahun diisi.");
        }

        // Handle parsing tanggal yang mungkin kosong atau format berbeda
        $tanggalLahir = $this->parseDate($row['tanggal_lahir']);
        $tanggalSertifikat = $this->parseDate($row['tanggal_sertifikat_diterima']);

        return new Peserta([
            'tahun'                        => $tahunValue,
            'nama'                         => $row['nama'],
            'nama_perusahaan'              => $row['nama_perusahaan'],
            'email'                        => $row['email'] ?? null,
            'no_whatsapp'                  => $row['no_whatsapp'],
            'tanggal_lahir'                => $tanggalLahir,
            'skema'                        => $row['skema'],
            'tanggal_sertifikat_diterima'  => $tanggalSertifikat,
            'suka_telat_bayar'             => strtolower($row['suka_telat_bayar']) === 'ya' ? true : false,
        ]);
    }

    public function rules(): array
    {
        return [
            // Relaxed rules to allow filtering in model()
            '*.tahun'                        => 'nullable',
            '*.nama'                         => 'nullable|string',
            '*.nama_perusahaan'              => 'nullable|string',
            '*.email'                        => 'nullable|email',
            '*.no_whatsapp'                  => 'nullable|string',
            // Relax date validation because we are parsing it manually. 
            // 'date' rule might fail for weird formats like "Friday, ..." before we parse it.
            // So we might just check if it's not empty if we wanted required, 
            // but here it is nullable anyway.
            '*.tanggal_lahir'                => 'nullable',
            '*.skema'                        => 'nullable|string',
            '*.tanggal_sertifikat_diterima'  => 'nullable',
            '*.suka_telat_bayar'             => 'required|in:Ya,Tidak,ya,tidak',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.tahun.required'                        => 'Tahun tidak boleh kosong',
            '*.tahun.digits'                          => 'Tahun harus 4 digit (YYYY)',
            '*.nama.required'                         => 'Nama tidak boleh kosong',
            '*.nama.string'                           => 'Nama harus berupa teks',
            '*.nama_perusahaan.required'              => 'Nama perusahaan tidak boleh kosong',
            '*.nama_perusahaan.string'                => 'Nama perusahaan harus berupa teks',
            '*.no_whatsapp.required'                  => 'No WhatsApp tidak boleh kosong',
            '*.no_whatsapp.string'                    => 'No WhatsApp harus berupa teks',
            '*.tanggal_lahir.required'                => 'Tanggal lahir tidak boleh kosong',
            '*.tanggal_lahir.date_format'             => 'Format tanggal lahir harus Y-m-d (2000-01-15)',
            '*.skema.required'                        => 'Skema tidak boleh kosong',
            '*.skema.string'                          => 'Skema harus berupa teks',
            '*.tanggal_sertifikat_diterima.required'  => 'Tanggal sertifikat diterima tidak boleh kosong',
            '*.tanggal_sertifikat_diterima.date_format' => 'Format tanggal sertifikat harus Y-m-d (2023-01-15)',
            '*.suka_telat_bayar.required'             => 'Suka telat bayar tidak boleh kosong',
            '*.suka_telat_bayar.in'                   => 'Suka telat bayar hanya boleh isi dengan "Ya" atau "Tidak"',
        ];
    }
}
