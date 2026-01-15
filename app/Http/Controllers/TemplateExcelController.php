<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TemplateExcelController extends Controller
{
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);

        // Header row
        $headers = ['tahun', 'nama', 'nama_perusahaan', 'no_whatsapp', 'tanggal_lahir', 'skema', 'tanggal_sertifikat_diterima', 'suka_telat_bayar'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'border' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];

        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Add sample data
        $sampleData = [
            [2025, 'Budi Santoso', 'PT Maju Jaya', '08123456789', '2000-01-15', 'BNSP', '2023-01-15', 'Tidak'],
            [2025, 'Siti Nurhaliza', 'PT Sukses Bersama', '+628234567890', '1995-05-20', 'Kemnaker RI', '2023-06-10', 'Ya'],
            [2025, 'Ahmad Wijaya', 'CV Bintang Terang', '08345678901', '1998-12-03', 'BNSP', '2023-03-22', 'Tidak'],
        ];

        $sheet->fromArray($sampleData, NULL, 'A2');

        // Style data rows
        $dataStyle = [
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
            'border' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];

        $sheet->getStyle('A2:H4')->applyFromArray($dataStyle);

        // Center align for specific columns
        $sheet->getStyle('A2:A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D2:D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2:E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2:G4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H2:H4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Add notes sheet
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Panduan');

        $sheet2->setCellValue('A1', 'PANDUAN IMPORT DATA PESERTA');
        $sheet2->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $notes = [
            '',
            'KOLOM-KOLOM YANG DIPERLUKAN:',
            '',
            'No | Nama Kolom | Tipe Data | Contoh | Keterangan',
            '1 | tahun | Angka (4 digit) | 2025 | Tahun peserta sertifikasi',
            '2 | nama | Teks | Budi Santoso | Nama lengkap peserta',
            '3 | nama_perusahaan | Teks | PT Maju Jaya | Nama perusahaan tempat bekerja',
            '4 | no_whatsapp | Teks/Angka | 08123456789 | Nomor WhatsApp yang aktif',
            '5 | tanggal_lahir | Tanggal YYYY-MM-DD | 2000-01-15 | Format: 2000-01-15 (Tahun-Bulan-Hari)',
            '6 | skema | Teks | BNSP | Pilihan: BNSP atau Kemnaker RI',
            '7 | tanggal_sertifikat_diterima | Tanggal YYYY-MM-DD | 2023-01-15 | Format: 2023-01-15 (Tahun-Bulan-Hari)',
            '8 | suka_telat_bayar | Teks (Ya/Tidak) | Ya | Pilihan: Ya atau Tidak',
            '',
            'ATURAN PENGISIAN:',
            '- Semua kolom WAJIB diisi, tidak boleh kosong',
            '- Header harus PERSIS sesuai dengan nama kolom di atas',
            '- Format tanggal harus YYYY-MM-DD (contoh: 2023-01-15)',
            '- Kolom suka_telat_bayar hanya boleh "Ya" atau "Tidak"',
            '- Baris pertama adalah header, data mulai dari baris kedua',
            '- Maksimal file 5MB',
            '- Format file: .xlsx, .xls, atau .csv',
        ];

        $row = 3;
        foreach ($notes as $note) {
            $sheet2->setCellValue('A' . $row, $note);
            $row++;
        }

        $sheet2->getColumnDimension('A')->setWidth(50);

        // Save file
        $writer = new Xlsx($spreadsheet);
        $filename = 'Template_Import_Peserta_' . date('d-m-Y') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
