@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-plane mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
        <a href="{{ route('perdin') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
        <a href="{{ route('perdinPdf', $perdin->id) }}" target="_blank" class="btn btn-sm btn-danger">
            <i class="fas fa-file-pdf mr-2"></i>
            Export PDF
        </a>
    </div>
    <div class="card-body">
        <!-- Header Surat -->
        <div class="text-center mb-4">
            <h4 class="font-weight-bold">FORMULIR IZIN PERJALANAN DINAS</h4>
            <p class="text-muted">No: PD/{{ str_pad($perdin->id, 4, '0', STR_PAD_LEFT) }}/{{ \Carbon\Carbon::parse($perdin->created_at)->format('m/Y') }}</p>
        </div>

        <!-- Data Karyawan -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-user mr-2"></i>
                Yang Bertanda Tangan Di Bawah Ini
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="150"><strong>Nama</strong></td>
                        <td width="20">:</td>
                        <td>{{ $perdin->user->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jabatan</strong></td>
                        <td>:</td>
                        <td>{{ $perdin->user->jabatan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Rincian Perjalanan Dinas -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-plane mr-2"></i>
                Rincian Perjalanan Dinas
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td width="180"><strong>Tujuan Perjalanan</strong></td>
                        <td>{{ $perdin->tujuan_perjalanan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Lokasi</strong></td>
                        <td>{{ $perdin->lokasi }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Berangkat</strong></td>
                        <td>{{ \Carbon\Carbon::parse($perdin->tanggal_berangkat)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Kembali</strong></td>
                        <td>{{ \Carbon\Carbon::parse($perdin->tanggal_kembali)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Transportasi</strong></td>
                        <td>{{ $perdin->transportasi }}</td>
                    </tr>
                    <tr>
                        <td><strong>Uang Muka</strong></td>
                        <td>Rp {{ number_format($perdin->uang_muka, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-muted small">
            <p class="mb-1">Dibuat pada: {{ \Carbon\Carbon::parse($perdin->created_at)->format('d F Y, H:i') }}</p>
            @if($perdin->updated_at != $perdin->created_at)
            <p class="mb-0">Terakhir diubah: {{ \Carbon\Carbon::parse($perdin->updated_at)->format('d F Y, H:i') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
