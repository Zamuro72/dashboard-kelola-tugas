<h1 align="center">Data Peserta Tahun {{ $tahun }}</h1>
<h3 align="center">Tanggal: {{ $tanggal }}</h3>
<h3 align="center">Pukul: {{ $jam }}</h3>
<hr>
<table width="100%" border="1px" style="border-collapse: collapse">
    <thead>
        <tr>
            <th width="3%" align="center">No</th>
            <th width="12%" align="center">Nama</th>
            <th width="12%" align="center">Perusahaan</th>
            <th width="10%" align="center">No WA</th>
            <th width="8%" align="center">Tgl Lahir</th>
            <th width="12%" align="center">Skema</th>
            <th width="10%" align="center">Tgl Sertifikat</th>
            <th width="10%" align="center">Tgl Expired</th>
            <th width="10%" align="center">Status</th>
            <th width="8%" align="center">Telat Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peserta as $item)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->nama_perusahaan }}</td>
            <td align="center">{{ $item->no_whatsapp }}</td>
            <td align="center">{{ $item->tanggal_lahir->format('d-m-Y') }}</td>
            <td>{{ $item->skema }}</td>
            <td align="center">{{ $item->tanggal_sertifikat_diterima->format('d-m-Y') }}</td>
            <td align="center">{{ $item->tanggal_expired->format('d-m-Y') }}</td>
            <td align="center">
                @if($item->isSertifikatExpired())
                    Sudah Expired
                @elseif($item->isSertifikatAkanExpired())
                    Akan Expired
                @else
                    Aktif
                @endif
            </td>
            <td align="center">{{ $item->suka_telat_bayar ? 'Ya' : 'Tidak' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>