@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <div>
            <a href="{{ route('klien.notifikasi') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm mr-2">
                <i class="fas fa-bell fa-sm text-white-50"></i> 
                Notifikasi
                @if($jumlahAkanExpired > 0 || $jumlahSudahExpired > 0)
                    <span class="badge badge-light">{{ $jumlahAkanExpired + $jumlahSudahExpired }}</span>
                @endif
            </a>
            <a href="{{ route('klien.import.form') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mr-2">
                <i class="fas fa-file-excel fa-sm text-white-50"></i> Import Data
            </a>
            <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambahKlien">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
            </button>
        </div>
    </div>

    <!-- Modal Tambah Klien -->
    <div class="modal fade" id="modalTambahKlien" tabindex="-1" role="dialog" aria-labelledby="modalTambahKlienLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKlienLabel">Tambah Data Klien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formPilihJasa">
                        <div class="form-group">
                            <label for="pilihJasa">Pilih Jasa</label>
                            <select class="form-control" id="pilihJasa" required>
                                <option value="" disabled selected>-- Pilih Jasa --</option>
                                @foreach($jasaList as $jasa)
                                    <option value="{{ $jasa->id }}" 
                                            data-has-skema="{{ $jasa->has_skema ? '1' : '0' }}"
                                            data-skemas='{{ json_encode($jasa->skema) }}'>
                                        {{ $jasa->nama_jasa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pilihTahun">Tahun</label>
                            <input type="number" class="form-control" id="pilihTahun" value="{{ date('Y') }}" required>
                        </div>
                        <div class="form-group" id="groupSkema" style="display: none;">
                            <label for="pilihSkema">Pilih Skema</label>
                            <select class="form-control" id="pilihSkema">
                                <option value="" disabled selected>-- Pilih Skema --</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnLanjutTambah">Lanjut</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const pilihJasa = document.getElementById('pilihJasa');
        const pilihSkema = document.getElementById('pilihSkema');
        const groupSkema = document.getElementById('groupSkema');
        const btnLanjut = document.getElementById('btnLanjutTambah');

        pilihJasa.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const hasSkema = selectedOption.getAttribute('data-has-skema') === '1';
            const skemas = JSON.parse(selectedOption.getAttribute('data-skemas') || '[]');

            pilihSkema.innerHTML = '<option value="" disabled selected>-- Pilih Skema --</option>';

            if (hasSkema) {
                groupSkema.style.display = 'block';
                pilihSkema.required = true;
                skemas.forEach(skema => {
                    const option = document.createElement('option');
                    option.value = skema.id;
                    option.textContent = skema.nama_skema;
                    pilihSkema.appendChild(option);
                });
            } else {
                groupSkema.style.display = 'none';
                pilihSkema.required = false;
            }
        });

        btnLanjut.addEventListener('click', function() {
            const jasaId = pilihJasa.value;
            const tahun = document.getElementById('pilihTahun').value;
            const skemaId = pilihSkema.value;
            const hasSkema = pilihJasa.options[pilihJasa.selectedIndex].getAttribute('data-has-skema') === '1';

            if (!jasaId) {
                alert('Silakan pilih jasa terlebih dahulu');
                return;
            }
            if (!tahun) {
                alert('Silakan isi tahun');
                return;
            }
            if (hasSkema && !skemaId) {
                alert('Silakan pilih skema');
                return;
            }

            let url = '';
            if (hasSkema) {
                url = `{{ url('klien') }}/${jasaId}/tahun/${tahun}/skema/${skemaId}/create`;
            } else {
                url = `{{ url('klien') }}/${jasaId}/tahun/${tahun}/create`;
            }
            
            window.location.href = url;
        });
    });
    </script>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Alert Notifikasi -->
    @if($jumlahAkanExpired > 0)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Perhatian!</strong> Ada {{ $jumlahAkanExpired }} sertifikat klien yang akan expired dalam 3 bulan ke depan.
            <a href="{{ route('klien.notifikasi') }}" class="alert-link">Lihat detail</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($jumlahSudahExpired > 0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle"></i>
            <strong>Perhatian!</strong> Ada {{ $jumlahSudahExpired }} sertifikat klien yang sudah expired.
            <a href="{{ route('klien.notifikasi') }}" class="alert-link">Lihat detail</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Daftar Jasa -->
    <div class="row">
        @foreach($jasaList as $jasa)
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('klien.tahun', $jasa->id) }}" class="text-decoration-none">
                    <div class="card border-left-primary shadow h-100 py-2 hover-card">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">
                                        {{ $jasa->nama_jasa }}
                                    </div>
                                    <div class="text-xs text-muted mt-2">
                                        Masa Berlaku: {{ $jasa->masa_berlaku_tahun }} Tahun
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-arrow-right fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection