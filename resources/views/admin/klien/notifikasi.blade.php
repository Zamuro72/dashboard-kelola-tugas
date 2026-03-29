@extends('layouts.app')

@section('content')
<link href="{{ asset('sbadmin2/css/notifikasi-mobile.css') }}" rel="stylesheet">
<div class="container-fluid notifikasi-page">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('klien.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
        <!-- Mobile back button -->
        <a href="{{ route('klien.index') }}" class="d-sm-none btn btn-sm btn-secondary shadow-sm btn-kembali-mobile" style="display:none;">
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
                <!-- Desktop Table -->
                <div class="table-responsive notifikasi-desktop-table">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-warning text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Jasa</th>
                                <th style="min-width: 120px">Skema</th>
                                <th>Tahun</th>
                                <th>Tipe</th>
                                <th>Nama Klien/Perusahaan</th>
                                <th>Email</th>
                                <th>No WhatsApp</th>
                                <th style="min-width: 130px">Sertifikat Terbit</th>
                                <th style="min-width: 130px">Sertifikat Expired</th>
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
                                        @if($klien->catatan)
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#catatanModalAkanExpired{{ $klien->id }}" title="Lihat Catatan">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                        @endif
                                        <a href="{{ route('klien.edit', ['id' => $klien->id, 'from' => 'notifikasi']) }}" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card Layout -->
                <div class="notifikasi-mobile-cards">
                    @foreach($klienAkanExpired as $index => $klien)
                        <div class="notifikasi-card-item">
                            <div class="notifikasi-card-top bg-warning-light">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <span class="notifikasi-card-number bg-warning-num">{{ $index + 1 }}</span>
                                    @if($klien->tipe_klien == 'Personal')
                                        <span class="badge badge-info">Personal</span>
                                    @else
                                        <span class="badge badge-secondary">Perusahaan</span>
                                    @endif
                                </div>
                                <span class="notifikasi-sisa-badge badge-warning">{{ $klien->getSisaHariExpired() }}</span>
                            </div>
                            <div class="notifikasi-card-body">
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Nama</span>
                                    <span class="notifikasi-card-value">
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
                                    </span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Jasa</span>
                                    <span class="notifikasi-card-value">{{ $klien->jasa->nama_jasa }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Skema</span>
                                    <span class="notifikasi-card-value">{{ $klien->skema->nama_skema ?? '-' }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Tahun</span>
                                    <span class="notifikasi-card-value">{{ $klien->tahun }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Email</span>
                                    <span class="notifikasi-card-value">{{ $klien->email ?? '-' }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">WhatsApp</span>
                                    <span class="notifikasi-card-value">
                                        @if($klien->no_whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $klien->no_whatsapp) }}" 
                                               target="_blank" class="wa-link">
                                                <i class="fab fa-whatsapp"></i> {{ $klien->no_whatsapp }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Sert. Terbit</span>
                                    <span class="notifikasi-card-value">{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Sert. Expired</span>
                                    <span class="notifikasi-card-value notifikasi-expired-date text-warning">
                                        {{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                            <div class="notifikasi-card-footer">
                                <span class="notifikasi-sisa-badge badge-warning">
                                    <i class="fas fa-clock"></i> {{ $klien->getSisaHariExpired() }}
                                </span>
                                <div class="notifikasi-card-actions">
                                    @if($klien->catatan)
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#catatanModalAkanExpiredMobile{{ $klien->id }}" title="Lihat Catatan">
                                            <i class="fas fa-comment"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('klien.edit', ['id' => $klien->id, 'from' => 'notifikasi']) }}" 
                                       class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Mobile Catatan Modal --}}
                        @if($klien->catatan)
                            <div class="modal fade text-left" id="catatanModalAkanExpiredMobile{{ $klien->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Catatan Klien: {{ $klien->nama_klien ?? $klien->nama_perusahaan }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $klien->catatan }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Desktop Modals (keep outside mobile cards) --}}
                @foreach($klienAkanExpired as $index => $klien)
                    @if($klien->catatan)
                        <div class="modal fade text-left" id="catatanModalAkanExpired{{ $klien->id }}" tabindex="-1" role="dialog" aria-labelledby="catatanModalAkanExpiredLabel{{ $klien->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="catatanModalAkanExpiredLabel{{ $klien->id }}">Catatan Klien: {{ $klien->nama_klien ?? $klien->nama_perusahaan }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $klien->catatan }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-center py-4 notifikasi-empty-state">
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
                <!-- Desktop Table -->
                <div class="table-responsive notifikasi-desktop-table">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Jasa</th>
                                <th style="min-width: 120px">Skema</th>
                                <th>Tahun</th>
                                <th>Tipe</th>
                                <th>Nama Klien/Perusahaan</th>
                                <th>Email</th>
                                <th>No WhatsApp</th>
                                <th style="min-width: 130px">Sertifikat Terbit</th>
                                <th style="min-width: 130px">Sertifikat Expired</th>
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
                                        @if($klien->catatan)
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#catatanModalSudahExpired{{ $klien->id }}" title="Lihat Catatan">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                        @endif
                                        <a href="{{ route('klien.edit', ['id' => $klien->id, 'from' => 'notifikasi']) }}" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card Layout -->
                <div class="notifikasi-mobile-cards">
                    @foreach($klienSudahExpired as $index => $klien)
                        <div class="notifikasi-card-item">
                            <div class="notifikasi-card-top bg-danger-light">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <span class="notifikasi-card-number bg-danger-num">{{ $index + 1 }}</span>
                                    @if($klien->tipe_klien == 'Personal')
                                        <span class="badge badge-info">Personal</span>
                                    @else
                                        <span class="badge badge-secondary">Perusahaan</span>
                                    @endif
                                </div>
                                <span class="notifikasi-sisa-badge badge-danger">{{ $klien->getSisaHariExpired() }}</span>
                            </div>
                            <div class="notifikasi-card-body">
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Nama</span>
                                    <span class="notifikasi-card-value">
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
                                    </span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Jasa</span>
                                    <span class="notifikasi-card-value">{{ $klien->jasa->nama_jasa }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Skema</span>
                                    <span class="notifikasi-card-value">{{ $klien->skema->nama_skema ?? '-' }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Tahun</span>
                                    <span class="notifikasi-card-value">{{ $klien->tahun }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Email</span>
                                    <span class="notifikasi-card-value">{{ $klien->email ?? '-' }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">WhatsApp</span>
                                    <span class="notifikasi-card-value">
                                        @if($klien->no_whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $klien->no_whatsapp) }}" 
                                               target="_blank" class="wa-link">
                                                <i class="fab fa-whatsapp"></i> {{ $klien->no_whatsapp }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Sert. Terbit</span>
                                    <span class="notifikasi-card-value">{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</span>
                                </div>
                                <div class="notifikasi-card-row">
                                    <span class="notifikasi-card-label">Sert. Expired</span>
                                    <span class="notifikasi-card-value notifikasi-expired-date text-danger">
                                        {{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                            <div class="notifikasi-card-footer">
                                <span class="notifikasi-sisa-badge badge-danger">
                                    <i class="fas fa-clock"></i> {{ $klien->getSisaHariExpired() }}
                                </span>
                                <div class="notifikasi-card-actions">
                                    @if($klien->catatan)
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#catatanModalSudahExpiredMobile{{ $klien->id }}" title="Lihat Catatan">
                                            <i class="fas fa-comment"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('klien.edit', ['id' => $klien->id, 'from' => 'notifikasi']) }}" 
                                       class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Mobile Catatan Modal --}}
                        @if($klien->catatan)
                            <div class="modal fade text-left" id="catatanModalSudahExpiredMobile{{ $klien->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Catatan Klien: {{ $klien->nama_klien ?? $klien->nama_perusahaan }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $klien->catatan }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Desktop Modals --}}
                @foreach($klienSudahExpired as $index => $klien)
                    @if($klien->catatan)
                        <div class="modal fade text-left" id="catatanModalSudahExpired{{ $klien->id }}" tabindex="-1" role="dialog" aria-labelledby="catatanModalSudahExpiredLabel{{ $klien->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="catatanModalSudahExpiredLabel{{ $klien->id }}">Catatan Klien: {{ $klien->nama_klien ?? $klien->nama_perusahaan }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $klien->catatan }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-center py-4 notifikasi-empty-state">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <p class="text-muted">Tidak ada sertifikat yang sudah expired</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection