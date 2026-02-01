@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-project-diagram mr-2"></i>
    {{ $title }}
    @if($completedUnread > 0)
    <span class="badge badge-danger">{{ $completedUnread }} Baru</span>
    @endif
</h1>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Notifikasi Berkas Baru -->
@if($completedUnread > 0)
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong><i class="fas fa-bell mr-2"></i>Notifikasi!</strong>
    Ada {{ $completedUnread }} project yang sudah dilengkapi oleh Supporting. Silakan cek berkas yang tersedia.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-header bg-primary text-white">
        <h6 class="m-0 font-weight-bold">Daftar Project dari Marketing</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Marketing</th>
                        <th>Skema</th>
                        <th>Tanggal</th>
                        <th>Timeline</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $index => $project)
                    <tr class="{{ $project->status == 'completed' && !$project->operasional_notified ? 'table-success' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $project->marketingUser->nama }}</td>
                        <td>{{ $project->skema }}</td>
                        <td>{{ $project->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $project->timeline }}</td>
                        <td>
                            @if($project->status == 'waiting_operasional')
                                <span class="badge badge-warning">Perlu Dicatat</span>
                            @elseif($project->status == 'waiting_supporting')
                                <span class="badge badge-info">Menunggu Supporting</span>
                            @elseif($project->status == 'completed')
                                <span class="badge badge-success">Selesai</span>
                                @if(!$project->operasional_notified)
                                    <span class="badge badge-danger ml-1">Baru!</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('operasional.project.show', $project->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                                @if($project->status == 'completed' && !$project->operasional_notified)
                                    <span class="badge badge-light ml-1">!</span>
                                @endif
                            </a>
                            <form action="{{ route('operasional.project.destroy', $project->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini? Semua data dan file terkait akan ikut terhapus!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @if($project->status == 'waiting_operasional')
                            <a href="{{ route('operasional.project.edit', $project->id) }}" class="btn btn-sm btn-warning" title="Catat Kebutuhan">
                                <i class="fas fa-edit"></i> Catat
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada project</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection