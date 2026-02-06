@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-th-large mr-2"></i>
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

   @if(in_array(auth()->user()->jabatan, ['Admin', 'Marketing']))
   <!-- Klien Status Widgets -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ route('klien.status', 'aktif') }}" style="text-decoration: none;">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Klien Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKlienAktif }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ route('klien.status', 'expired') }}" style="text-decoration: none;">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Klien Expired</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKlienExpired }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ route('klien.status', 'proses') }}" style="text-decoration: none;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Proses Terbit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKlienProses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
   @endif

    




    @if(in_array(auth()->user()->jabatan, ['Admin', 'Marketing']))
    <!-- Chart Section -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Klien Aktif</h6>
                <div class="d-flex align-items-center">
                    <select id="yearFilter" class="form-control form-control-sm mr-2" style="width: auto;">
                        <!-- Options populated by JS -->
                    </select>
                    <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="periodOptions" id="optionMonthly" autocomplete="off" checked value="monthly"> Bulanan
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="periodOptions" id="optionWeekly" autocomplete="off" value="weekly"> Mingguan
                        </label>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div id="jasaChart"></div>
            </div>
        </div>
    </div>

    <!-- Pie Chart Section -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                 <h6 class="m-0 font-weight-bold text-primary">Distribusi Klien Aktif per Jasa</h6>
                 <div class="dropdown no-arrow">
                    <select id="pieYearFilter" class="form-control form-control-sm">
                        <option value="all">Semua Tahun</option>
                    </select>
                 </div>
            </div>
            <div class="card-body">
                <div id="jasaPieChart"></div>
            </div>
        </div>
    </div>

    <!-- Details Section (Hidden by default) -->
    <div class="col-xl-12 col-lg-12" id="detailsCard" style="display: none;">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary" id="detailsTitle">Detail Data</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="detailsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Klien/Perusahaan</th>
                                <th>Tipe</th>
                                <th>Pemilik Data</th>
                                <th>Tanggal Terbit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif


</div>

@push('scripts')
<script>
    $(document).ready(function() {
        var chart;
        var currentYear = new Date().getFullYear();
        var currentPeriod = 'monthly';

        // Initialize Chart
        function initChart(data) {
            var options = {
                series: data.series,
                chart: {
                    type: 'bar',
                    height: 400,
                    events: {
                        dataPointSelection: function(event, chartContext, config) {
                            var dataPointIndex = config.dataPointIndex;
                            var seriesIndex = config.seriesIndex;
                            var jasaName = config.w.config.series[seriesIndex].name;
                            
                            fetchDetails(currentYear, currentPeriod, jasaName, dataPointIndex);
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: data.xaxis.categories,
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Klien'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " klien"
                        }
                    }
                },
                colors: data.colors
            };

            if(chart) {
                chart.destroy();
            }

            chart = new ApexCharts(document.querySelector("#jasaChart"), options);
            chart.render();
        }

        // Fetch Chart Data
        function loadChartData(year, period) {
            $.ajax({
                url: "{{ route('dashboard.chartData') }}",
                type: "GET",
                data: { year: year, period: period },
                success: function(response) {
                    // Populate Year Filter if empty
                    if ($('#yearFilter option').length === 0) {
                        response.years.forEach(function(y) {
                            $('#yearFilter').append(new Option(y, y));
                        });
                        // Set current year
                        $('#yearFilter').val(year);
                    }

                    initChart(response);
                },
                error: function(xhr) {
                    console.error("Error fetching chart data", xhr);
                }
            });
        }

        // Fetch Details
        function fetchDetails(year, period, jasaName, index) {
            // Show loading or scroll to details
            $('#detailsCard').show();
            $('#detailsTitle').text('Detail Data: ' + jasaName + ' (' + (period === 'monthly' ? 'Bulan ke-' + (index+1) : 'Minggu ke-' + (index+1)) + ')');
            
            $('html, body').animate({
                scrollTop: $("#detailsCard").offset().top
            }, 500);

            $('#detailsTable tbody').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

            $.ajax({
                url: "{{ route('dashboard.chartDetails') }}",
                type: "GET",
                data: { 
                    year: year, 
                    period: period, 
                    jasa: jasaName, 
                    index: index 
                },
                success: function(response) {
                    var rows = '';
                    if(response.length > 0) {
                        response.forEach(function(item) {
                            rows += '<tr>';
                            rows += '<td>' + item.nama_klien + '</td>';
                            rows += '<td>' + item.tipe_klien + '</td>';
                            rows += '<td>' + item.pemilik_data + '</td>';
                            rows += '<td>' + item.sertifikat_terbit + '</td>';
                            rows += '</tr>';
                        });
                    } else {
                        rows = '<tr><td colspan="4" class="text-center">Tidak ada data detail</td></tr>';
                    }
                    $('#detailsTable tbody').html(rows);
                },
                error: function(xhr) {
                    $('#detailsTable tbody').html('<tr><td colspan="4" class="text-center text-danger">Gagal memuat data</td></tr>');
                }
            });
        }

        // Event Listeners
        $('#yearFilter').change(function() {
            currentYear = $(this).val();
            loadChartData(currentYear, currentPeriod);
        });

        $('input[name="periodOptions"]').change(function() {
            currentPeriod = $(this).val();
            loadChartData(currentYear, currentPeriod);
        });

        // Pie Chart
        function loadPieChart(year = 'all') {
             $.ajax({
                url: "{{ route('dashboard.pieChartData') }}",
                type: "GET",
                data: { year: year },
                success: function(response) {
                    // Populate Year Filter if empty (only has default)
                    var $filter = $('#pieYearFilter');
                    if ($filter.children('option').length <= 1 && response.years) {
                        response.years.forEach(function(y) {
                            $filter.append('<option value="' + y + '">' + y + '</option>');
                        });
                        // Set selected value back to year if needed, though default is 'all'
                        $filter.val(year);
                    }

                    // Calculate total
                    var total = response.series.reduce((a, b) => a + b, 0);

                    // If total is 0, show message
                    if (total === 0) {
                        $('#jasaPieChart').html('<div class="text-center p-3">Tidak ada data aktif</div>');
                        return;
                    }

                    var options = {
                        series: response.series,
                        chart: {
                            type: 'donut',
                            height: 350
                        },
                        labels: response.labels,
                        colors: response.colors,
                        legend: {
                            position: 'right'
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };
                    
                    // Clear previous chart if any
                    document.querySelector("#jasaPieChart").innerHTML = "";
                    var chart = new ApexCharts(document.querySelector("#jasaPieChart"), options);
                    chart.render();
                },
                error: function(xhr) {
                    console.error('Error loading pie chart data', xhr);
                    $('#jasaPieChart').html('<div class="text-center text-danger p-3">Gagal memuat data chart</div>');
                }
            });
        }

        // Pie Chart Filter Change
        $('#pieYearFilter').change(function() {
            var selectedYear = $(this).val();
            loadPieChart(selectedYear);
        });

        // Initial Load
        loadChartData(currentYear, currentPeriod);
        loadPieChart('all');
    });
</script>
@endpush
@endsection

