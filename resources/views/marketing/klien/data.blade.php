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
                <div class="col-md-3">
                    <p><strong>Jasa:</strong> {{ $jasa->nama_jasa }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Tahun:</strong> {{ $tahun }}</p>
                </div>
                @if($skema)
                    <div class="col-md-3">
                        <p><strong>Skema:</strong> {{ $skema->nama_skema }}</p>
                    </div>
                @endif
                <div class="col-md-3">
                    <p><strong>Masa Berlaku:</strong> {{ $jasa->masa_berlaku_tahun }} Tahun</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Klien -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Klien</h6>
            <div>
                @if($skema)
                    <a href="{{ route('klien.excel.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}" 
                       class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('klien.pdf.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}" 
                       class="btn btn-danger btn-sm" target="_blank">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="{{ route('klien.create.skema', ['jasaId' => $jasa->id, 'tahun' => $tahun, 'skemaId' => $skema->id]) }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Klien
                    </a>
                @else
                    <a href="{{ route('klien.excel', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" 
                       class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('klien.pdf', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" 
                       class="btn btn-danger btn-sm" target="_blank">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="{{ route('klien.create', ['jasaId' => $jasa->id, 'tahun' => $tahun]) }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Klien
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <form action="" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama klien, perusahaan, email..." 
                           value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ url()->current() }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            @if($kliens->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Tipe</th>
                                <th>Nama Klien/Perusahaan</th>
                                <th>Penanggung Jawab</th>
                                <th>Email</th>
                                <th>No WhatsApp</th>
                                <th>Sertifikat Terbit</th>
                                <th>Sertifikat Expired</th>
                                <th>Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kliens as $index => $klien)
                                <tr>
                                    <td>{{ $kliens->firstItem() + $index }}</td>
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
                                        @endif
                                    </td>
                                    <td>
                                        @if($klien->tipe_klien == 'Perusahaan')
                                            {{ $klien->nama_penanggung_jawab ?? '-' }}
                                        @endif
                                    </td>
                                    <td>{{ $klien->email ?? '-' }}</td>
                                    <td>{{ $klien->no_whatsapp ?? '-' }}</td>
                                    <td>{{ $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $klien->tanggal_expired ? $klien->tanggal_expired->format('d-m-Y') : '-' }}</td>
                                    <td>{!! $klien->getStatusSertifikatBadge() !!}</td>
                                    <td>
                                        <a href="{{ route('klien.edit', $klien->id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                onclick="confirmDelete({{ $klien->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $klien->id }}" 
                                              action="{{ route('klien.destroy', $klien->id) }}" 
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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