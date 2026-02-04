<?php

namespace App\Exports;

use App\Models\Klien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KlienExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $userId;
    protected $jasaId;
    protected $tahun;
    protected $skemaId;

    public function __construct($userId, $jasaId, $tahun, $skemaId = null)
    {
        $this->userId = $userId;
        $this->jasaId = $jasaId;
        $this->tahun = $tahun;
        $this->skemaId = $skemaId;
    }

    public function collection()
    {
        $query = Klien::with(['jasa', 'skema'])
            ->where('user_id', $this->userId)
            ->where('jasa_id', $this->jasaId)
            ->where('tahun', $this->tahun);

        if ($this->skemaId) {
            $query->where('skema_id', $this->skemaId);
        }

        return $query->orderBy('created_at', 'desc')->get();
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
            'Status',
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
            $klien->isSertifikatExpired() ? 'Sudah Expired' : ($klien->isSertifikatAkanExpired() ? 'Akan Expired' : 'Aktif'),
            $klien->getSisaHariExpired() ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4e73df']
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ]
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
            'M' => 15,
            'N' => 20,
        ];
    }
}