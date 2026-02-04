@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('klien.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <!-- Info Jasa -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle"></i> Informasi Jasa
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Jasa:</strong> {{ $jasa->nama_jasa }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Masa Berlaku Sertifikat:</strong> {{ $jasa->masa_berlaku_tahun }} Tahun</p>
                </div>
            </div>
        </div>
    </div>

    @if($tahunList->count() > 0)
        <!-- Daftar Tahun -->
        <div class="row">
            @foreach($tahunList as $tahun)
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ $jasa->has_skema ? route('klien.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun]) : route('klien.data', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" 
                       class="text-decoration-none">
                        <div class="card border-left-success shadow h-100 py-2 hover-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Tahun
                                        </div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                                            {{ $tahun }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <!-- Tidak ada data -->
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                <p class="text-gray-600">Belum ada data klien untuk jasa {{ $jasa->nama_jasa }}</p>
                <p class="text-muted">Silakan import data atau tambahkan data klien terlebih dahulu</p>
                <a href="{{ route('klien.import.form') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Import Data
                </a>
            </div>
        </div>
    @endif

</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection