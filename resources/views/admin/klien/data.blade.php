@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <div>
            @if($skema)
                <a href="{{ route('klien.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" 
                   class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            @else
                <a href="{{ route('klien.tahun', $jasa->id) }}" 
                   class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Info -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle"></i> Informasi
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <p class="mb-0"><strong>Jasa:</strong></p>
                    <p class="text-muted small">{{ $jasa->nama_jasa }}</p>
                </div>
                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <p class="mb-0"><strong>Tahun:</strong></p>
                    <p class="text-muted small">{{ $tahun }}</p>
                </div>
                @if($skema)
                    <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                        <p class="mb-0"><strong>Skema:</strong></p>
                        <p class="text-muted small">{{ $skema->nama_skema }}</p>
                    </div>
                @endif
                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <p class="mb-0"><strong>Masa Berlaku:</strong></p>
                    <p class="text-muted small">{{ $jasa->masa_berlaku_tahun }} Tahun</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Klien -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <h6 class="m-0 font-weight-bold text-primary mb-2 mb-sm-0">Data Klien</h6>
                
                <!-- Desktop Menu -->
                <div class="d-none d-sm-flex gap-2 flex-wrap">
                    @if($skema)
                        <a href="{{ route('klien.excel.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}" 
                           class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                        <a href="{{ route('klien.pdf.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}" 
                           class="btn btn-danger btn-sm" target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="{{ route('klien.create.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}" 
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    @else
                        <a href="{{ route('klien.excel', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" 
                           class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                        <a href="{{ route('klien.pdf', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" 
                           class="btn btn-danger btn-sm" target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="{{ route('klien.create', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" 
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    @endif
                </div>

                <!-- Mobile Menu (Dropdown) -->
                <div class="d-sm-none dropdown ml-auto">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="mobileDataMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i> Aksi
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="mobileDataMenu">
                        @if($skema)
                            <a class="dropdown-item" href="{{ route('klien.excel.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}">
                                <i class="fas fa-file-excel text-success"></i> Export Excel
                            </a>
                            <a class="dropdown-item" href="{{ route('klien.pdf.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}" target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> Export PDF
                            </a>
                            <a class="dropdown-item" href="{{ route('klien.create.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}">
                                <i class="fas fa-plus text-primary"></i> Tambah Klien
                            </a>
                        @else
                            <a class="dropdown-item" href="{{ route('klien.excel', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}">
                                <i class="fas fa-file-excel text-success"></i> Export Excel
                            </a>
                            <a class="dropdown-item" href="{{ route('klien.pdf', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> Export PDF
                            </a>
                            <a class="dropdown-item" href="{{ route('klien.create', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}">
                                <i class="fas fa-plus text-primary"></i> Tambah Klien
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter & Search Form -->
            <form action="" method="GET" class="mb-3">
                <div class="form-row align-items-end">
                    <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                        <select name="tipe_klien" class="custom-select custom-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Tipe</option>
                            <option value="Personal" {{ request('tipe_klien') == 'Personal' ? 'selected' : '' }}>Personal</option>
                            <option value="Perusahaan" {{ request('tipe_klien') == 'Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm mb-2 mb-sm-0">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari nama, perusahaan..." 
                                   value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if(request('search') || request('tipe_klien'))
                                    <a href="{{ url()->current() }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @if($kliens->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="5%">No</th>
                                @if(request('tipe_klien') == 'Personal')
                                    {{-- Kolom untuk tipe Personal --}}
                                    <th>Nama</th>
                                    <th>Perusahaan</th>
                                    <th class="d-none d-md-table-cell" style="min-width: 120px">Tanggal Lahir</th>
                                    <th class="d-none d-md-table-cell">Email</th>
                                    <th class="d-none d-md-table-cell">No WhatsApp</th>
                                    <th class="d-none d-lg-table-cell" style="min-width: 130px">Sertifikat Terbit</th>
                                @elseif(request('tipe_klien') == 'Perusahaan')
                                    {{-- Kolom untuk tipe Perusahaan --}}
                                    <th>Perusahaan</th>
                                    <th>Penanggung Jawab</th>
                                    <th class="d-none d-md-table-cell">Email</th>
                                    <th class="d-none d-md-table-cell">No WhatsApp</th>
                                    <th class="d-none d-lg-table-cell" style="min-width: 130px">Sertifikat Terbit</th>
                                @else
                                    {{-- Kolom untuk Semua Tipe --}}
                                    <th>Tipe</th>
                                    <th>Nama</th>
                                    <th>Perusahaan</th>
                                    <th class="d-none d-md-table-cell">Email</th>
                                    <th class="d-none d-md-table-cell">No WhatsApp</th>
                                    <th class="d-none d-lg-table-cell" style="min-width: 130px">Sertifikat Terbit</th>
                                    <th class="d-none d-lg-table-cell" style="min-width: 130px">Expired</th>
                                @endif
                                <th>Status</th>
                                <th style="min-width: 100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kliens as $index => $klien)
                                <tr>
                                    <td>{{ $kliens->firstItem() + $index }}</td>
                                    @if(request('tipe_klien') == 'Personal')
                                        {{-- Data untuk tipe Personal --}}
                                        <td><small><strong>{{ $klien->nama_klien ?? '-' }}</strong></small></td>
                                        <td><small>{{ $klien->nama_perusahaan ?? '-' }}</small></td>
                                        <td class="d-none d-md-table-cell">
                                            <small>{{ $klien->tanggal_lahir ? $klien->tanggal_lahir->format('d-m-Y') : '-' }}</small>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <small>{{ $klien->email ?? '-' }}</small>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <small>{{ $klien->no_whatsapp ?? '-' }}</small>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</small>
                                        </td>
                                    @elseif(request('tipe_klien') == 'Perusahaan')
                                        {{-- Data untuk tipe Perusahaan --}}
                                        <td><small><strong>{{ $klien->nama_perusahaan ?? '-' }}</strong></small></td>
                                        <td><small>{{ $klien->nama_penanggung_jawab ?? '-' }}</small></td>
                                        <td class="d-none d-md-table-cell">
                                            <small>{{ $klien->email ?? '-' }}</small>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <small>{{ $klien->no_whatsapp ?? '-' }}</small>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</small>
                                        </td>
                                    @else
                                        {{-- Data untuk Semua Tipe --}}
                                        <td>
                                            @if($klien->tipe_klien == 'Personal')
                                                <span class="badge badge-info">Personal</span>
                                            @else
                                                <span class="badge badge-secondary">Perusahaan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small><strong>{{ $klien->nama_klien ?? '-' }}</strong></small>
                                        </td>
                                        <td>
                                            <small>{{ $klien->nama_perusahaan ?? '-' }}</small>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <small>{{ $klien->email ?? '-' }}</small>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <small>{{ $klien->no_whatsapp ?? '-' }}</small>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</small>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small>{{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}</small>
                                        </td>
                                    @endif
                                    <td>
                                        <small>{!! $klien->getStatusSertifikatBadge() !!}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('klien.edit', $klien->id) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($klien->catatan)
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#catatanModal{{ $klien->id }}" title="Catatan">
                                                    <i class="fas fa-comment"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-danger" 
                                                    onclick="confirmDelete({{ $klien->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $klien->id }}" 
                                              action="{{ route('klien.destroy', $klien->id) }}" 
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @if($klien->catatan)
                                    <!-- Catatan Modal -->
                                    <div class="modal fade" id="catatanModal{{ $klien->id }}" tabindex="-1" role="dialog" aria-labelledby="catatanModalLabel{{ $klien->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="catatanModalLabel{{ $klien->id }}">Catatan</h5>
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
                    <p class="text-gray-600">Belum ada data klien</p>
                    @if($skema)
                        <a href="{{ route('klien.create.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Klien
                        </a>
                    @else
                        <a href="{{ route('klien.create', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Klien
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

</div>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data klien ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection