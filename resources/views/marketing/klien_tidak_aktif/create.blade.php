@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('klien.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Klien Tidak Aktif</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('klien-tidak-aktif.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', date('Y')) }}" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama Klien</label>
                            <input type="text" name="nama_klien" class="form-control @error('nama_klien') is-invalid @enderror" value="{{ old('nama_klien') }}">
                            @error('nama_klien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Perusahaan</label>
                            <input type="text" name="nama_perusahaan" class="form-control @error('nama_perusahaan') is-invalid @enderror" value="{{ old('nama_perusahaan') }}">
                            @error('nama_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Bidang Usaha</label>
                            <input type="text" name="bidang_usaha" class="form-control @error('bidang_usaha') is-invalid @enderror" value="{{ old('bidang_usaha') }}">
                            @error('bidang_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kota</label>
                            <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror" value="{{ old('kota') }}">
                            @error('kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>WhatsApp</label>
                            <input type="text" name="no_whatsapp" class="form-control @error('no_whatsapp') is-invalid @enderror" value="{{ old('no_whatsapp') }}" placeholder="Contoh: 08123456789">
                            @error('no_whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Produk Minat</label>
                            <input type="text" name="produk_minat" class="form-control @error('produk_minat') is-invalid @enderror" value="{{ old('produk_minat') }}">
                            @error('produk_minat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>PIC Sales</label>
                            <input type="text" name="pic_sales" class="form-control @error('pic_sales') is-invalid @enderror" value="{{ old('pic_sales') }}">
                            @error('pic_sales')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Status --</option>
                                <option value="belum dihubungi" {{ old('status') == 'belum dihubungi' ? 'selected' : '' }}>Belum Dihubungi</option>
                                <option value="sudah diblasting" {{ old('status') == 'sudah diblasting' ? 'selected' : '' }}>Sudah Diblasting</option>
                                <option value="menunggu respon" {{ old('status') == 'menunggu respon' ? 'selected' : '' }}>Menunggu Respon</option>
                                <option value="ongoing proses deal" {{ old('status') == 'ongoing proses deal' ? 'selected' : '' }}>Ongoing Proses Deal</option>
                                <option value="deal" {{ old('status') == 'deal' ? 'selected' : '' }}>Deal</option>
                                <option value="tidak berminat" {{ old('status') == 'tidak berminat' ? 'selected' : '' }}>Tidak Berminat</option>
                                <option value="belum jelas" {{ old('status') == 'belum jelas' ? 'selected' : '' }}>Belum Jelas</option>
                                <option value="follow up" {{ old('status') == 'follow up' ? 'selected' : '' }}>Follow Up</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('klien.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
