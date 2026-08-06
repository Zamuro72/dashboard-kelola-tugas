@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-3 mb-sm-0 text-gray-800">{{ $title }}</h1>
        <div>
            @if(request('from') == 'dashboard')
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary shadow-sm mr-1">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            @else
                <a href="{{ route('klien.index') }}" class="btn btn-sm btn-secondary shadow-sm mr-1">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            @endif
            <a href="{{ route('klien-tidak-aktif.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Klien Tidak Aktif</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('klien-tidak-aktif.index') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="belum dihubungi" {{ request('status') == 'belum dihubungi' ? 'selected' : '' }}>Belum Dihubungi</option>
                            <option value="sudah diblasting" {{ request('status') == 'sudah diblasting' ? 'selected' : '' }}>Sudah Diblasting</option>
                            <option value="menunggu respon" {{ request('status') == 'menunggu respon' ? 'selected' : '' }}>Menunggu Respon</option>
                            <option value="ongoing proses deal" {{ request('status') == 'ongoing proses deal' ? 'selected' : '' }}>Ongoing Proses Deal</option>
                            <option value="deal" {{ request('status') == 'deal' ? 'selected' : '' }}>Deal</option>
                            <option value="tidak berminat" {{ request('status') == 'tidak berminat' ? 'selected' : '' }}>Tidak Berminat</option>
                            <option value="belum jelas" {{ request('status') == 'belum jelas' ? 'selected' : '' }}>Belum Jelas</option>
                            <option value="follow up" {{ request('status') == 'follow up' ? 'selected' : '' }}>Follow Up</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama, email, wa..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Nama Klien</th>
                            <th>Perusahaan</th>
                            <th>Bidang Usaha</th>
                            <th>Kota</th>
                            <th>Email</th>
                            <th>WhatsApp</th>
                            <th>Produk Minat</th>
                            <th>PIC Sales</th>
                            <th>Keterangan Blasting</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kliens as $index => $klien)
                            <tr>
                                <td>{{ ($kliens->currentPage() - 1) * $kliens->perPage() + $index + 1 }}</td>
                                <td>{{ $klien->tahun }}</td>
                                <td>{{ $klien->nama_klien ?? '-' }}</td>
                                <td>{{ $klien->nama_perusahaan ?? '-' }}</td>
                                <td>{{ $klien->bidang_usaha ?? '-' }}</td>
                                <td>{{ $klien->kota ?? '-' }}</td>
                                <td>{{ $klien->email ?? '-' }}</td>
                                <td>
                                    @if($klien->no_whatsapp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $klien->no_whatsapp) }}" target="_blank">
                                            {{ $klien->no_whatsapp }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $klien->produk_minat ?? '-' }}</td>
                                <td>{{ $klien->pic_sales ?? '-' }}</td>
                                <td>
                                    @if($klien->terakhir_blasting_wa)
                                        <span class="badge badge-success d-block mb-1">WA: {{ $klien->terakhir_blasting_wa->format('d M Y, H:i') }}</span>
                                    @endif
                                    @if($klien->terakhir_blasting_email)
                                        <span class="badge badge-info d-block">Email: {{ $klien->terakhir_blasting_email->format('d M Y, H:i') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($klien->harga)
                                        Rp. {{ number_format($klien->harga, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ ucwords($klien->status) }}</span>
                                </td>
                                <td>
                                    <!-- Edit Status Button -->
                                    <button type="button" class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#editStatusModal{{ $klien->id }}">
                                        <i class="fas fa-tasks"></i> Edit Status
                                    </button>

                                    <!-- Blasting WA Button -->
                                    <form action="{{ route('klien-tidak-aktif.blastingWa', $klien->id) }}" method="POST" class="d-inline mb-1" target="_blank">
                                        @csrf
                                        <button class="btn btn-sm btn-success" {{ !$klien->no_whatsapp ? 'disabled' : '' }}>
                                            <i class="fab fa-whatsapp"></i> WA
                                        </button>
                                    </form>

                                    <!-- Blasting Email Button -->
                                    <form action="{{ route('klien-tidak-aktif.blastingEmail', $klien->id) }}" method="POST" class="d-inline mb-1">
                                        @csrf
                                        <button class="btn btn-sm btn-info" {{ !$klien->email ? 'disabled' : '' }}>
                                            <i class="fas fa-envelope"></i> Email
                                        </button>
                                    </form>

                                    <!-- Edit & Delete Buttons -->
                                    <a href="{{ route('klien-tidak-aktif.edit', $klien->id) }}" class="btn btn-sm btn-primary mb-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Convert to Aktif Button -->
                                    @if(strtolower($klien->status) == 'deal')
                                    <button type="button" class="btn btn-sm btn-dark mb-1" data-toggle="modal" data-target="#convertToAktifModal{{ $klien->id }}">
                                        <i class="fas fa-check-circle"></i> Jadi Aktif
                                    </button>
                                    @endif
                                    <form action="{{ route('klien-tidak-aktif.destroy', $klien->id) }}" method="POST" class="d-inline mb-1" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Convert to Aktif -->
                            <div class="modal fade" id="convertToAktifModal{{ $klien->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('klien-tidak-aktif.convertToAktif', $klien->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ubah Jadi Klien Aktif</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Jasa <span class="text-danger">*</span></label>
                                                    <select name="jasa_id" class="form-control jasa-select" data-target="#skemaSelect{{ $klien->id }}" required>
                                                        <option value="">-- Pilih Jasa --</option>
                                                        @foreach($jasas as $jasa)
                                                            <option value="{{ $jasa->id }}" data-has-skema="{{ $jasa->has_skema }}">{{ $jasa->nama_jasa }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group skema-group" style="display:none;">
                                                    <label>Skema</label>
                                                    <select name="skema_id" id="skemaSelect{{ $klien->id }}" class="form-control">
                                                        <option value="">-- Pilih Skema --</option>
                                                        @foreach($jasas as $jasa)
                                                            @foreach($jasa->skema as $skema)
                                                                <option value="{{ $skema->id }}" data-jasa-id="{{ $jasa->id }}" style="display:none;">{{ $skema->nama_skema }}</option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Sertifikat Terbit <span class="text-muted">(Opsional)</span></label>
                                                    <input type="date" name="sertifikat_terbit" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan & Aktifkan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Status -->
                            <div class="modal fade" id="editStatusModal{{ $klien->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('klien-tidak-aktif.updateStatus', $klien->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Status Klien</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="belum dihubungi" {{ $klien->status == 'belum dihubungi' ? 'selected' : '' }}>Belum Dihubungi</option>
                                                        <option value="sudah diblasting" {{ $klien->status == 'sudah diblasting' ? 'selected' : '' }}>Sudah Diblasting</option>
                                                        <option value="menunggu respon" {{ $klien->status == 'menunggu respon' ? 'selected' : '' }}>Menunggu Respon</option>
                                                        <option value="ongoing proses deal" {{ $klien->status == 'ongoing proses deal' ? 'selected' : '' }}>Ongoing Proses Deal</option>
                                                        <option value="deal" {{ $klien->status == 'deal' ? 'selected' : '' }}>Deal</option>
                                                        <option value="tidak berminat" {{ $klien->status == 'tidak berminat' ? 'selected' : '' }}>Tidak Berminat</option>
                                                        <option value="belum jelas" {{ $klien->status == 'belum jelas' ? 'selected' : '' }}>Belum Jelas</option>
                                                        <option value="follow up" {{ $klien->status == 'follow up' ? 'selected' : '' }}>Follow Up</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $kliens->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.jasa-select').change(function() {
            var selectedOption = $(this).find('option:selected');
            var targetSkema = $(this).data('target');
            var hasSkema = selectedOption.data('has-skema');
            var jasaId = selectedOption.val();
            
            if (hasSkema == 1) {
                $(this).closest('.modal-body').find('.skema-group').show();
                $(targetSkema).attr('required', true);
                
                // Show only relevant skemas
                $(targetSkema + ' option').hide();
                $(targetSkema + ' option[value=""]').show();
                $(targetSkema + ' option[data-jasa-id="'+jasaId+'"]').show();
                $(targetSkema).val('');
            } else {
                $(this).closest('.modal-body').find('.skema-group').hide();
                $(targetSkema).removeAttr('required');
                $(targetSkema).val('');
            }
        });
    });
</script>
@endpush
@endsection
