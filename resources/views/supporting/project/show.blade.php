@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-eye mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-info d-flex justify-content-between align-items-center">
        <a href="{{ route('supporting.project') }}" class="btn btn-sm btn-success">
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
        <div class="card mb-4 border-success">
            <div class="card-header bg-success text-white">
                <i class="fas fa-check-circle mr-2"></i>
                Berkas dari Supporting
                @if(!$project->operasional_notified)
                    <span class="badge badge-warning ml-2">Baru!</span>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    @if($project->surat_tugas_file)
                    <tr>
                        <td width="200"><strong>Surat Tugas</strong></td>
                        <td width="20">:</td>
                        <td>
                            <a href="{{ route('operasional.project.download', [$project->id, 'surat_tugas']) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download Surat Tugas
                            </a>
                            <a href="{{ asset('storage/' . $project->surat_tugas_file) }}" target="_blank" class="btn btn-sm btn-info ml-2">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @endif
                    @if($project->invoice_file)
                    <tr>
                        <td><strong>Invoice</strong></td>
                        <td>:</td>
                        <td>
                            <a href="{{ route('operasional.project.download', [$project->id, 'invoice']) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download Invoice
                            </a>
                            <a href="{{ asset('storage/' . $project->invoice_file) }}" target="_blank" class="btn btn-sm btn-info ml-2">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @endif
                    @if($project->jadwal_meeting_tanggal)
                    <tr>
                        <td><strong>Jadwal Meeting</strong></td>
                        <td>:</td>
                        <td>
                            <span class="badge badge-primary badge-lg">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ $project->jadwal_meeting_tanggal->format('d F Y') }} 
                                pukul {{ \Carbon\Carbon::parse($project->jadwal_meeting_waktu)->format('H:i') }}
                            </span>
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
                
                <div class="alert alert-info mt-3 mb-0">
                    <i class="fas fa-info-circle mr-2"></i>
                    Berkas sudah dilengkapi oleh Supporting pada: {{ $project->supporting_submitted_at->format('d F Y, H:i') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection