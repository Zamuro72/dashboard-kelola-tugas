@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-3 mb-sm-0 text-gray-800">{{ $title }}</h1>
        <div>
            @if(request('from') == 'dashboard')
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary shadow-sm mr-1">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            @else
                <a href="{{ route('klien.index') }}" class="btn btn-sm btn-secondary shadow-sm mr-1">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            @endif
            <a href="{{ route('klien-tidak-aktif.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
            </a>
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Klien Tidak Aktif</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('klien-tidak-aktif.index') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="ongoing proses deal" {{ request('status') == 'ongoing proses deal' ? 'selected' : '' }}>Ongoing Proses Deal</option>
                            <option value="belum jelas" {{ request('status') == 'belum jelas' ? 'selected' : '' }}>Belum Jelas</option>
                            <option value="follow up" {{ request('status') == 'follow up' ? 'selected' : '' }}>Follow Up</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama, email, wa..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tipe</th>
                            <th>Nama</th>
                            <th>Tahun</th>
                            <th>Email</th>
                            <th>WhatsApp</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kliens as $index => $klien)
                            <tr>
                                <td>{{ ($kliens->currentPage() - 1) * $kliens->perPage() + $index + 1 }}</td>
                                <td>
                                    @if($klien->tipe_klien == 'Personal')
                                        <span class="badge badge-info">Personal</span>
                                    @else
                                        <span class="badge badge-secondary">Perusahaan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($klien->tipe_klien == 'Personal')
                                        {{ $klien->nama_klien }}
                                    @else
                                        {{ $klien->nama_perusahaan }}
                                        <br><small class="text-muted">PJ: {{ $klien->nama_penanggung_jawab }}</small>
                                    @endif
                                </td>
                                <td>{{ $klien->tahun }}</td>
                                <td>{{ $klien->email ?? '-' }}</td>
                                <td>
                                    @if($klien->no_whatsapp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $klien->no_whatsapp) }}" target="_blank">
                                            {{ $klien->no_whatsapp }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($klien->status == 'ongoing proses deal')
                                        <span class="badge badge-warning">Ongoing Proses Deal</span>
                                    @elseif($klien->status == 'belum jelas')
                                        <span class="badge badge-secondary">Belum Jelas</span>
                                    @elseif($klien->status == 'follow up')
                                        <span class="badge badge-primary">Follow Up</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('klien-tidak-aktif.edit', $klien->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('klien-tidak-aktif.destroy', $klien->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $kliens->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
