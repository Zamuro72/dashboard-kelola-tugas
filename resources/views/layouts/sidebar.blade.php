<!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('welcome') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Manajemen Kandel </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{$menuDashboard ?? ''}}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-th-large"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            @if (auth()->user()->jabatan=='Admin')
             <!-- Heading -->
            <div class="sidebar-heading">
                Menu Admin
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item {{$menuAdminUser ?? ''}}">
                <a class="nav-link" href="{{ route('user') }}">
                    <i class="fas fa-user"></i>
                    <span>Data User</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item {{$menuAdminTugas ?? ''}}">
                <a class="nav-link" href="{{ route('tugas') }}">
                    <i class="fas fa-tasks"></i>
                    <span>Data Tugas</span></a>
            </li>

            <!-- Nav Item - Peserta -->
            <li class="nav-item {{$menuAdminPeserta ?? ''}}">
                <a class="nav-link" href="{{ route('peserta') }}">
                    <i class="fas fa-users"></i>
                    <span>Data Peserta</span>
                </a>
            </li>

            <!-- Nav Item - Data Lembur (Admin) -->
            <li class="nav-item {{$menuAdminLembur ?? ''}}">
                <a class="nav-link" href="{{ route('adminLembur') }}">
                    <i class="fas fa-clock"></i>
                    <span>Data Lembur</span>
                </a>
            </li>

            <!-- Nav Item - Data Perjalanan Dinas (Admin) -->
            <li class="nav-item {{$menuAdminPerdin ?? ''}}">
                <a class="nav-link" href="{{ route('adminPerdin') }}">
                    <i class="fas fa-road"></i>
                    <span>Data Perjalanan Dinas</span>
                </a>
            </li>
              
            @else
             <!-- Heading -->
            <div class="sidebar-heading">
                Menu {{ auth()->user()->jabatan }}
            </div>

            @if (auth()->user()->jabatan == 'Supporting')
            <!-- Nav Item - Data Lembur (Supporting View) -->
            <li class="nav-item {{$menuAdminLembur ?? ''}}">
                <a class="nav-link" href="{{ route('adminLembur') }}">
                    <i class="fas fa-clock"></i>
                    <span>Review Lembur</span>
                </a>
            </li>

            <!-- Nav Item - Data Perjalanan Dinas (Supporting View) -->
            <li class="nav-item {{$menuAdminPerdin ?? ''}}">
                <a class="nav-link" href="{{ route('adminPerdin') }}">
                    <i class="fas fa-road"></i>
                    <span>Review Perdin</span>
                </a>
            </li>
            @endif


            <!-- Nav Item - Tables -->
            <li class="nav-item {{$menuKaryawanTugas ?? ''}}">
                <a class="nav-link" href="{{ route('tugas') }}">
                    <i class="fas fa-tasks"></i>
                    <span>Data Tugas</span></a>
            </li>

            <!-- Nav Item - Pengajuan Lembur -->
            <li class="nav-item {{$menuKaryawanLembur ?? ''}}">
                <a class="nav-link" href="{{ route('lembur') }}">
                    <i class="fas fa-clock"></i>
                    <span>Pengajuan Lembur</span></a>
            </li>

            <!-- Nav Item - Perjalanan Dinas -->
            <li class="nav-item {{$menuKaryawanPerdin ?? ''}}">
                <a class="nav-link" href="{{ route('perdin') }}">
                    <i class="fas fa-road"></i>
                    <span>Perjalanan Dinas</span></a>
            </li>               
            @endif





            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->