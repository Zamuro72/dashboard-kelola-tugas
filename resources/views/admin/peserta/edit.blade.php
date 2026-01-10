@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-edit mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-warning">
        <a href="{{ route('peserta') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('pesertaUpdate', $peserta->id) }}" method="post">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> Tahun:
                    </label>
                    <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" 
                           value="{{ old('tahun', $peserta->tahun) }}" min="2000" max="2100">
                    @error('tahun')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> Nama:
                    </label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama', $peserta->nama) }}">
                    @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> Nama Perusahaan:
                    </label>
                    <input type="text" name="nama_perusahaan" class="form-control @error('nama_perusahaan') is-invalid @enderror" 
                           value="{{ old('nama_perusahaan', $peserta->nama_perusahaan) }}">
                    @error('nama_perusahaan')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> No WhatsApp:
                    </label>
                    <input type="text" name="no_whatsapp" class="form-control @error('no_whatsapp') is-invalid @enderror" 
                           value="{{ old('no_whatsapp', $peserta->no_whatsapp) }}">
                    @error('no_whatsapp')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> Tanggal Lahir:
                    </label>
                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                           value="{{ old('tanggal_lahir', $peserta->tanggal_lahir->format('Y-m-d')) }}">
                    @error('tanggal_lahir')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> Skema:
                    </label>
                    <input type="text" name="skema" class="form-control @error('skema') is-invalid @enderror" 
                           value="{{ old('skema', $peserta->skema) }}">
                    @error('skema')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> Tanggal Sertifikat Diterima:
                    </label>
                    <input type="date" name="tanggal_sertifikat_diterima" 
                           class="form-control @error('tanggal_sertifikat_diterima') is-invalid @enderror" 
                           value="{{ old('tanggal_sertifikat_diterima', $peserta->tanggal_sertifikat_diterima->format('Y-m-d')) }}">
                    @error('tanggal_sertifikat_diterima')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <small class="text-muted">Akan expired: {{ $peserta->tanggal_expired->format('d-m-Y') }}</small>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Status Pembayaran:</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="suka_telat_bayar" class="form-check-input" 
                               id="suka_telat_bayar" value="1" 
                               {{ old('suka_telat_bayar', $peserta->suka_telat_bayar) ? 'checked' : '' }}>
                        <label class="form-check-label" for="suka_telat_bayar">
                            <span class="text-danger">Tandai Suka Telat Bayar</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save mr-2"></i>
                    Update
                </button>
                <a href="{{ route('peserta') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection