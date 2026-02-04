@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        @if($klien->skema_id)
            <a href="{{ route('klien.data.skema', ['jasaId' => $klien->jasa_id, 'tahun' => $klien->tahun, 'skemaId' => $klien->skema_id]) }}" 
               class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        @else
            <a href="{{ route('klien.data', ['jasaId' => $klien->jasa_id, 'tahun' => $klien->tahun]) }}" 
               class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        @endif
    </div>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Klien</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('klien.update', $klien->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Info Jasa -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="font-weight-bold">Jasa:</label>
                        <p>{{ $klien->jasa->nama_jasa }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Tahun:</label>
                        <p>{{ $klien->tahun }}</p>
                    </div>
                    @if($klien->skema)
                        <div class="col-md-4">
                            <label class="font-weight-bold">Skema:</label>
                            <p>{{ $klien->skema->nama_skema }}</p>
                        </div>
                    @endif
                </div>

                <hr>

                <!-- Tipe Klien -->
                <div class="form-group">
                    <label for="tipe_klien">Tipe Klien <span class="text-danger">*</span></label>
                    <select name="tipe_klien" id="tipe_klien" 
                            class="form-control @error('tipe_klien') is-invalid @enderror" required>
                        <option value="">-- Pilih Tipe Klien --</option>
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
                        <label for="nama_klien">Nama Klien <span class="text-danger">*</span></label>
                        <input type="text" name="nama_klien" id="nama_klien" 
                               class="form-control @error('nama_klien') is-invalid @enderror" 
                               value="{{ old('nama_klien', $klien->nama_klien) }}" 
                               placeholder="Masukkan nama klien">
                        @error('nama_klien')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_perusahaan_personal">Nama Perusahaan (Opsional)</label>
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan_personal" 
                               class="form-control @error('nama_perusahaan') is-invalid @enderror" 
                               value="{{ old('nama_perusahaan', $klien->nama_perusahaan) }}" 
                               placeholder="Masukkan nama perusahaan">
                        @error('nama_perusahaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Perusahaan -->
                <div id="form-perusahaan" style="display: none;">
                    <div class="form-group">
                        <label for="nama_perusahaan_perusahaan">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan_perusahaan" 
                               class="form-control @error('nama_perusahaan') is-invalid @enderror" 
                               value="{{ old('nama_perusahaan', $klien->nama_perusahaan) }}" 
                               placeholder="Masukkan nama perusahaan">
                        @error('nama_perusahaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_penanggung_jawab">Nama Penanggung Jawab <span class="text-danger">*</span></label>
                        <input type="text" name="nama_penanggung_jawab" id="nama_penanggung_jawab" 
                               class="form-control @error('nama_penanggung_jawab') is-invalid @enderror" 
                               value="{{ old('nama_penanggung_jawab', $klien->nama_penanggung_jawab) }}" 
                               placeholder="Masukkan nama penanggung jawab">
                        @error('nama_penanggung_jawab')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Umum -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $klien->email) }}" placeholder="Masukkan email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="no_whatsapp">No WhatsApp</label>
                    <input type="text" name="no_whatsapp" id="no_whatsapp" 
                           class="form-control @error('no_whatsapp') is-invalid @enderror" 
                           value="{{ old('no_whatsapp', $klien->no_whatsapp) }}" 
                           placeholder="Masukkan nomor WhatsApp">
                    @error('no_whatsapp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sertifikat_terbit">Sertifikat Terbit</label>
                    <input type="date" name="sertifikat_terbit" id="sertifikat_terbit" 
                           class="form-control @error('sertifikat_terbit') is-invalid @enderror" 
                           value="{{ old('sertifikat_terbit', $klien->sertifikat_terbit ? $klien->sertifikat_terbit->format('Y-m-d') : '') }}">
                    @error('sertifikat_terbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        Masa berlaku sertifikat: {{ $klien->jasa->masa_berlaku_tahun }} tahun
                    </small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                    @if($klien->skema_id)
                        <a href="{{ route('klien.data.skema', ['jasaId' => $klien->jasa_id, 'tahun' => $klien->tahun, 'skemaId' => $klien->skema_id]) }}" 
                           class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    @else
                        <a href="{{ route('klien.data', ['jasaId' => $klien->jasa_id, 'tahun' => $klien->tahun]) }}" 
                           class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipeKlien = document.getElementById('tipe_klien');
    const formPersonal = document.getElementById('form-personal');
    const formPerusahaan = document.getElementById('form-perusahaan');
    const namaPerusahaanPersonal = document.getElementById('nama_perusahaan_personal');
    const namaPerusahaanPerusahaan = document.getElementById('nama_perusahaan_perusahaan');

    function toggleForm() {
        const value = tipeKlien.value;
        
        if (value === 'Personal') {
            formPersonal.style.display = 'block';
            formPerusahaan.style.display = 'none';
            document.getElementById('nama_klien').required = true;
            namaPerusahaanPerusahaan.required = false;
            document.getElementById('nama_penanggung_jawab').required = false;
            namaPerusahaanPerusahaan.disabled = true;
            namaPerusahaanPersonal.disabled = false;
        } else if (value === 'Perusahaan') {
            formPersonal.style.display = 'none';
            formPerusahaan.style.display = 'block';
            document.getElementById('nama_klien').required = false;
            namaPerusahaanPerusahaan.required = true;
            document.getElementById('nama_penanggung_jawab').required = true;
            namaPerusahaanPersonal.disabled = true;
            namaPerusahaanPerusahaan.disabled = false;
        } else {
            formPersonal.style.display = 'none';
            formPerusahaan.style.display = 'none';
        }
    }

    tipeKlien.addEventListener('change', toggleForm);
    toggleForm(); // Trigger on load
});
</script>
@endsection