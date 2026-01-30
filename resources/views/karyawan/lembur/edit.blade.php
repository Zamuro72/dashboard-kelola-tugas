@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-clock mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-primary">
        <a href="{{ route('lembur') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('lemburUpdate', $lembur->id) }}" method="post">
            @csrf

            <!-- Data Karyawan -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-user mr-2"></i>
                    Data Karyawan
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label class="form-label"><strong>Nama Karyawan:</strong></label>
                            <input type="text" class="form-control" value="{{ $user->nama }}" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label"><strong>Jabatan:</strong></label>
                            <input type="text" class="form-control" value="{{ $user->jabatan }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Waktu dan Tempat Lembur -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Waktu dan Tempat Lembur
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                <strong>Tanggal Pelaksanaan:</strong>
                            </label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror" value="{{ old('tanggal_pelaksanaan', $lembur->tanggal_pelaksanaan->format('Y-m-d')) }}">
                            @error('tanggal_pelaksanaan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label"><strong>Hari:</strong></label>
                            <input type="text" id="hari_display" class="form-control" value="{{ $lembur->hari }}" readonly placeholder="Otomatis dari tanggal">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                <strong>Jam Kerja Normal:</strong>
                            </label>
                            <div class="input-group">
                                <input type="time" name="jam_kerja_mulai" class="form-control @error('jam_kerja_mulai') is-invalid @enderror" value="{{ old('jam_kerja_mulai', \Carbon\Carbon::parse($lembur->jam_kerja_mulai)->format('H:i')) }}">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text">s.d.</span>
                                </div>
                                <input type="time" name="jam_kerja_selesai" class="form-control @error('jam_kerja_selesai') is-invalid @enderror" value="{{ old('jam_kerja_selesai', \Carbon\Carbon::parse($lembur->jam_kerja_selesai)->format('H:i')) }}">
                            </div>
                            @error('jam_kerja_mulai')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @error('jam_kerja_selesai')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                <strong>Jam Lembur:</strong>
                            </label>
                            <div class="input-group">
                                <input type="time" name="jam_lembur_mulai" id="jam_lembur_mulai" class="form-control @error('jam_lembur_mulai') is-invalid @enderror" value="{{ old('jam_lembur_mulai', \Carbon\Carbon::parse($lembur->jam_lembur_mulai)->format('H:i')) }}">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text">s.d.</span>
                                </div>
                                <input type="time" name="jam_lembur_selesai" id="jam_lembur_selesai" class="form-control @error('jam_lembur_selesai') is-invalid @enderror" value="{{ old('jam_lembur_selesai', \Carbon\Carbon::parse($lembur->jam_lembur_selesai)->format('H:i')) }}">
                            </div>
                            @error('jam_lembur_mulai')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @error('jam_lembur_selesai')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label class="form-label"><strong>Total Jam Lembur:</strong></label>
                            <div class="input-group">
                                <input type="text" id="total_jam_lembur" class="form-control" value="{{ abs(intval($lembur->total_jam_lembur)) }}" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">Jam</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                <strong>Lokasi/Tempat Kerja:</strong>
                            </label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi', $lembur->lokasi) }}" placeholder="Masukkan lokasi lembur">
                            @error('lokasi')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Uraian Pekerjaan -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-tasks mr-2"></i>
                    Uraian Pekerjaan Yang Dilaksanakan
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <textarea name="uraian_pekerjaan" rows="5" class="form-control @error('uraian_pekerjaan') is-invalid @enderror" placeholder="Jelaskan pekerjaan yang akan dilaksanakan selama lembur...">{{ old('uraian_pekerjaan', $lembur->uraian_pekerjaan) }}</textarea>
                            @error('uraian_pekerjaan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Update Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Hitung total jam lembur otomatis
    function calculateTotalJamLembur() {
        var jamMulai = document.getElementById('jam_lembur_mulai').value;
        var jamSelesai = document.getElementById('jam_lembur_selesai').value;

        if (jamMulai && jamSelesai) {
            var mulai = new Date('2000-01-01 ' + jamMulai);
            var selesai = new Date('2000-01-01 ' + jamSelesai);
            var diff = (selesai - mulai) / (1000 * 60 * 60);
            if (diff < 0) diff += 24; // Handle overnight
            document.getElementById('total_jam_lembur').value = Math.floor(Math.abs(diff));
        }
    }

    // Konversi tanggal ke nama hari
    function updateHari() {
        var tanggal = document.querySelector('input[name="tanggal_pelaksanaan"]').value;
        if (tanggal) {
            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var date = new Date(tanggal);
            document.getElementById('hari_display').value = days[date.getDay()];
        }
    }

    document.getElementById('jam_lembur_mulai').addEventListener('change', calculateTotalJamLembur);
    document.getElementById('jam_lembur_selesai').addEventListener('change', calculateTotalJamLembur);
    document.querySelector('input[name="tanggal_pelaksanaan"]').addEventListener('change', updateHari);
</script>

@endsection
