<?php

namespace App\Imports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class PesertaImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $tahun;

    public function __construct($tahun = null)
    {
        $this->tahun = $tahun;
    }

    public function model(array $row)
    {
        // Gunakan tahun dari parameter jika ada, jika tidak gunakan dari row
        $tahunValue = $this->tahun ?? $row['tahun'];
        
        return new Peserta([
            'tahun'                        => $tahunValue,
            'nama'                         => $row['nama'],
            'nama_perusahaan'              => $row['nama_perusahaan'],
            'no_whatsapp'                  => $row['no_whatsapp'],
            'tanggal_lahir'                => Carbon::createFromFormat('Y-m-d', $row['tanggal_lahir']),
            'skema'                        => $row['skema'],
            'tanggal_sertifikat_diterima'  => Carbon::createFromFormat('Y-m-d', $row['tanggal_sertifikat_diterima']),
            'suka_telat_bayar'             => strtolower($row['suka_telat_bayar']) === 'ya' ? true : false,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.tahun'                        => 'required|digits:4',
            '*.nama'                         => 'required|string',
            '*.nama_perusahaan'              => 'required|string',
            '*.no_whatsapp'                  => 'required|string',
            '*.tanggal_lahir'                => 'required|date_format:Y-m-d',
            '*.skema'                        => 'required|string',
            '*.tanggal_sertifikat_diterima'  => 'required|date_format:Y-m-d',
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
