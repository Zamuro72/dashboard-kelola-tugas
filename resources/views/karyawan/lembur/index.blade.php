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
    <div class="card-header bg-primary">
        <a href="{{ route('lemburCreate') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus mr-2"></i>
            Buat Pengajuan Lembur
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Jam Lembur</th>
                        <th>Total Jam</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lemburs as $index => $lembur)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($lembur->tanggal_pelaksanaan)->format('d-m-Y') }}</td>
                        <td>{{ $lembur->hari }}</td>
                        <td>{{ \Carbon\Carbon::parse($lembur->jam_lembur_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($lembur->jam_lembur_selesai)->format('H:i') }}</td>
                        <td>{{ number_format($lembur->total_jam_lembur, 1) }} Jam</td>
                        <td>{{ $lembur->lokasi }}</td>
                        <td>
                            <a href="{{ route('lemburShow', $lembur->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('lemburPdf', $lembur->id) }}" target="_blank" class="btn btn-sm btn-danger" title="PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('lemburEdit', $lembur->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('lemburDestroy', $lembur->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada pengajuan lembur</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
