<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat Sudah Expired</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .header h3 {
            margin: 5px 0;
            color: #e74a3b;
        }
        .info {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        table th {
            background-color: #e74a3b;
            color: #fff;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PT KANDEL SEKECO INTERNASIONAL</h2>
        <h3>Sertifikat Sudah Expired</h3>
        <p>Tanggal Cetak: {{ $tanggal }} | {{ $jam }}</p>
    </div>

    <div class="info">
        <p><strong>Total Data:</strong> {{ $kliens->count() }} klien</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%" class="text-center">No</th>
                <th width="8%">Jasa</th>
                <th width="14%">Skema</th>
                <th width="6%">Tahun</th>
                <th width="7%">Tipe</th>
                <th width="15%">Nama Klien/Perusahaan</th>
                <th width="14%">Email</th>
                <th width="10%">No WA</th>
                <th width="9%">Sert. Terbit</th>
                <th width="9%">Sert. Expired</th>
                <th width="5%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kliens as $index => $klien)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $klien->jasa->nama_jasa ?? '-' }}</td>
                    <td>{{ $klien->skema->nama_skema ?? '-' }}</td>
                    <td>{{ $klien->tahun }}</td>
                    <td>{{ $klien->tipe_klien }}</td>
                    <td>
                        @if($klien->tipe_klien == 'Personal')
                            {{ $klien->nama_klien }}
                            @if($klien->nama_perusahaan)
                                <br><small>({{ $klien->nama_perusahaan }})</small>
                            @endif
                        @else
                            {{ $klien->nama_perusahaan }}
                            @if($klien->nama_penanggung_jawab)
                                <br><small>PJ: {{ $klien->nama_penanggung_jawab }}</small>
                            @endif
                        @endif
                    </td>
                    <td>{{ $klien->email ?? '-' }}</td>
                    <td>{{ $klien->no_whatsapp ?? '-' }}</td>
                    <td>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</td>
                    <td>{{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}</td>
                    <td class="text-center">{{ $klien->getSisaHariExpired() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->nama }} | {{ auth()->user()->jabatan }}</p>
    </div>
</body>
</html>
