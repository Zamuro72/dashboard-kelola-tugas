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
    <div class="card-header bg-primary text-white">
        <h6 class="m-0 font-weight-bold">Daftar Project dari Operasional</h6>
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
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $project->marketingUser->nama }}</td>
                        <td>{{ $project->skema }}</td>
                        <td>{{ $project->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $project->timeline }}</td>
                        <td>
                            @if($project->status == 'waiting_supporting')
                                <span class="badge badge-warning">Perlu Dilengkapi</span>
                            @elseif($project->status == 'completed')
                                <span class="badge badge-success">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('supporting.project.show', $project->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($project->status == 'waiting_supporting')
                            <a href="{{ route('supporting.project.edit', $project->id) }}" class="btn btn-sm btn-warning" title="Lengkapi">
                                <i class="fas fa-edit"></i> Lengkapi
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