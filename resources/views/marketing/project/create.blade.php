@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-plus mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-primary">
        <a href="{{ route('marketing.project') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('marketing.project.store') }}" method="post">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span>
                        <strong>Skema:</strong>
                    </label>
                    <input type="text" name="skema" class="form-control @error('skema') is-invalid @enderror" 
                           value="{{ old('skema') }}" placeholder="Masukkan nama skema">
                    @error('skema')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">
                        <span class="text-danger">*</span>
                        <strong>Tanggal:</strong>
                    </label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                           value="{{ old('tanggal') }}">
                    @error('tanggal')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">
                        <span class="text-danger">*</span>
                        <strong>Timeline:</strong>
                    </label>
                    <input type="text" name="timeline" class="form-control @error('timeline') is-invalid @enderror" 
                           value="{{ old('timeline') }}" placeholder="Contoh: 2 minggu, 1 bulan, dll">
                    @error('timeline')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Project
                </button>
                <a href="{{ route('marketing.project') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection