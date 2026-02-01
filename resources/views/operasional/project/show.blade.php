@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-eye mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-info d-flex justify-content-between align-items-center">
        <a href="{{ route('operasional.project') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
        <span class="badge badge-lg 
            @if($project->status == 'waiting_operasional') badge-warning
            @elseif($project->status == 'waiting_supporting') badge-info
            @else badge-success
            @endif">
            @if($project->status == 'waiting_operasional') Perlu Dicatat
            @elseif($project->status == 'waiting_supporting') Menunggu Supporting
            @else Selesai
            @endif
        </span>
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

        <!-- Kebutuhan yang Sudah Dicatat -->
        @if($project->status != 'waiting_operasional')
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-clipboard-list mr-2"></i>
                Kebutuhan yang Sudah Dicatat
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
                        <td><strong>Catatan</strong></td>
                        <td>:</td>
                        <td>{{ $project->catatan_operasional }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        @endif

        <!-- Hasil dari Supporting -->
        @if($project->status == 'completed')
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-check-circle mr-2"></i>
                Hasil dari Supporting
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    @if($project->surat_tugas_file)
                    <tr>
                        <td width="200"><strong>Surat Tugas</strong></td>
                        <td width="20">:</td>
                        <td>
                            <a href="{{ asset('storage/' . $project->surat_tugas_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </td>
                    </tr>
                    @endif
                    @if($project->invoice_file)
                    <tr>
                        <td><strong>Invoice</strong></td>
                        <td>:</td>
                        <td>
                            <a href="{{ asset('storage/' . $project->invoice_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </td>
                    </tr>
                    @endif
                    @if($project->jadwal_meeting_tanggal)
                    <tr>
                        <td><strong>Jadwal Meeting</strong></td>
                        <td>:</td>
                        <td>
                            {{ $project->jadwal_meeting_tanggal->format('d F Y') }} 
                            pukul {{ \Carbon\Carbon::parse($project->jadwal_meeting_waktu)->format('H:i') }}
                        </td>
                    </tr>
                    @endif
                    @if($project->catatan_supporting)
                    <tr>
                        <td><strong>Catatan Supporting</strong></td>
                        <td>:</td>
                        <td>{{ $project->catatan_supporting }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection