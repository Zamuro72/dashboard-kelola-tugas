@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Data Klien -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Klien - {{ ucfirst($status) }}</h6>
        </div>
        <div class="card-body">
            @if($kliens->count() > 0)

                {{-- ========== MOBILE CARD VIEW (< 768px) ========== --}}
                <div class="d-md-none">
                    @foreach($kliens as $index => $klien)
                        <div class="card mb-3 border-left-primary shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge badge-primary mr-1">{{ $kliens->firstItem() + $index }}</span>
                                        @if($klien->tipe_klien == 'Personal')
                                            <span class="badge badge-info">Personal</span>
                                        @else
                                            <span class="badge badge-secondary">Perusahaan</span>
                                        @endif
                                    </div>
                                    <div>
                                        {!! $klien->getStatusSertifikatBadge() !!}
                                    </div>
                                </div>

                                @if($klien->tipe_klien == 'Personal')
                                    <h6 class="font-weight-bold mb-1">{{ $klien->nama_klien }}</h6>
                                    @if($klien->nama_perusahaan)
                                        <small class="text-muted d-block mb-1"><i class="fas fa-building mr-1"></i>{{ $klien->nama_perusahaan }}</small>
                                    @endif
                                    @if($klien->tanggal_lahir)
                                        <small class="text-muted d-block mb-1"><i class="fas fa-birthday-cake mr-1"></i>{{ $klien->tanggal_lahir->format('d-m-Y') }}</small>
                                    @endif
                                @else
                                    <h6 class="font-weight-bold mb-1">{{ $klien->nama_perusahaan }}</h6>
                                    @if($klien->nama_penanggung_jawab)
                                        <small class="text-muted d-block mb-1"><i class="fas fa-user-tie mr-1"></i>{{ $klien->nama_penanggung_jawab }}</small>
                                    @endif
                                @endif

                                <div class="row small text-muted mt-2">
                                    <div class="col-6 mb-1">
                                        <i class="fas fa-concierge-bell mr-1"></i>{{ $klien->jasa->nama_jasa }}
                                    </div>
                                    <div class="col-3 mb-1">
                                        <i class="fas fa-calendar mr-1"></i>{{ $klien->tahun }}
                                    </div>
                                    <div class="col-3 mb-1">
                                        {{ $klien->skema->nama_skema ?? '-' }}
                                    </div>
                                </div>

                                @if(auth()->user()->jabatan == 'Admin' && $klien->user)
                                    <small class="text-muted d-block"><i class="fas fa-user mr-1"></i>Pemilik: {{ $klien->user->nama ?? '-' }}</small>
                                @endif

                                @if($klien->email)
                                    <small class="text-muted d-block"><i class="fas fa-envelope mr-1"></i>{{ $klien->email }}</small>
                                @endif
                                @if($klien->no_whatsapp)
                                    <small class="text-muted d-block"><i class="fab fa-whatsapp mr-1"></i>{{ $klien->no_whatsapp }}</small>
                                @endif

                                <div class="row small mt-2">
                                    <div class="col-6">
                                        <span class="text-muted">Terbit:</span><br>
                                        <strong>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">Expired:</span><br>
                                        <strong>{{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}</strong>
                                    </div>
                                </div>

                                <div class="mt-2 text-right">
                                    <a href="{{ route('klien.edit', $klien->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ========== DESKTOP TABLE VIEW (>= 768px) ========== --}}
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" width="100%" cellspacing="0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th width="4%">No</th>
                                    <th>Jasa</th>
                                    <th>Tahun</th>
                                    <th>Skema</th>
                                    @if(auth()->user()->jabatan == 'Admin')
                                        <th>Pemilik Data</th>
                                    @endif
                                    <th>Nama Klien/Perusahaan</th>
                                    <th class="d-none d-lg-table-cell">Tgl Lahir</th>
                                    <th class="d-none d-lg-table-cell">Penanggung Jawab</th>
                                    <th>Email</th>
                                    <th class="d-none d-lg-table-cell">No WA</th>
                                    <th>Sertifikat Terbit</th>
                                    <th>Expired</th>
                                    <th>Status</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kliens as $index => $klien)
                                    <tr>
                                        <td><small>{{ $kliens->firstItem() + $index }}</small></td>
                                        <td><small>{{ $klien->jasa->nama_jasa }}</small></td>
                                        <td><small>{{ $klien->tahun }}</small></td>
                                        <td><small>{{ $klien->skema->nama_skema ?? '-' }}</small></td>
                                        @if(auth()->user()->jabatan == 'Admin')
                                            <td><small>{{ $klien->user->nama ?? '-' }}</small></td>
                                        @endif
                                        <td>
                                            @if($klien->tipe_klien == 'Personal')
                                                <small><strong>{{ $klien->nama_klien }}</strong></small>
                                                @if($klien->nama_perusahaan)
                                                    <br><small class="text-muted">{{ $klien->nama_perusahaan }}</small>
                                                @endif
                                            @else
                                                <small><strong>{{ $klien->nama_perusahaan }}</strong></small>
                                            @endif
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small>
                                            @if($klien->tipe_klien == 'Personal')
                                                {{ $klien->tanggal_lahir ? $klien->tanggal_lahir->format('d-m-Y') : '-' }}
                                            @else
                                                -
                                            @endif
                                            </small>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small>
                                            @if($klien->tipe_klien == 'Perusahaan')
                                                {{ $klien->nama_penanggung_jawab ?? '-' }}
                                            @else
                                                -
                                            @endif
                                            </small>
                                        </td>
                                        <td><small>{{ $klien->email ?? '-' }}</small></td>
                                        <td class="d-none d-lg-table-cell"><small>{{ $klien->no_whatsapp ?? '-' }}</small></td>
                                        <td><small>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</small></td>
                                        <td><small>{{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}</small></td>
                                        <td><small>{!! $klien->getStatusSertifikatBadge() !!}</small></td>
                                        <td class="text-center">
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
