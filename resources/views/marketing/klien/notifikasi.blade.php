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

    <!-- Sertifikat Akan Expired (3 Bulan Kedepan) -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-warning">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-exclamation-triangle"></i> Sertifikat Akan Expired (3 Bulan Kedepan)
            </h6>
        </div>
        <div class="card-body">
            @if($klienAkanExpired->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-warning text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Jasa</th>
                                <th>Skema</th>
                                <th>Tahun</th>
                                <th>Tipe</th>
                                <th>Nama Klien/Perusahaan</th>
                                <th>Email</th>
                                <th>No WhatsApp</th>
                                <th>Sertifikat Terbit</th>
                                <th>Sertifikat Expired</th>
                                <th>Sisa Hari</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($klienAkanExpired as $index => $klien)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $klien->jasa->nama_jasa }}</td>
                                    <td>{{ $klien->skema->nama_skema ?? '-' }}</td>
                                    <td>{{ $klien->tahun }}</td>
                                    <td>
                                        @if($klien->tipe_klien == 'Personal')
                                            <span class="badge badge-info">Personal</span>
                                        @else
                                            <span class="badge badge-secondary">Perusahaan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($klien->tipe_klien == 'Personal')
                                            <strong>{{ $klien->nama_klien }}</strong>
                                            @if($klien->nama_perusahaan)
                                                <br><small class="text-muted">{{ $klien->nama_perusahaan }}</small>
                                            @endif
                                        @else
                                            <strong>{{ $klien->nama_perusahaan }}</strong>
                                            @if($klien->nama_penanggung_jawab)
                                                <br><small class="text-muted">PJ: {{ $klien->nama_penanggung_jawab }}</small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $klien->email ?? '-' }}</td>
                                    <td>
                                        @if($klien->no_whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $klien->no_whatsapp) }}" 
                                               target="_blank" class="text-success">
                                                <i class="fab fa-whatsapp"></i> {{ $klien->no_whatsapp }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        <span class="text-warning font-weight-bold">
                                            {{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            {{ $klien->getSisaHariExpired() }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('klien.edit', $klien->id) }}" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <p class="text-muted">Tidak ada sertifikat yang akan expired dalam 3 bulan ke depan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sertifikat Sudah Expired -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-danger">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-times-circle"></i> Sertifikat Sudah Expired
            </h6>
        </div>
        <div class="card-body">
            @if($klienSudahExpired->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Jasa</th>
                                <th>Skema</th>
                                <th>Tahun</th>
                                <th>Tipe</th>
                                <th>Nama Klien/Perusahaan</th>
                                <th>Email</th>
                                <th>No WhatsApp</th>
                                <th>Sertifikat Terbit</th>
                                <th>Sertifikat Expired</th>
                                <th>Keterangan</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($klienSudahExpired as $index => $klien)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $klien->jasa->nama_jasa }}</td>
                                    <td>{{ $klien->skema->nama_skema ?? '-' }}</td>
                                    <td>{{ $klien->tahun }}</td>
                                    <td>
                                        @if($klien->tipe_klien == 'Personal')
                                            <span class="badge badge-info">Personal</span>
                                        @else
                                            <span class="badge badge-secondary">Perusahaan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($klien->tipe_klien == 'Personal')
                                            <strong>{{ $klien->nama_klien }}</strong>
                                            @if($klien->nama_perusahaan)
                                                <br><small class="text-muted">{{ $klien->nama_perusahaan }}</small>
                                            @endif
                                        @else
                                            <strong>{{ $klien->nama_perusahaan }}</strong>
                                            @if($klien->nama_penanggung_jawab)
                                                <br><small class="text-muted">PJ: {{ $klien->nama_penanggung_jawab }}</small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $klien->email ?? '-' }}</td>
                                    <td>
                                        @if($klien->no_whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $klien->no_whatsapp) }}" 
                                               target="_blank" class="text-success">
                                                <i class="fab fa-whatsapp"></i> {{ $klien->no_whatsapp }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            {{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">
                                            {{ $klien->getSisaHariExpired() }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('klien.edit', $klien->id) }}" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <p class="text-muted">Tidak ada sertifikat yang sudah expired</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection