@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('klien-tidak-aktif.index', request('from') == 'dashboard' ? ['from' => 'dashboard'] : []) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Klien Tidak Aktif</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('klien-tidak-aktif.update', $klien->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Tahun <span class="text-danger">*</span></label>
                    <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', $klien->tahun) }}" required>
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="" disabled>-- Pilih Status --</option>
                        <option value="ongoing proses deal" {{ old('status', $klien->status) == 'ongoing proses deal' ? 'selected' : '' }}>Ongoing Proses Deal</option>
                        <option value="belum jelas" {{ old('status', $klien->status) == 'belum jelas' ? 'selected' : '' }}>Belum Jelas</option>
                        <option value="follow up" {{ old('status', $klien->status) == 'follow up' ? 'selected' : '' }}>Follow Up</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tipe Klien <span class="text-danger">*</span></label>
                    <select name="tipe_klien" id="tipe_klien" class="form-control @error('tipe_klien') is-invalid @enderror" required>
                        <option value="" disabled>-- Pilih Tipe Klien --</option>
                        <option value="Personal" {{ old('tipe_klien', $klien->tipe_klien) == 'Personal' ? 'selected' : '' }}>Personal</option>
                        <option value="Perusahaan" {{ old('tipe_klien', $klien->tipe_klien) == 'Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                    </select>
                    @error('tipe_klien')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Form Personal -->
                <div id="form-personal" style="display: none;">
                    <div class="form-group">
                        <label>Nama Klien <span class="text-danger">*</span></label>
                        <input type="text" name="nama_klien" id="nama_klien" class="form-control @error('nama_klien') is-invalid @enderror" value="{{ old('nama_klien', $klien->nama_klien) }}">
                        @error('nama_klien')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', optional($klien->tanggal_lahir)->format('Y-m-d')) }}">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Perusahaan -->
                <div id="form-perusahaan" style="display: none;">
                    <div class="form-group">
                        <label>Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control @error('nama_perusahaan') is-invalid @enderror" value="{{ old('nama_perusahaan', $klien->nama_perusahaan) }}">
                        @error('nama_perusahaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nama Penanggung Jawab</label>
                        <input type="text" name="nama_penanggung_jawab" class="form-control @error('nama_penanggung_jawab') is-invalid @enderror" value="{{ old('nama_penanggung_jawab', $klien->nama_penanggung_jawab) }}">
                        @error('nama_penanggung_jawab')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Umum -->
                <div id="data-umum" style="display: none;">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $klien->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>No WhatsApp</label>
                        <input type="text" name="no_whatsapp" class="form-control @error('no_whatsapp') is-invalid @enderror" value="{{ old('no_whatsapp', $klien->no_whatsapp) }}" placeholder="Contoh: 08123456789">
                        @error('no_whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui
                    </button>
                    <a href="{{ route('klien-tidak-aktif.index', request('from') == 'dashboard' ? ['from' => 'dashboard'] : []) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectTipe = document.getElementById('tipe_klien');
    const formPersonal = document.getElementById('form-personal');
    const formPerusahaan = document.getElementById('form-perusahaan');
    const dataUmum = document.getElementById('data-umum');
    
    const inputNamaKlien = document.getElementById('nama_klien');
    const inputNamaPerusahaan = document.getElementById('nama_perusahaan');

    function toggleForms() {
        const tipe = selectTipe.value;
        if(tipe === 'Personal') {
            formPersonal.style.display = 'block';
            formPerusahaan.style.display = 'none';
            dataUmum.style.display = 'block';
            
            inputNamaKlien.setAttribute('required', 'required');
            inputNamaPerusahaan.removeAttribute('required');
        } else if(tipe === 'Perusahaan') {
            formPersonal.style.display = 'none';
            formPerusahaan.style.display = 'block';
            dataUmum.style.display = 'block';
            
            inputNamaPerusahaan.setAttribute('required', 'required');
            inputNamaKlien.removeAttribute('required');
        } else {
            formPersonal.style.display = 'none';
            formPerusahaan.style.display = 'none';
            dataUmum.style.display = 'none';
            
            inputNamaKlien.removeAttribute('required');
            inputNamaPerusahaan.removeAttribute('required');
        }
    }

    selectTipe.addEventListener('change', toggleForms);
    toggleForms();
});
</script>
@endsection
