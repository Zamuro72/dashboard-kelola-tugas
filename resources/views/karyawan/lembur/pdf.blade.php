<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Pengajuan Lembur</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
            padding: 20px 30px;
        }

        /* Header */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #8B7355;
            padding-bottom: 10px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
            text-align: right;
            font-size: 9pt;
            color: #666;
        }

        .logo-and-name {
            display: inline-block;
            vertical-align: middle;
        }

        .logo-container {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

        .logo {
            width: 40px;
            height: 40px;
        }

        .company-name-container {
            display: inline-block;
            vertical-align: middle;
        }

        .company-name {
            font-size: 12pt;
            font-weight: bold;
            color: #8B7355;
        }

        /* Title */
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0;
            color: #333;
        }

        /* Sections */
        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .section-content {
            padding-left: 20px;
        }

        /* Data table */
        .data-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }

        .data-label {
            display: table-cell;
            width: 180px;
            padding-right: 10px;
        }

        .data-separator {
            display: table-cell;
            width: 20px;
        }

        .data-value {
            display: table-cell;
            border-bottom: 1px dotted #999;
        }

        /* Uraian section */
        .uraian-box {
            border: 1px solid #ccc;
            min-height: 80px;
            padding: 10px;
            margin-top: 5px;
        }

        .dotted-lines {
            border-bottom: 1px dotted #999;
            min-height: 20px;
            margin-bottom: 5px;
        }

        /* Persetujuan section */
        .persetujuan-text {
            margin-bottom: 15px;
            text-align: justify;
            padding-left: 20px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .signature-table th,
        .signature-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        .signature-table th {
            background-color: #f5f5f5;
            font-weight: normal;
        }

        .signature-space {
            height: 60px;
        }

        .signature-name {
            font-weight: bold;
        }

        .signature-position {
            font-size: 10pt;
        }

        /* Catatan */
        .catatan {
            margin-top: 20px;
            font-size: 10pt;
        }

        .catatan-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .catatan ul {
            padding-left: 20px;
        }

        .catatan li {
            margin-bottom: 3px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 20px;
            left: 30px;
            right: 30px;
            display: table;
            width: calc(100% - 60px);
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .footer-left {
            display: table-cell;
            text-align: left;
        }

        .footer-right {
            display: table-cell;
            text-align: right;
            font-style: italic;
        }

        .tanggal-row {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="logo-and-name">
                <div class="logo-container">
                    <img src="{{ public_path('sbadmin2/img/undraw_profile.svg') }}" class="logo" alt="Logo">
                </div>
                <div class="company-name-container">
                    <span class="company-name">PT Kandel Sekeco Internasional</span>
                </div>
            </div>
        </div>
        <div class="header-right">
            Ruko Kawasan Niaga Citra Grand Cibubur<br>
            Jl. Alternatif Cibubur No.10 Blok R12, RT.002/RW.008,<br>
            Jatisampurna, Kec. Jatisampurna, Kota Bekasi, Jawa Barat 17435<br>
            0821-5116-0019 / 0812-3484-6680
        </div>
    </div>

    <!-- Title -->
    <div class="title">SURAT PENGAJUAN LEMBUR (SPL)</div>

    <!-- I. Data Karyawan -->
    <div class="section">
        <div class="section-title">I. DATA KARYAWAN</div>
        <div class="section-content">
            <div class="data-row">
                <span class="data-label">Nama Karyawan</span>
                <span class="data-separator">:</span>
                <span class="data-value">{{ $lembur->user->nama }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Jabatan</span>
                <span class="data-separator">:</span>
                <span class="data-value">{{ $lembur->user->jabatan }}</span>
            </div>
        </div>
    </div>

    <!-- II. Waktu dan Tempat Lembur -->
    <div class="section">
        <div class="section-title">II. WAKTU DAN TEMPAT LEMBUR</div>
        <div class="section-content">
            <div class="data-row">
                <span class="data-label">Tanggal Pelaksanaan</span>
                <span class="data-separator">:</span>
                <span class="data-value">{{ \Carbon\Carbon::parse($lembur->tanggal_pelaksanaan)->format('d F Y') }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Hari</span>
                <span class="data-separator">:</span>
                <span class="data-value">{{ $lembur->hari }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Jam Kerja Normal</span>
                <span class="data-separator">:</span>
                <span class="data-value">{{ \Carbon\Carbon::parse($lembur->jam_kerja_mulai)->format('H:i') }} s.d. {{ \Carbon\Carbon::parse($lembur->jam_kerja_selesai)->format('H:i') }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Jam Lembur</span>
                <span class="data-separator">:</span>
                <span class="data-value">{{ \Carbon\Carbon::parse($lembur->jam_lembur_mulai)->format('H:i') }} s.d. {{ \Carbon\Carbon::parse($lembur->jam_lembur_selesai)->format('H:i') }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Total Jam Lembur</span>
                <span class="data-separator">:</span>
                <span class="data-value">{{ abs(intval($lembur->total_jam_lembur)) }} Jam</span>
            </div>
            <div class="data-row">
                <span class="data-label">Lokasi / Tempat Kerja</span>
                <span class="data-separator">:</span>
                <span class="data-value">{{ $lembur->lokasi }}</span>
            </div>
        </div>
    </div>

    <!-- III. Uraian Pekerjaan -->
    <div class="section">
        <div class="section-title">III. URAIAN PEKERJAAN YANG DILAKSANAKAN</div>
        <div class="uraian-box">
            {{ $lembur->uraian_pekerjaan }}
        </div>
    </div>

    <!-- IV. Persetujuan dan Pernyataan -->
    <div class="section">
        <div class="section-title">IV. PERSETUJUAN DAN PERNYATAAN</div>
        <div class="persetujuan-text">
            Dengan ini karyawan yang bersangkutan menyetujui untuk melaksanakan kerja lembur sesuai dengan ketentuan Peraturan Kementerian Ketenagakerjaan dan peraturan perusahaan.
        </div>

        <table class="signature-table">
            <tr>
                <td colspan="3" style="text-align: left; font-weight: bold;">
                    Tanggal: {{ \Carbon\Carbon::parse($lembur->created_at)->format('d F Y') }}
                </td>
            </tr>
            <tr>
                <th style="width: 33%">Diajukan oleh,</th>
                <th style="width: 33%">Direview oleh,</th>
                <th style="width: 33%">Disetujui oleh,</th>
            </tr>
            <tr>
                <td class="signature-space"></td>
                <td class="signature-space"></td>
                <td class="signature-space"></td>
            </tr>
            <tr>
                <td>
                    <div class="signature-name">( {{ $lembur->user->nama }} )</div>
                    <div class="signature-position">{{ $lembur->user->jabatan }}</div>
                </td>
                <td>
                    <div class="signature-name">( Zian Amellia )</div>
                    <div class="signature-position">HRGA</div>
                </td>
                <td>
                    <div class="signature-name">( Mustika )</div>
                    <div class="signature-position">Direktur</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Catatan -->
    <div class="catatan">
        <div class="catatan-title">Catatan:</div>
        <ul>
            <li>Formulir ini harus dibuat sebelum lembur dilaksanakan.</li>
            <li>Salinan SPL disampaikan kepada karyawan, atasan langsung.</li>
            <li>Besaran upah lembur dihitung sesuai Peraturan Menteri Ketenagakerjaan No. 102 Tahun 2004 dan SK Direksi PT Kandel Sekeco International tentang uang lembur.</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-left">
            @kandelsekeco | kandel sekeco internasional
        </div>
        <div class="footer-right">
            Grow With Synergy
        </div>
    </div>
</body>
</html>
