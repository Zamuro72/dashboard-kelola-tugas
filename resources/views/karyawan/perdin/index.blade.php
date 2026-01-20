@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-plane mr-2"></i>
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
        <a href="{{ route('perdinCreate') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus mr-2"></i>
            Buat Izin Perjalanan Dinas
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Tujuan</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Transportasi</th>
                        <th>Uang Muka</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perdins as $index => $perdin)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ Str::limit($perdin->tujuan_perjalanan, 30) }}</td>
                        <td>{{ $perdin->lokasi }}</td>
                        <td>{{ \Carbon\Carbon::parse($perdin->tanggal_berangkat)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($perdin->tanggal_kembali)->format('d/m/Y') }}</td>
                        <td>{{ $perdin->transportasi }}</td>
                        <td>Rp {{ number_format($perdin->uang_muka, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('perdinShow', $perdin->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('perdinPdf', $perdin->id) }}" target="_blank" class="btn btn-sm btn-danger" title="PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('perdinEdit', $perdin->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('perdinDestroy', $perdin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                        <td colspan="7" class="text-center">Belum ada perjalanan dinas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
