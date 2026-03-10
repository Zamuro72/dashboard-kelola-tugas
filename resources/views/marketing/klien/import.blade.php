@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('klien.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

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

    <!-- Instruksi Import -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-info">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-info-circle"></i> Instruksi Import Data Klien
            </h6>
        </div>
        <div class="card-body">
            <h6 class="font-weight-bold">Format File Excel:</h6>
            <p>File Excel harus memiliki kolom-kolom berikut (dengan heading di baris pertama):</p>
            
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="bg-light">
                        <tr>
                            <th>Nama Kolom</th>
                            <th>Keterangan</th>
                            <th>Wajib/Opsional</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>jasa</code></td>
                            <td>Nama jasa (opsional, otomatis terdeteksi dari skema)</td>
                            <td><span class="badge badge-secondary">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>skema</code></td>
                            <td>Nama skema/sertifikasi</td>
                            <td><span class="badge badge-danger">Wajib</span></td>
                        </tr>
                        <tr>
                            <td><code>tipe_klien</code></td>
                            <td>Personal atau Perusahaan</td>
                            <td><span class="badge badge-secondary">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>nama_klien</code></td>
                            <td>Nama klien (untuk tipe Personal)</td>
                            <td><span class="badge badge-secondary">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>nama_perusahaan</code></td>
                            <td>Nama perusahaan</td>
                            <td><span class="badge badge-secondary">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>nama_penanggung_jawab</code></td>
                            <td>Nama penanggung jawab (untuk tipe Perusahaan)</td>
                            <td><span class="badge badge-secondary">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>email</code></td>
                            <td>Email klien</td>
                            <td><span class="badge badge-secondary">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>no_whatsapp</code></td>
                            <td>Nomor WhatsApp</td>
                            <td><span class="badge badge-secondary">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>sertifikat_terbit</code></td>
                            <td>Tanggal sertifikat terbit (format: YYYY-MM-DD atau DD-MM-YYYY)</td>
                            <td><span class="badge badge-secondary">Opsional</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <h6 class="font-weight-bold mt-4">Deteksi Otomatis Jasa:</h6>
            <ul>
                <li><strong>BNSP:</strong> Sistem akan otomatis mendeteksi jasa BNSP dari nama skema seperti "Ahli K3 Umum BNSP", "PPPA", "Fire Safety Manager", dll.</li>
                <li><strong>Kemnaker RI:</strong> Sistem akan otomatis mendeteksi jasa Kemnaker dari nama skema seperti "Ahli K3 Umum Kemnaker", "Operator Forklift", dll.</li>
                <li><strong>ISO:</strong> Sistem akan otomatis mendeteksi jasa ISO dari nama skema seperti "9001", "ISO 9001", "14001", dll.</li>
            </ul>

            <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-triangle"></i> 
                <strong>Penting:</strong>
                <ul class="mb-0">
                    <li>Pastikan nama skema sesuai dengan data yang sudah ada di sistem</li>
                    <li>Tahun akan otomatis terdeteksi dari tanggal sertifikat terbit</li>
                    <li>Jika tidak ada tanggal sertifikat terbit, tahun akan menggunakan tahun saat ini</li>
                    <li>Format file yang didukung: .xlsx, .xls, .csv</li>
                    <li>Ukuran file maksimal: 5MB</li>
                </ul>
            </div>

            <h6 class="font-weight-bold mt-4">Contoh Data Excel:</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="bg-light">
                        <tr>
                            <th>skema</th>
                            <th>tipe_klien</th>
                            <th>nama_klien</th>
                            <th>nama_perusahaan</th>
                            <th>nama_penanggung_jawab</th>
                            <th>email</th>
                            <th>no_whatsapp</th>
                            <th>sertifikat_terbit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ahli K3 Umum BNSP</td>
                            <td>Personal</td>
                            <td>Budi Santoso</td>
                            <td>PT Maju Jaya</td>
                            <td></td>
                            <td>budi@email.com</td>
                            <td>081234567890</td>
                            <td>2024-01-15</td>
                        </tr>
                        <tr>
                            <td>ISO 9001</td>
                            <td>Perusahaan</td>
                            <td></td>
                            <td>PT Sejahtera Abadi</td>
                            <td>Andi Wijaya</td>
                            <td>info@sejahtera.com</td>
                            <td>081298765432</td>
                            <td>2023-06-20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Upload -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-file-upload"></i> Upload File Excel
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('klien.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="file">Pilih File Excel <span class="text-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" name="file" 
                               class="custom-file-input @error('file') is-invalid @enderror" 
                               id="file" accept=".xlsx,.xls,.csv" required>
                        <label class="custom-file-label" for="file">Pilih file...</label>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        Format: .xlsx, .xls, .csv | Maksimal: 5MB
                    </small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Import Data
                    </button>
                    <a href="{{ route('klien.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
// Update label file input with filename
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>
@endsection