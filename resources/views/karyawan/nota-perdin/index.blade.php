@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-file-invoice mr-2"></i>
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
        <a href="{{ route('notaPerdinCreate') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus mr-2"></i>
            Buat Nota Perhitungan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Tujuan</th>
                        <th>Total Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notas as $index => $nota)
                    <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $nota->tanggal_berangkat->format('d/m/Y') }} - {{ $nota->tanggal_kembali->format('d/m/Y') }}</td>
                <td>{{ $nota->nama }}</td>
                <td>{{ Str::limit($nota->tujuan_keperluan, 40) }}</td>
                <td>Rp {{ number_format($nota->total, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('notaPerdinShow', $nota->id) }}" class="btn btn-sm btn-info" title="Lihat">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('notaPerdinPdf', $nota->id) }}" target="_blank" class="btn btn-sm btn-danger" title="PDF">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                    <form action="{{ route('notaPerdinDestroy', $nota->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nota ini?')">
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
                        <td colspan="6" class="text-center">Belum ada nota perhitungan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection