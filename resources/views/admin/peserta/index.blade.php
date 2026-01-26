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
            <a href="{{ route('pesertaImportForm') }}" class="btn btn-sm btn-success">
                <i class="fas fa-upload mr-2"></i>
                Import Excel
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
                <select name="tahun" class="form-control form-control-sm mr-3" onchange="this.form.submit()">
                    @foreach($daftarTahun as $tahun)
                    <option value="{{ $tahun }}" {{ $tahunTerpilih == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                    @endforeach
                </select>
                
                <label class="mr-2">Filter Skema:</label>
                <select name="skema" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                    <option value="">-- Semua Skema --</option>
                    @foreach($daftarSkema as $skema)
                    <option value="{{ $skema }}" {{ $skemaTerpilih == $skema ? 'selected' : '' }}>
                        {{ $skema }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
        
        <div class="mb-2">
            <a href="{{ route('pesertaExcel', ['tahun' => $tahunTerpilih, 'skema' => $skemaTerpilih]) }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-excel mr-2"></i>
                Excel
            </a>
            <a href="{{ route('pesertaPdf', ['tahun' => $tahunTerpilih, 'skema' => $skemaTerpilih]) }}" class="btn btn-sm btn-danger" target='__blank'>
                <i class="fas fa-file-pdf mr-2"></i>
                PDF
            </a>
            <!-- Button Delete All By Year -->
            @if($peserta->count() > 0)
            <button class="btn btn-sm btn-danger ml-2" data-toggle="modal" data-target="#modalDeleteYear">
                <i class="fas fa-trash-alt mr-2"></i>
                Hapus Data {{ $tahunTerpilih }}
            </button>
            @endif
        </div>
    </div>
    
    <!-- Modal Delete Year -->
    <div class="modal fade" id="modalDeleteYear" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Hapus Semua Data {{ $tahunTerpilih }}?</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus <strong>SEMUA</strong> data peserta untuk tahun <strong>{{ $tahunTerpilih }}</strong>?</p>
                    <p class="text-danger small mt-2">*Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <form action="{{ route('pesertaDestroyByTahun', $tahunTerpilih) }}" method="post" class="d-inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Ya, Hapus Semua
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div style="overflow-x: auto; width: 100%; border: 1px solid #ddd;">
            <table class="table table-bordered table-hover" id="dataTable" style="width: 1500px;" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th style="min-width: 120px;">Nama</th>
                        <th style="min-width: 120px;">Perusahaan</th>
                        <th style="min-width: 120px;">Email</th>
                        <th>No WhatsApp</th>
                        <th style="min-width: 120px;">Tgl Lahir</th>
                        <th style="min-width: 120px;">Skema</th>
                        <th style="min-width: 120px;">Tgl Sertifikat</th>
                        <th style="min-width: 120px;">Expired</th>
                        <th>Status</th>
                        <th style="min-width: 150px;">
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
                        <td>{{ $item->email ?? '-' }}</td>
                        <td class="text-center">
                            {{ preg_replace('/[^0-9]/', '', $item->no_whatsapp) }}
                        </td>
                        <td class="text-center">{{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                        <td>{{ $item->skema }}</td>
                        <td class="text-center">{{ $item->tanggal_sertifikat_diterima ? $item->tanggal_sertifikat_diterima->format('d-m-Y') : '-' }}</td>
                        <td class="text-center">
                            @if($item->tanggal_expired)
                            <small>{{ $item->tanggal_expired->format('d-m-Y') }}</small><br>
                            @else
                            -
                            @endif
                        </td>
                        <td class="text-center">
                            {!! $item->getStatusSertifikatBadge() !!}
                            @if($item->suka_telat_bayar)
                            <br><span class="badge badge-danger mt-1">Suka Telat Bayar</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#modalShow{{ $item->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="{{ route('pesertaEdit', $item->id) }}" class="btn btn-sm btn-warning mr-2">
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