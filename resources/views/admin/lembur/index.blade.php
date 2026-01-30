@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-clock mr-2"></i>
    {{ $title }}
</h1>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-header bg-primary text-white">
        <h6 class="m-0 font-weight-bold">Data Pengajuan Lembur (Semua User)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Jam Kerja</th>
                        <th>Jam Lembur</th>
                        <th>Total Jam</th>
                        <th>Lokasi</th>
                        <th>Uraian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lemburs as $index => $lembur)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $lembur->user->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($lembur->tanggal_pelaksanaan)->format('d-m-Y') }}</td>
                        <td>{{ $lembur->hari }}</td>
                        <td>{{ $lembur->jam_kerja_mulai }} - {{ $lembur->jam_kerja_selesai }}</td>
                        <td>{{ \Carbon\Carbon::parse($lembur->jam_lembur_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($lembur->jam_lembur_selesai)->format('H:i') }}</td>
                        <td>{{ abs(intval($lembur->total_jam_lembur)) }} Jam</td>
                        <td>{{ $lembur->lokasi }}</td>
                        <td>{{ Str::limit($lembur->uraian_pekerjaan, 50) }}</td>
                        <td>
                            <a href="{{ route('lemburPdf', $lembur->id) }}" target="_blank" class="btn btn-sm btn-danger" title="PDF">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Belum ada pengajuan lembur</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
