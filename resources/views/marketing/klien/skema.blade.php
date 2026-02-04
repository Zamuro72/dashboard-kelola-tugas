@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('klien.tahun', $jasa->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <!-- Info Jasa & Tahun -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle"></i> Informasi
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Nama Jasa:</strong> {{ $jasa->nama_jasa }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Tahun:</strong> {{ $tahun }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Masa Berlaku:</strong> {{ $jasa->masa_berlaku_tahun }} Tahun</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Skema -->
    <div class="row">
        @foreach($skemaList as $skema)
            <div class="col-xl-4 col-md-6 mb-4">
                <a href="{{ route('klien.data.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}" 
                   class="text-decoration-none">
                    <div class="card border-left-info shadow h-100 py-2 hover-card">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Skema
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $skema->nama_skema }}
                                    </div>
                                    <div class="text-xs text-muted mt-2">
                                        Total Data: <span class="font-weight-bold">{{ $skema->kliens_count }}</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-certificate fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

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