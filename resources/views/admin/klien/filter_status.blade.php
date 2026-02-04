@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('dashboard') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Data Klien -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Klien - {{ ucfirst($status) }}</h6>
        </div>
        <div class="card-body">
            @if($kliens->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Jasa</th>
                                <th>Tahun</th>
                                <th>Skema</th>
                                <th>Nama Klien/Perusahaan</th>
                                <th>Penanggung Jawab</th>
                                <th>Email</th>
                                <th>No Whatsapp</th>
                                <th>Sertifikat Terbit</th>
                                <th>Sertifikat Expired</th>
                                <th>Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kliens as $index => $klien)
                                <tr>
                                    <td>{{ $kliens->firstItem() + $index }}</td>
                                    <td>{{ $klien->jasa->nama_jasa }}</td>
                                    <td>{{ $klien->tahun }}</td>
                                    <td>{{ $klien->skema->nama_skema ?? '-' }}</td>
                                    <td>
                                        @if($klien->tipe_klien == 'Personal')
                                            <strong>{{ $klien->nama_klien }}</strong>
                                            @if($klien->nama_perusahaan)
                                                <br><small class="text-muted">{{ $klien->nama_perusahaan }}</small>
                                            @endif
                                        @else
                                            <strong>{{ $klien->nama_perusahaan }}</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if($klien->tipe_klien == 'Perusahaan')
                                            {{ $klien->nama_penanggung_jawab ?? '-' }}
                                        @endif
                                    </td>
                                    <td>{{ $klien->no_whatsapp ?? '-' }}</td>
                                    <td>{{ $klien->email ?? '-' }}</td>
                                    <td>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}</td>
                                    <td>{!! $klien->getStatusSertifikatBadge() !!}</td>
                                    <td>
                                        <a href="{{ route('klien.edit', $klien->id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $kliens->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-600">Tidak ada data klien dengan status {{ $status }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
