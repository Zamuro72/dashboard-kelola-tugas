<?php

namespace App\Exports;

use App\Models\Klien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NotifikasiAkanExpiredExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $userId;

    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    public function title(): string
    {
        return 'Akan Expired';
    }

    public function collection()
    {
        $query = Klien::akanExpired()->with(['jasa', 'skema']);

        if ($this->userId !== null) {
            $query->where('kliens.user_id', $this->userId);
        }

        return $query->orderBy('sertifikat_terbit')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Jasa',
            'Skema',
            'Tahun',
            'Tipe Klien',
            'Nama Klien',
            'Nama Perusahaan',
            'Nama Penanggung Jawab',
            'Email',
            'No WhatsApp',
            'Sertifikat Terbit',
            'Sertifikat Expired',
            'Sisa Hari',
        ];
    }

    public function map($klien): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $klien->jasa->nama_jasa ?? '-',
            $klien->skema->nama_skema ?? '-',
            $klien->tahun,
            $klien->tipe_klien,
            $klien->nama_klien ?? '-',
            $klien->nama_perusahaan ?? '-',
            $klien->nama_penanggung_jawab ?? '-',
            $klien->email ?? '-',
            $klien->no_whatsapp ?? '-',
            $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-',
            $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-',
            $klien->getSisaHariExpired() ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'f6c23e']
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 35,
            'D' => 10,
            'E' => 15,
            'F' => 25,
            'G' => 30,
            'H' => 25,
            'I' => 25,
            'J' => 15,
            'K' => 18,
            'L' => 18,
            'M' => 20,
        ];
    }
}
