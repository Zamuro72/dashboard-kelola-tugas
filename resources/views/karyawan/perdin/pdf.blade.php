<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulir Izin Perjalanan Dinas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
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

        .company-logo {
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
            margin: 25px 0;
            color: #333;
        }

        /* Content */
        .intro-text {
            margin-bottom: 15px;
        }

        .data-row {
            margin-bottom: 8px;
            padding-left: 20px;
        }

        .data-label {
            display: inline-block;
            width: 100px;
        }

        .data-value {
            display: inline-block;
            border-bottom: 1px dotted #999;
            min-width: 300px;
            padding-left: 10px;
        }

        .perdin-intro {
            margin: 20px 0 15px 0;
        }

        /* Table Rincian */
        .rincian-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .rincian-table td {
            border: 1px solid #333;
            padding: 8px 10px;
            vertical-align: top;
        }

        .rincian-table td:first-child {
            width: 180px;
            font-weight: normal;
        }

        /* Signature Table */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        .tanggal-cell {
            text-align: left;
            font-weight: bold;
        }

        /* Catatan */
        .catatan {
            margin-top: 25px;
            font-size: 10pt;
        }

        .catatan-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .catatan ul {
            padding-left: 20px;
            margin: 0;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="logo-and-name">
                <div class="logo-container">
                    <img src="{{ public_path('sbadmin2/img/undraw_profile.svg') }}" class="company-logo" alt="Logo">
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
    <div class="title">FORMULIR IZIN PERJALANAN DINAS</div>

    <!-- Intro -->
    <div class="intro-text">Yang bertanda tangan di bawah ini:</div>

    <div class="data-row">
        <span class="data-label">Nama</span>
        <span>:</span>
        <span class="data-value">{{ $perdin->user->nama }}</span>
    </div>

    <div class="data-row">
        <span class="data-label">Jabatan</span>
        <span>:</span>
        <span class="data-value">{{ $perdin->user->jabatan }}</span>
    </div>

    <div class="perdin-intro">
        Mengajukan izin untuk melaksanakan <strong>Perjalanan Dinas</strong> dengan rincian sebagai berikut:
    </div>

    <!-- Rincian Table -->
    <table class="rincian-table">
        <tr>
            <td>Tujuan Perjalanan</td>
            <td>: {{ $perdin->tujuan_perjalanan }}</td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td>: {{ $perdin->lokasi }}</td>
        </tr>
        <tr>
            <td>Tanggal Berangkat</td>
            <td>: {{ \Carbon\Carbon::parse($perdin->tanggal_berangkat)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Tanggal Kembali</td>
            <td>: {{ \Carbon\Carbon::parse($perdin->tanggal_kembali)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Transportasi</td>
            <td>: {{ $perdin->transportasi }}</td>
        </tr>
        <tr>
            <td>Uang Muka</td>
            <td>: Rp {{ number_format($perdin->uang_muka, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Signature Table -->
    <table class="signature-table">
        <tr>
            <td colspan="3" class="tanggal-cell">
                Tanggal: {{ \Carbon\Carbon::parse($perdin->created_at)->format('d F Y') }}
            </td>
        </tr>
        <tr>
            <th style="width: 33%">Dibuat oleh,</th>
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
                <div class="signature-name">( {{ $perdin->user->nama }} )</div>
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

    <!-- Catatan -->
    <div class="catatan">
        <div class="catatan-title">CATATAN:</div>
        <ul>
            <li>Formulir ini wajib diisi sebagai dasar verifikasi dan administrasi untuk penerbitan Surat Tugas Resmi Perjalanan Dinas.</li>
            <li>Maksimal 3 hari kerja penyelesaian.</li>
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
