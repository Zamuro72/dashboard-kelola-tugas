@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-clock mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
        <a href="{{ route('lembur') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
        <a href="{{ route('lemburPdf', $lembur->id) }}" target="_blank" class="btn btn-sm btn-danger">
            <i class="fas fa-file-pdf mr-2"></i>
            Export PDF
        </a>
    </div>
    <div class="card-body">
        <!-- Header Surat -->
        <div class="text-center mb-4">
            <h4 class="font-weight-bold">SURAT PENGAJUAN LEMBUR</h4>
            <p class="text-muted">No: PLB/{{ str_pad($lembur->id, 4, '0', STR_PAD_LEFT) }}/{{ \Carbon\Carbon::parse($lembur->created_at)->format('m/Y') }}</p>
        </div>

        <!-- Data Karyawan -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-user mr-2"></i>
                Data Karyawan
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="200"><strong>Nama Karyawan</strong></td>
                        <td width="20">:</td>
                        <td>{{ $lembur->user->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jabatan</strong></td>
                        <td>:</td>
                        <td>{{ $lembur->user->jabatan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Departemen/Divisi</strong></td>
                        <td>:</td>
                        <td>{{ $lembur->departemen }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Waktu dan Tempat Lembur -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-calendar-alt mr-2"></i>
                Waktu dan Tempat Lembur
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="200"><strong>Tanggal Pelaksanaan</strong></td>
                        <td width="20">:</td>
                        <td>{{ \Carbon\Carbon::parse($lembur->tanggal_pelaksanaan)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Hari</strong></td>
                        <td>:</td>
                        <td>{{ $lembur->hari }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jam Kerja Normal</strong></td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($lembur->jam_kerja_mulai)->format('H:i') }} s.d. {{ \Carbon\Carbon::parse($lembur->jam_kerja_selesai)->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jam Lembur</strong></td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($lembur->jam_lembur_mulai)->format('H:i') }} s.d. {{ \Carbon\Carbon::parse($lembur->jam_lembur_selesai)->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Jam Lembur</strong></td>
                        <td>:</td>
                        <td><span class="badge badge-primary">{{ number_format($lembur->total_jam_lembur, 1) }} Jam</span></td>
                    </tr>
                    <tr>
                        <td><strong>Lokasi/Tempat Kerja</strong></td>
                        <td>:</td>
                        <td>{{ $lembur->lokasi }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Uraian Pekerjaan -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-tasks mr-2"></i>
                Uraian Pekerjaan Yang Dilaksanakan
            </div>
            <div class="card-body">
                <p class="mb-0" style="white-space: pre-line;">{{ $lembur->uraian_pekerjaan }}</p>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-muted small">
            <p class="mb-1">Dibuat pada: {{ \Carbon\Carbon::parse($lembur->created_at)->format('d F Y, H:i') }}</p>
            @if($lembur->updated_at != $lembur->created_at)
            <p class="mb-0">Terakhir diubah: {{ \Carbon\Carbon::parse($lembur->updated_at)->format('d F Y, H:i') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
