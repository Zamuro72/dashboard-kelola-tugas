@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-project-diagram mr-2"></i>
    {{ $title }}
</h1>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-header bg-primary">
        <a href="{{ route('marketing.project.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus mr-2"></i>
            Buat Project Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Skema</th>
                        <th>Tanggal</th>
                        <th>Timeline</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $index => $project)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $project->skema }}</td>
                        <td>{{ $project->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $project->timeline }}</td>
                        <td>
                            @if($project->status == 'draft')
                                <span class="badge badge-secondary">Draft</span>
                            @elseif($project->status == 'waiting_operasional')
                                <span class="badge badge-warning">Menunggu Operasional</span>
                            @elseif($project->status == 'waiting_supporting')
                                <span class="badge badge-info">Menunggu Supporting</span>
                            @elseif($project->status == 'completed')
                                <span class="badge badge-success">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('marketing.project.show', $project->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('marketing.project.destroy', $project->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @if($project->status == 'draft')
                            <a href="{{ route('marketing.project.edit', $project->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada project</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection