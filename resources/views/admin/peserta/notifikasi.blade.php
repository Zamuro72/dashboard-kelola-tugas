@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-bell mr-2"></i>
    {{ $title }}
</h1>

<div class="mb-3">
    <a href="{{ route('peserta') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>
        Kembali
    </a>
</div>

<!-- Sertifikat Sudah Expired -->
<div class="card mb-4">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Sertifikat Sudah Expired ({{ $pesertaSudahExpired->count() }})
        </h5>
    </div>
    <div class="card-body">
        @if($pesertaSudahExpired->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>Email</th>
                        <th>No WhatsApp</th>
                        <th>Skema</th>
                        <th>Tgl Sertifikat</th>
                        <th>Tgl Expired</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pesertaSudahExpired as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nama_perusahaan }}</td>
                    <td>{{ $item->email ?? '-' }}</td>
                    <td class="text-center">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_whatsapp) }}" 
                            target="_blank">
                            {{ $item->no_whatsapp }}
                        </a>
                    </td>
                    <td>{{ $item->skema }}</td>
                    <td class="text-center">{{ $item->tanggal_sertifikat_diterima->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $item->tanggal_expired->format('d-m-Y') }}</td>
                    <td class="text-center">
                        <span class="badge badge-danger">Sudah expired sejak {{ intval(abs(now()->diffInDays($item->tanggal_expired))) }} hari yang lalu</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('pesertaEdit', $item->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-success mb-0">
            <i class="fas fa-check-circle mr-2"></i>
            Tidak ada sertifikat yang sudah expired
        </div>
        @endif
    </div>
</div>

<!-- Sertifikat Akan Expired -->
<div class="card">
    <div class="card-header bg-warning">
        <h5 class="mb-0">
            <i class="fas fa-clock mr-2"></i>
            Sertifikat Akan Expired dalam 3 Bulan ({{ $pesertaAkanExpired->count() }})
        </h5>
    </div>
    <div class="card-body">
        @if($pesertaAkanExpired->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>Email</th>
                        <th>No WhatsApp</th>
                        <th>Skema</th>
                        <th>Tgl Sertifikat</th>
                        <th>Tgl Expired</th>
                        <th>Sisa Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesertaAkanExpired as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nama_perusahaan }}</td>
                        <td>{{ $item->email ?? '-' }}</td>
                        <td class="text-center">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_whatsapp) }}" 
                               target="_blank">
                                {{ $item->no_whatsapp }}
                            </a>
                        </td>
                        <td>{{ $item->skema }}</td>
                        <td class="text-center">{{ $item->tanggal_sertifikat_diterima->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $item->tanggal_expired->format('d-m-Y') }}</td>
                        <td class="text-center">
                            @php
                                $sisaHari = now()->startOfDay()->diffInDays($item->tanggal_expired->startOfDay(), false);
                            @endphp
                            <span class="badge badge-warning">{{ $sisaHari }} hari lagi</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pesertaEdit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-success mb-0">
            <i class="fas fa-check-circle mr-2"></i>
            Tidak ada sertifikat yang akan expired dalam 3 bulan
        </div>
        @endif
    </div>
</div>

@endsection