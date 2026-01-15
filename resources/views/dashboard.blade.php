@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-tachometer-alt mr-2"></i>
    {{ $title }}
</h1>

<div class="row">

    @if (auth()->user()->jabatan == 'Admin')
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total User</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahUser }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                        Total Admin</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahAdmin }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                        Total Karyawan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKaryawan }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                        Total Karyawan Bertugas</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahDitugaskan }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-check fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Peserta</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPeserta }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Total Peserta BNSP</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPesertaBNSP }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Total Peserta Kemnaker RI</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPesertaKemnaker }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

   @endif

   @if (auth()->user()->jabatan == 'Karyawan'&& auth()->user()->is_tugas == true)
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Status</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <span class="badge badge-success">
                            Ditugaskan
                        </span>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-check fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>       
   @endif

    @if (auth()->user()->jabatan == 'Karyawan'&& auth()->user()->is_tugas == false)
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Status</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <span class="badge badge-danger">
                            Belum Ditugaskan
                        </span>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-times fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>       
   @endif

    


</div>
@endsection

