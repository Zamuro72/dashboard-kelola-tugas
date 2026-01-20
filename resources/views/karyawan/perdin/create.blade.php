@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-plane mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-primary">
        <a href="{{ route('perdin') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('perdinStore') }}" method="post">
            @csrf

            <!-- Data Karyawan -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-user mr-2"></i>
                    Yang Bertanda Tangan Di Bawah Ini
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label class="form-label"><strong>Nama:</strong></label>
                            <input type="text" class="form-control" value="{{ $user->nama }}" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label"><strong>Jabatan:</strong></label>
                            <input type="text" class="form-control" value="{{ $user->jabatan }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rincian Perjalanan Dinas -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-plane mr-2"></i>
                    Rincian Perjalanan Dinas
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                <strong>Tujuan Perjalanan:</strong>
                            </label>
                            <textarea name="tujuan_perjalanan" rows="3" class="form-control @error('tujuan_perjalanan') is-invalid @enderror" placeholder="Jelaskan tujuan perjalanan dinas...">{{ old('tujuan_perjalanan') }}</textarea>
                            @error('tujuan_perjalanan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                <strong>Lokasi:</strong>
                            </label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" placeholder="Masukkan lokasi tujuan">
                            @error('lokasi')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                <strong>Transportasi:</strong>
                            </label>
                            <input type="text" name="transportasi" class="form-control @error('transportasi') is-invalid @enderror" value="{{ old('transportasi') }}" placeholder="Contoh: Mobil Pribadi, Pesawat, Kereta, dll">
                            @error('transportasi')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                <strong>Tanggal Berangkat:</strong>
                            </label>
                            <input type="date" name="tanggal_berangkat" class="form-control @error('tanggal_berangkat') is-invalid @enderror" value="{{ old('tanggal_berangkat') }}">
                            @error('tanggal_berangkat')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                <strong>Tanggal Kembali:</strong>
                            </label>
                            <input type="date" name="tanggal_kembali" class="form-control @error('tanggal_kembali') is-invalid @enderror" value="{{ old('tanggal_kembali') }}">
                            @error('tanggal_kembali')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">
                                <strong>Uang Muka:</strong>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" id="uang_muka_display" class="form-control @error('uang_muka') is-invalid @enderror" value="{{ old('uang_muka', 0) ? number_format(old('uang_muka', 0), 0, ',', '.') : '0' }}" placeholder="Contoh: 100.000">
                                <input type="hidden" name="uang_muka" id="uang_muka_hidden" value="{{ old('uang_muka', 0) }}">
                            </div>
                            @error('uang_muka')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Format currency input
    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    var uangMukaDisplay = document.getElementById('uang_muka_display');
    var uangMukaHidden = document.getElementById('uang_muka_hidden');

    uangMukaDisplay.addEventListener('keyup', function(e) {
        var value = this.value;
        this.value = formatRupiah(value);
        // Set hidden field with raw number
        uangMukaHidden.value = value.replace(/\./g, '');
    });

    // Format initial value jika ada
    if (uangMukaDisplay.value && uangMukaDisplay.value != '0') {
        uangMukaDisplay.value = formatRupiah(uangMukaDisplay.value);
    }
</script>

@endsection

