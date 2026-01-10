<table>
    <thead>
        <tr>
            <th colspan="10" align="center">Data Peserta Tahun {{ $tahun }}</th>
        </tr>
        <tr>
            <th colspan="10" align="center">Tanggal: {{ $tanggal }}</th>
        </tr>
        <tr>
            <th colspan="10" align="center">Pukul: {{ $jam }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th width="5" align="center">No</th>
            <th width="20" align="center">Nama</th>
            <th width="20" align="center">Perusahaan</th>
            <th width="15" align="center">No WhatsApp</th>
            <th width="15" align="center">Tgl Lahir</th>
            <th width="20" align="center">Skema</th>
            <th width="15" align="center">Tgl Sertifikat</th>
            <th width="15" align="center">Tgl Expired</th>
            <th width="15" align="center">Status</th>
            <th width="15" align="center">Telat Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peserta as $item)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->nama_perusahaan }}</td>
            <td>{{ $item->no_whatsapp }}</td>
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