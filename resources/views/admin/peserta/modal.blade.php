<!-- Modal Show -->
<div class="modal fade" id="modalShow{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail Peserta</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Tahun</div>
                    <div class="col-md-8">: {{ $item->tahun }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Nama</div>
                    <div class="col-md-8">: {{ $item->nama }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Nama Perusahaan</div>
                    <div class="col-md-8">: {{ $item->nama_perusahaan }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Email</div>
                    <div class="col-md-8">: {{ $item->email ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">No WhatsApp</div>
                    <div class="col-md-8">
                        : <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_whatsapp) }}" 
                             target="_blank" class="btn btn-sm btn-success">
                            <i class="fab fa-whatsapp"></i> {{ $item->no_whatsapp }}
                        </a>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Tanggal Lahir</div>
                    <div class="col-md-8">: {{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d F Y') : '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Skema</div>
                    <div class="col-md-8">: {{ $item->skema }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Tanggal Sertifikat Diterima</div>
                    <div class="col-md-8">: {{ $item->tanggal_sertifikat_diterima ? $item->tanggal_sertifikat_diterima->format('d F Y') : '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Tanggal Expired</div>
                    <div class="col-md-8">
                        : {{ $item->tanggal_expired ? $item->tanggal_expired->format('d F Y') : '-' }}
                        <br><small class="text-muted">({{ $item->getSisaHariExpired() }})</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Status Sertifikat</div>
                    <div class="col-md-8">: {!! $item->getStatusSertifikatBadge() !!}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 font-weight-bold">Status Pembayaran</div>
                    <div class="col-md-8">
                        : @if($item->suka_telat_bayar)
                            <span class="badge badge-danger">Suka Telat Bayar</span>
                          @else
                            <span class="badge badge-success">Lancar</span>
                          @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus Data Peserta?</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data peserta berikut?</p>
                <div class="row mb-2">
                    <div class="col-4 font-weight-bold">Nama</div>
                    <div class="col-8">: {{ $item->nama }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 font-weight-bold">Perusahaan</div>
                    <div class="col-8">: {{ $item->nama_perusahaan }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 font-weight-bold">Tahun</div>
                    <div class="col-8">: {{ $item->tahun }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <form action="{{ route('pesertaDestroy', $item->id) }}" method="post" class="d-inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>