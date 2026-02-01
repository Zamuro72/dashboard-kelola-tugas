@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-clipboard-list mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-warning">
        <a href="{{ route('operasional.project') }}" class="btn btn-sm btn-success">
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

        <!-- Form Kebutuhan -->
        <form action="{{ route('operasional.project.update', $project->id) }}" method="post">
            @csrf

            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Pilih Kebutuhan Project
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label><strong>Kebutuhan yang Diperlukan:</strong></label>
                        <div class="form-check">
                            <input type="checkbox" name="need_surat_tugas" class="form-check-input" id="need_surat_tugas" value="1" {{ old('need_surat_tugas') ? 'checked' : '' }}>
                            <label class="form-check-label" for="need_surat_tugas">
                                Surat Tugas
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="need_invoice" class="form-check-input" id="need_invoice" value="1" {{ old('need_invoice') ? 'checked' : '' }}>
                            <label class="form-check-label" for="need_invoice">
                                Invoice
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="need_jadwal_meeting" class="form-check-input" id="need_jadwal_meeting" value="1" {{ old('need_jadwal_meeting') ? 'checked' : '' }}>
                            <label class="form-check-label" for="need_jadwal_meeting">
                                Jadwal Meeting
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><strong>Catatan (Opsional):</strong></label>
                        <textarea name="catatan_operasional" rows="4" class="form-control" placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan_operasional') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Kirim ke Supporting
                </button>
                <a href="{{ route('operasional.project') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection