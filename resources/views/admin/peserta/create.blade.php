@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-plus mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-primary">
        <a href="{{ route('peserta') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('pesertaStore') }}" method="post">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> Tahun:
                    </label>
                    <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" 
                           value="{{ old('tahun', date('Y')) }}" min="2000" max="2100">
                    @error('tahun')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> Nama:
                    </label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama') }}" placeholder="Masukkan nama peserta">
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
                           value="{{ old('nama_perusahaan') }}" placeholder="Masukkan nama perusahaan">
                    @error('nama_perusahaan')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> No WhatsApp:
                    </label>
                    <input type="text" name="no_whatsapp" class="form-control @error('no_whatsapp') is-invalid @enderror" 
                           value="{{ old('no_whatsapp') }}" placeholder="Contoh: 08123456789">
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
                           value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span> Skema:
                    </label>
                    <input type="text" name="skema" class="form-control @error('skema') is-invalid @enderror" 
                           value="{{ old('skema') }}" placeholder="Masukkan skema sertifikasi">
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
                           value="{{ old('tanggal_sertifikat_diterima') }}">
                    @error('tanggal_sertifikat_diterima')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <small class="text-muted">Sertifikat akan expired 3 tahun dari tanggal ini</small>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Status Pembayaran:</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="suka_telat_bayar" class="form-check-input" 
                               id="suka_telat_bayar" value="1" {{ old('suka_telat_bayar') ? 'checked' : '' }}>
                        <label class="form-check-label" for="suka_telat_bayar">
                            <span class="text-danger">Tandai Suka Telat Bayar</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
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