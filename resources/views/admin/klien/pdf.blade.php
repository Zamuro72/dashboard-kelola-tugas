<!DOCTYPE html>
<html>
<head>
    <title>Data Klien - {{ $jasa->nama_jasa }}</title>
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
            background-color: #4e73df;
            color: white;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge-success {
            background-color: #1cc88a;
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
        }
        .badge-warning {
            background-color: #f6c23e;
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
        }
        .badge-danger {
            background-color: #e74a3b;
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
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
        <h3>Data Klien - {{ $jasa->nama_jasa }}</h3>
        @if($skema)
            <p>Skema: {{ $skema->nama_skema }}</p>
        @endif
        <p>Tahun: {{ $tahun }}</p>
    </div>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ $tanggal }} | {{ $jam }}</p>
        <p><strong>Total Data:</strong> {{ $kliens->count() }} klien</p>
        <p><strong>Masa Berlaku Sertifikat:</strong> {{ $jasa->masa_berlaku_tahun }} Tahun</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="8%">Tipe</th>
                <th width="15%">Nama Klien/Perusahaan</th>
                <th width="12%">Penanggung Jawab</th>
                <th width="15%">Email</th>
                <th width="10%">No WA</th>
                <th width="10%">Sertifikat Terbit</th>
                <th width="10%">Sertifikat Expired</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kliens as $index => $klien)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $klien->tipe_klien }}</td>
                    <td>
                        @if($klien->tipe_klien == 'Personal')
                            {{ $klien->nama_klien }}
                            @if($klien->nama_perusahaan)
                                <br><small>({{ $klien->nama_perusahaan }})</small>
                            @endif
                        @else
                            {{ $klien->nama_perusahaan }}
                        @endif
                    </td>
                    <td>{{ $klien->nama_penanggung_jawab ?? '-' }}</td>
                    <td>{{ $klien->email ?? '-' }}</td>
                    <td>{{ $klien->no_whatsapp ?? '-' }}</td>
                    <td>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</td>
                    <td>{{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}</td>
                    <td>
                        @if($klien->isSertifikatExpired())
                            <span class="badge-danger">Expired</span>
                        @elseif($klien->isSertifikatAkanExpired())
                            <span class="badge-warning">Akan Expired</span>
                        @else
                            <span class="badge-success">Aktif</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->nama }} | {{ auth()->user()->jabatan }}</p>
    </div>
</body>
</html>