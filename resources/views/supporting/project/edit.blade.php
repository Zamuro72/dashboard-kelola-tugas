@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-check-circle mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-warning">
        <a href="{{ route('supporting.project') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
    <div class="card-body">
        <!-- Info Project -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-info-circle mr-2"></i>
                Informasi Project
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="200"><strong>Marketing</strong></td>
                        <td width="20">:</td>
                        <td>{{ $project->marketingUser->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Skema</strong></td>
                        <td>:</td>
                        <td>{{ $project->skema }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal</strong></td>
                        <td>:</td>
                        <td>{{ $project->tanggal->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Timeline</strong></td>
                        <td>:</td>
                        <td>{{ $project->timeline }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Kebutuhan dari Operasional -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-clipboard-list mr-2"></i>
                Kebutuhan dari Operasional
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="200"><strong>Surat Tugas</strong></td>
                        <td width="20">:</td>
                        <td>
                            @if($project->need_surat_tugas)
                                <span class="badge badge-success">Diperlukan</span>
                            @else
                                <span class="badge badge-secondary">Tidak Diperlukan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Invoice</strong></td>
                        <td>:</td>
                        <td>
                            @if($project->need_invoice)
                                <span class="badge badge-success">Diperlukan</span>
                            @else
                                <span class="badge badge-secondary">Tidak Diperlukan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Jadwal Meeting</strong></td>
                        <td>:</td>
                        <td>
                            @if($project->need_jadwal_meeting)
                                <span class="badge badge-success">Diperlukan</span>
                            @else
                                <span class="badge badge-secondary">Tidak Diperlukan</span>
                            @endif
                        </td>
                    </tr>
                    @if($project->catatan_operasional)
                    <tr>
                        <td><strong>Catatan Operasional</strong></td>
                        <td>:</td>
                        <td>{{ $project->catatan_operasional }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Form Lengkapi Kebutuhan -->
        <form action="{{ route('supporting.project.update', $project->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-upload mr-2"></i>
                    Lengkapi Kebutuhan
                </div>
                <div class="card-body">
                    @if($project->need_surat_tugas)
                    <div class="form-group">
                        <label>
                            <span class="text-danger">*</span>
                            <strong>Upload Surat Tugas (PDF/Gambar):</strong>
                        </label>
                        <input type="file" name="surat_tugas_file" class="form-control-file @error('surat_tugas_file') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG (Max: 5MB)</small>
                        @error('surat_tugas_file')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    @if($project->need_invoice)
                    <div class="form-group">
                        <label>
                            <span class="text-danger">*</span>
                            <strong>Upload Invoice (PDF/Gambar):</strong>
                        </label>
                        <input type="file" name="invoice_file" class="form-control-file @error('invoice_file') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG (Max: 5MB)</small>
                        @error('invoice_file')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    @if($project->need_jadwal_meeting)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span>
                                    <strong>Tanggal Meeting:</strong>
                                </label>
                                <input type="date" name="jadwal_meeting_tanggal" class="form-control @error('jadwal_meeting_tanggal') is-invalid @enderror" value="{{ old('jadwal_meeting_tanggal') }}">
                                @error('jadwal_meeting_tanggal')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span>
                                    <strong>Waktu Meeting:</strong>
                                </label>
                                <input type="time" name="jadwal_meeting_waktu" class="form-control @error('jadwal_meeting_waktu') is-invalid @enderror" value="{{ old('jadwal_meeting_waktu') }}">
                                @error('jadwal_meeting_waktu')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label><strong>Catatan (Opsional):</strong></label>
                        <textarea name="catatan_supporting" rows="4" class="form-control" placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan_supporting') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check mr-2"></i>
                    Tandai Selesai
                </button>
                <a href="{{ route('supporting.project') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection