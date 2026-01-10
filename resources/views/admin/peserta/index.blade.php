@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-users mr-2"></i>
    {{ $title }}
</h1>

<!-- Notifikasi Sertifikat -->
@if($jumlahAkanExpired > 0 || $jumlahSudahExpired > 0)
<div class="row mb-3">
    @if($jumlahSudahExpired > 0)
    <div class="col-md-6">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle mr-2"></i>Peringatan!</strong>
            Ada {{ $jumlahSudahExpired }} peserta dengan sertifikat sudah expired.
            <a href="{{ route('pesertaNotifikasi') }}" class="alert-link">Lihat detail</a>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    </div>
    @endif
    
    @if($jumlahAkanExpired > 0)
    <div class="col-md-6">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-clock mr-2"></i>Perhatian!</strong>
            Ada {{ $jumlahAkanExpired }} peserta dengan sertifikat akan expired dalam 3 bulan.
            <a href="{{ route('pesertaNotifikasi') }}" class="alert-link">Lihat detail</a>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    </div>
    @endif
</div>
@endif

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <div class="mb-2">
            <a href="{{ route('pesertaCreate') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Tambah Data
            </a>
            <a href="{{ route('pesertaNotifikasi') }}" class="btn btn-sm btn-info">
                <i class="fas fa-bell mr-2"></i>
                Notifikasi
                @if($jumlahAkanExpired > 0 || $jumlahSudahExpired > 0)
                <span class="badge badge-light">{{ $jumlahAkanExpired + $jumlahSudahExpired }}</span>
                @endif
            </a>
        </div>
        
        <div class="mb-2">
            <form action="{{ route('peserta') }}" method="GET" class="form-inline">
                <label class="mr-2">Filter Tahun:</label>
                <select name="tahun" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                    @foreach($daftarTahun as $tahun)
                    <option value="{{ $tahun }}" {{ $tahunTerpilih == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
        
        <div class="mb-2">
            <a href="{{ route('pesertaExcel', ['tahun' => $tahunTerpilih]) }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-excel mr-2"></i>
                Excel
            </a>
            <a href="{{ route('pesertaPdf', ['tahun' => $tahunTerpilih]) }}" class="btn btn-sm btn-danger" target='__blank'>
                <i class="fas fa-file-pdf mr-2"></i>
                PDF
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>No WhatsApp</th>
                        <th>Tgl Lahir</th>
                        <th>Skema</th>
                        <th>Tgl Sertifikat</th>
                        <th>Expired</th>
                        <th>Status</th>
                        <th>
                            <i class="fas fa-cog"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peserta as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nama_perusahaan }}</td>
                        <td class="text-center">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_whatsapp) }}" 
                               target="_blank" class="btn btn-sm btn-success">
                                <i class="fab fa-whatsapp"></i> {{ $item->no_whatsapp }}
                            </a>
                        </td>
                        <td class="text-center">{{ $item->tanggal_lahir->format('d-m-Y') }}</td>
                        <td>{{ $item->skema }}</td>
                        <td class="text-center">{{ $item->tanggal_sertifikat_diterima->format('d-m-Y') }}</td>
                        <td class="text-center">
                            <small>{{ $item->tanggal_expired->format('d-m-Y') }}</small><br>
                            <small class="text-muted">({{ $item->getSisaHariExpired() }})</small>
                        </td>
                        <td class="text-center">
                            {!! $item->getStatusSertifikatBadge() !!}
                            @if($item->suka_telat_bayar)
                            <br><span class="badge badge-danger mt-1">Suka Telat Bayar</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalShow{{ $item->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="{{ route('pesertaEdit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalDelete{{ $item->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            @include('admin/peserta/modal')
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data peserta untuk tahun {{ $tahunTerpilih }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection