@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-upload mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header">
        <a href="{{ route('peserta') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('pesertaImport') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label for="file"><strong>Pilih File Excel</strong></label>
                        <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                        @error('file')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">Format yang didukung: .xlsx, .xls, .csv (Max 5MB)</small>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <h6><strong>📋 Format Excel Yang Dibutuhkan:</strong></h6>
                        <p class="mb-2">File Excel harus memiliki kolom dengan header tepat seperti berikut:</p>
                        <table class="table table-sm table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama Kolom</th>
                                    <th>Tipe Data</th>
                                    <th>Contoh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><code>tahun</code></td>
                                    <td>Angka (4 digit)</td>
                                    <td>2025</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><code>nama</code></td>
                                    <td>Teks</td>
                                    <td>Budi Santoso</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><code>nama_perusahaan</code></td>
                                    <td>Teks</td>
                                    <td>PT Maju Jaya</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><code>no_whatsapp</code></td>
                                    <td>Teks/Angka</td>
                                    <td>08123456789 atau +62812345678</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><code>tanggal_lahir</code></td>
                                    <td>Tanggal (YYYY-MM-DD)</td>
                                    <td>2000-01-15</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td><code>skema</code></td>
                                    <td>Teks</td>
                                    <td>BNSP atau Kemnaker RI</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td><code>tanggal_sertifikat_diterima</code></td>
                                    <td>Tanggal (YYYY-MM-DD)</td>
                                    <td>2023-01-15</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td><code>suka_telat_bayar</code></td>
                                    <td>Teks (Ya/Tidak)</td>
                                    <td>Ya atau Tidak</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <h6><strong>⚠️ Catatan Penting:</strong></h6>
                        <ul class="mb-0">
                            <li>Pastikan header kolom <strong>PERSIS</strong> sesuai dengan nama yang tertera di atas (case-sensitive untuk huruf kecil)</li>
                            <li>Jangan ada kolom kosong atau kolom tambahan yang tidak perlu</li>
                            <li>Format tanggal harus <strong>YYYY-MM-DD</strong> (contoh: 2023-01-15)</li>
                            <li>Kolom "suka_telat_bayar" hanya boleh berisi <strong>"Ya"</strong> atau <strong>"Tidak"</strong></li>
                            <li>Semua kolom adalah <strong>WAJIB</strong> diisi, tidak boleh kosong</li>
                            <li>Baris pertama harus berisi header, data mulai dari baris kedua</li>
                            <li><strong>✨ Fitur otomatis:</strong> Tahun akan otomatis terdeteksi dari nama file (contoh: <code>data peserta 2025.xlsx</code> → tahun <code>2025</code>). Kolom tahun di Excel bisa diisi apapun, akan ditimpa dengan tahun dari nama file.</li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload mr-2"></i>
                            Import Data
                        </button>
                        <a href="{{ route('peserta') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>

                <div class="alert alert-secondary mt-4">
                    <h6><strong>💡 Contoh Struktur File Excel:</strong></h6>
                    <p><strong>Fitur Otomatis Tahun:</strong> Nama file akan otomatis di-scan untuk mencari tahun. Beberapa contoh:</p>
                    <ul class="small mb-0">
                        <li><code>data peserta 2025.xlsx</code> → Tahun 2025 (otomatis)</li>
                        <li><code>peserta_2024.xlsx</code> → Tahun 2024 (otomatis)</li>
                        <li><code>2025-peserta-new.xlsx</code> → Tahun 2025 (otomatis)</li>
                        <li><code>peserta.xlsx</code> → Akan menggunakan tahun dari kolom Excel</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title"><strong>📝 Tips Import Data</strong></h6>
                        <ul class="small">
                            <li>Siapkan file Excel dengan format yang benar</li>
                            <li>Periksa kembali data sebelum import</li>
                            <li>Jika ada error, perbaiki dan coba lagi</li>
                            <li>Data duplikat akan tetap masuk, periksa sebelum import</li>
                            <li>Proses import bisa memakan waktu untuk data banyak</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
