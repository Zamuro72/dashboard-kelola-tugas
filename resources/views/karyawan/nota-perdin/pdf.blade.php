<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nota Perhitungan Perjalanan Dinas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
            padding: 15px;
        }

        /* Header */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }

        .logo-container {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

        .logo {
            width: 50px;
            height: 50px;
        }

        .company-info {
            display: inline-block;
            vertical-align: middle;
        }

        .company-name {
            font-size: 11pt;
            font-weight: bold;
            color: #000;
        }

        .company-tagline {
            font-size: 8pt;
            color: #666;
        }

        /* Title */
        .title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin: 15px 0;
            text-decoration: underline;
        }

        /* Info Section */
        .info-section {
            margin-bottom: 10px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 3px;
        }

        .info-label {
            display: table-cell;
            width: 120px;
        }

        .info-separator {
            display: table-cell;
            width: 10px;
        }

        .info-value {
            display: table-cell;
        }

        /* Table */
        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 9pt;
        }

        table.detail-table th,
        table.detail-table td {
            border: 1px solid #000;
            padding: 4px;
        }

        table.detail-table th {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: center;
        }

        table.detail-table td {
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Calculation Table */
        table.calc-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 9pt;
        }

        table.calc-table td {
            border: 1px solid #000;
            padding: 4px;
        }

        .bg-gray {
            background-color: #e0e0e0;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 20px;
            display: table;
            width: 100%;
        }

        .signature-box {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 5px;
        }

        .signature-space {
            height: 60px;
        }

        .signature-name {
            font-weight: bold;
            margin-top: 5px;
        }

        .signature-title {
            font-size: 9pt;
        }

        /* Footer */
        .footer-note {
            margin-top: 15px;
            font-size: 8pt;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="logo-container">
                <img src="{{ public_path('sbadmin2/img/undraw_profile.svg') }}" class="logo" alt="Logo">
            </div>
            <div class="company-info">
                <div class="company-name">PT KANDEL SEKECO INTERNASIONAL</div>
                <div class="company-tagline">Grow With Synergy</div>
            </div>
        </div>
    </div>

    <!-- Title -->
    <div class="title">NOTA PERHITUNGAN PERJALANAN DINAS</div>

    <!-- Info Karyawan -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Yang melakukan perjalanan dinas :</span>
        </div>
        <div class="info-row">
            <span class="info-label">Nama</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $nota->nama }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Unit Kerja</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $nota->unit_kerja }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Berangkat Tgl/ Jam</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $nota->tanggal_berangkat->format('d/m/Y') }} / {{ \Carbon\Carbon::parse($nota->jam_berangkat)->format('H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tujuan/ Keperluan</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $nota->tujuan_keperluan }}</span>
        </div>
        <div style="height: 5px;"></div>
        <div class="info-row">
            <span class="info-label">Jabatan</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $nota->jabatan }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Golongan</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $nota->unit_kerja }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kembali Tgl/ Jam</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $nota->tanggal_kembali->format('d/m/Y') }} / {{ \Carbon\Carbon::parse($nota->jam_kembali)->format('H:i') }}</span>
        </div>
    </div>

    <!-- Detail Biaya Table -->
    <table class="detail-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 60px;">Tanggal</th>
                <th style="width: 120px;">Keterangan</th>
                <th style="width: 70px;">Taxi/<br>Bensin/<br>Tol</th>
                <th style="width: 70px;">Pesawat/<br>KA/Bus</th>
                <th style="width: 60px;">Hotel</th>
                <th style="width: 60px;">Makan</th>
                <th style="width: 60px;">Lain-<br>lain</th>
                <th style="width: 75px;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @if($nota->detail_biaya && count($nota->detail_biaya) > 0)
                @foreach($nota->detail_biaya as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $detail['tanggal'] ? \Carbon\Carbon::parse($detail['tanggal'])->format('d/m/Y') : '' }}</td>
                    <td>{{ $detail['keterangan'] }}</td>
                    <td class="text-right">{{ number_format($detail['taxi_bensin_tol'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail['pesawat_ka_bus'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail['hotel'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail['makan'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail['lain_lain'], 0, ',', '.') }}</td>
                    <td class="text-right font-bold">{{ number_format($detail['jumlah'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
                @for($i = count($nota->detail_biaya); $i < 8; $i++)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endfor
            @else
                @for($i = 0; $i < 8; $i++)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endfor
            @endif
            <tr class="bg-gray">
                <td colspan="8" class="text-right font-bold">Sub Total Biaya :</td>
                <td class="text-right font-bold">{{ number_format($nota->sub_total_biaya, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Calculation Table -->
    <table class="calc-table">
        <tr>
            <td style="width: 250px;">KM Kendaraan :</td>
            <td style="width: 100px;" class="text-center">{{ $nota->km_kendaraan }} KM</td>
            <td style="width: 50px;" class="text-center">x Rp.</td>
            <td style="width: 100px;" class="text-right">{{ number_format($nota->km_kendaraan > 0 ? $nota->km_x_rp / $nota->km_kendaraan : 0, 0, ',', '.') }}</td>
            <td style="width: 30px;" class="text-center">=</td>
            <td class="text-right font-bold">{{ number_format($nota->km_x_rp, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Uang Saku/ Tunjangan Lainnya yang menjadi hak karyawan/ hari</td>
            <td class="text-center">{{ $nota->uang_saku_hari }} Hari</td>
            <td class="text-center">x Rp.</td>
            <td class="text-right">{{ number_format($nota->uang_saku_hari > 0 ? $nota->hari_x_rp / $nota->uang_saku_hari : 0, 0, ',', '.') }}</td>
            <td class="text-center">=</td>
            <td class="text-right font-bold">{{ number_format($nota->hari_x_rp, 0, ',', '.') }}</td>
        </tr>
        <tr class="bg-gray">
            <td colspan="5" class="text-right font-bold">Sub Total</td>
            <td class="text-right font-bold">{{ number_format($nota->sub_total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right font-bold">Potongan Uang Muka</td>
            <td class="text-right font-bold">{{ number_format($nota->potongan_uang_muka, 0, ',', '.') }}</td>
        </tr>
        <tr class="bg-gray">
            <td colspan="5" class="text-right font-bold">Total</td>
            <td class="text-right font-bold">{{ number_format($nota->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div>{{ $nota->lokasi_pengajuan }},</div>
            <div style="margin-bottom: 5px;">Diajukan oleh</div>
            <div class="signature-space"></div>
            <div class="signature-name">( {{ $nota->nama }} )</div>
        </div>
        <div class="signature-box">
            <div>&nbsp;</div>
            <div style="margin-bottom: 5px;">Disetujui oleh</div>
            <div class="signature-space"></div>
            <div class="signature-name">( Mustika )</div>
            <div class="signature-title">Atasan Ybs.</div>
        </div>
        <div class="signature-box">
            <div>&nbsp;</div>
            <div style="margin-bottom: 5px;">Diterima oleh</div>
            <div class="signature-space"></div>
            <div class="signature-name">( Zian Amellia )</div>
            <div class="signature-title">Administrasi</div>
        </div>
    </div>

    <!-- Footer Note -->
    <div class="footer-note">
        Catatan : Yang berwenang menyetujui minimal level manager.
    </div>
</body>
</html>