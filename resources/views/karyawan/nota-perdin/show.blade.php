@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-file-invoice mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-info d-flex justify-content-between align-items-center">
        <a href="{{ route('notaPerdin') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
        <a href="{{ route('notaPerdinPdf', $nota->id) }}" target="_blank" class="btn btn-sm btn-danger">
            <i class="fas fa-file-pdf mr-2"></i>
            Export PDF
        </a>
    </div>
    <div class="card-body">
        <!-- Header -->
        <div class="text-center mb-4">
            <h4 class="font-weight-bold">NOTA PERHITUNGAN PERJALANAN DINAS</h4>
        </div>

        <!-- Data Karyawan -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-user mr-2"></i>
                Yang Melakukan Perjalanan Dinas
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="200"><strong>Nama</strong></td>
                        <td width="20">:</td>
                        <td>{{ $nota->nama }}</td>
                        <td width="200"><strong>Jabatan</strong></td>
                        <td width="20">:</td>
                        <td>{{ $nota->jabatan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Unit Kerja</strong></td>
                        <td>:</td>
                        <td>{{ $nota->unit_kerja }}</td>
                        <td><strong>Golongan</strong></td>
                        <td>:</td>
                        <td>{{ $nota->unit_kerja }}</td>
                    </tr>
                    <tr>
                        <td><strong>Berangkat Tgl/Jam</strong></td>
                        <td>:</td>
                        <td>{{ $nota->tanggal_berangkat->format('d/m/Y') }} / {{ \Carbon\Carbon::parse($nota->jam_berangkat)->format('H:i') }}</td>
                        <td><strong>Kembali Tgl/Jam</strong></td>
                        <td>:</td>
                        <td>{{ $nota->tanggal_kembali->format('d/m/Y') }} / {{ \Carbon\Carbon::parse($nota->jam_kembali)->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tujuan/Keperluan</strong></td>
                        <td>:</td>
                        <td colspan="4">{{ $nota->tujuan_keperluan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Detail Biaya -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-table mr-2"></i>
                Detail Biaya
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th width="30">No</th>
                            <th width="100">Tanggal</th>
                            <th width="150">Keterangan</th>
                            <th width="120">Taxi/Bensin/Tol</th>
                            <th width="120">Pesawat/KA/Bus</th>
                            <th width="100">Hotel</th>
                            <th width="100">Makan</th>
                            <th width="100">Lain-lain</th>
                            <th width="120">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($nota->detail_biaya && count($nota->detail_biaya) > 0)
                            @foreach($nota->detail_biaya as $index => $detail)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $detail['tanggal'] ? \Carbon\Carbon::parse($detail['tanggal'])->format('d/m/Y') : '-' }}</td>
                                <td>{{ $detail['keterangan'] }}</td>
                                <td class="text-right">{{ number_format($detail['taxi_bensin_tol'], 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($detail['pesawat_ka_bus'], 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($detail['hotel'], 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($detail['makan'], 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($detail['lain_lain'], 0, ',', '.') }}</td>
                                <td class="text-right"><strong>{{ number_format($detail['jumlah'], 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada detail biaya</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot class="table-info">
                        <tr>
                            <td colspan="8" class="text-right"><strong>Sub Total Biaya:</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($nota->sub_total_biaya, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Perhitungan -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-calculator mr-2"></i>
                Perhitungan
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td width="300"><strong>KM Kendaraan:</strong></td>
                        <td width="150" class="text-center">{{ $nota->km_kendaraan }} KM</td>
                        <td width="50" class="text-center">x Rp.</td>
                        <td width="150" class="text-right">{{ number_format($nota->km_kendaraan > 0 ? $nota->km_x_rp / $nota->km_kendaraan : 0, 0, ',', '.') }}</td>
                        <td width="50" class="text-center">=</td>
                        <td class="text-right"><strong>Rp {{ number_format($nota->km_x_rp, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Uang Saku/Tunjangan Lainnya:</strong></td>
                        <td class="text-center">{{ $nota->uang_saku_hari }} Hari</td>
                        <td class="text-center">x Rp.</td>
                        <td class="text-right">{{ number_format($nota->uang_saku_hari > 0 ? $nota->hari_x_rp / $nota->uang_saku_hari : 0, 0, ',', '.') }}</td>
                        <td class="text-center">=</td>
                        <td class="text-right"><strong>Rp {{ number_format($nota->hari_x_rp, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr class="table-info">
                        <td colspan="5" class="text-right"><strong>Sub Total:</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($nota->sub_total, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right"><strong>Potongan Uang Muka:</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($nota->potongan_uang_muka, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr class="table-success">
                        <td colspan="5" class="text-right"><strong>TOTAL:</strong></td>
                        <td class="text-right"><strong class="text-success">Rp {{ number_format($nota->total, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>

                <div class="mt-3">
                    <p><strong>Lokasi Pengajuan:</strong> {{ $nota->lokasi_pengajuan }}</p>
                    <p><strong>Tanggal Pengajuan:</strong> {{ $nota->tanggal_pengajuan->format('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-muted small">
            <p class="mb-1">Dibuat pada: {{ $nota->created_at->format('d F Y, H:i') }}</p>
            @if($nota->updated_at != $nota->created_at)
            <p class="mb-0">Terakhir diubah: {{ $nota->updated_at->format('d F Y, H:i') }}</p>
            @endif
        </div>
    </div>
</div>

@endsection