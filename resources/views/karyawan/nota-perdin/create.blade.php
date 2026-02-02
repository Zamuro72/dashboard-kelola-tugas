@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-file-invoice mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header bg-primary">
        <a href="{{ route('notaPerdin') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('notaPerdinStore') }}" method="post" id="formNota">
            @csrf

            <!-- Data Karyawan -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-user mr-2"></i>
                    Yang Melakukan Perjalanan Dinas
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label><strong>Nama:</strong></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label><strong>Jabatan:</strong></label>
                            <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $user->jabatan) }}" required>
                            @error('jabatan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label><strong>Unit Kerja / Golongan:</strong></label>
                            <input type="text" name="unit_kerja" class="form-control @error('unit_kerja') is-invalid @enderror" value="{{ old('unit_kerja') }}" required>
                            @error('unit_kerja')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label><strong>Berangkat Tgl:</strong></label>
                            <input type="date" name="tanggal_berangkat" class="form-control @error('tanggal_berangkat') is-invalid @enderror" value="{{ old('tanggal_berangkat') }}" required>
                            @error('tanggal_berangkat')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label><strong>Jam:</strong></label>
                            <input type="time" name="jam_berangkat" class="form-control @error('jam_berangkat') is-invalid @enderror" value="{{ old('jam_berangkat') }}" required>
                            @error('jam_berangkat')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label><strong>Kembali Tgl:</strong></label>
                            <input type="date" name="tanggal_kembali" class="form-control @error('tanggal_kembali') is-invalid @enderror" value="{{ old('tanggal_kembali') }}" required>
                            @error('tanggal_kembali')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label><strong>Jam:</strong></label>
                            <input type="time" name="jam_kembali" class="form-control @error('jam_kembali') is-invalid @enderror" value="{{ old('jam_kembali') }}" required>
                            @error('jam_kembali')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <label><strong>Tujuan / Keperluan:</strong></label>
                            <textarea name="tujuan_keperluan" rows="2" class="form-control @error('tujuan_keperluan') is-invalid @enderror" required>{{ old('tujuan_keperluan') }}</textarea>
                            @error('tujuan_keperluan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Detail Biaya -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white d-flex justify-content-between">
                    <span><i class="fas fa-table mr-2"></i>Detail Biaya</span>
                    <button type="button" class="btn btn-sm btn-success" onclick="addRow()">
                        <i class="fas fa-plus"></i> Tambah Baris
                    </button>
                </div>
                <div class="card-body" style="overflow-x: auto;">
                    <table class="table table-bordered" id="tableDetail">
                        <thead class="thead-light">
                            <tr>
                                <th width="30">No</th>
                                <th width="100">Tanggal</th>
                                <th width="150">Keterangan</th>
                                <th width="120">Taxi/Bensin/Tol</th>
                                <th width="120">Pesawat/KA/Bus</th>
                                <th width="100">Hotel</th>
                                <th width="100">Makan</th>
                                <th width="100">Lain-lain</th>
                                <th width="120">Jumlah</th>
                                <th width="50">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <!-- Baris akan ditambahkan dengan JavaScript -->
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <td colspan="8" class="text-right"><strong>Sub Total Biaya:</strong></td>
                                <td>
                                    <input type="text" id="sub_total_biaya_display" class="form-control" readonly value="Rp 0">
                                    <input type="hidden" name="sub_total_biaya" id="sub_total_biaya" value="0">
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Perhitungan -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-calculator mr-2"></i>
                    Perhitungan
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="250"><strong>KM Kendaraan:</strong></td>
                            <td width="150">
                                <input type="number" name="km_kendaraan" id="km_kendaraan" class="form-control" value="0" min="0" onchange="hitungTotal()">
                            </td>
                            <td width="50" class="text-center">x Rp.</td>
                            <td width="200">
                                <input type="text" id="km_tarif_display" class="form-control" value="0" onkeyup="formatKmTarif(this)">
                                <input type="hidden" name="km_tarif" id="km_tarif" value="0">
                            </td>
                            <td width="50" class="text-center">=</td>
                            <td>
                                <input type="text" id="km_x_rp_display" class="form-control" readonly value="Rp 0">
                                <input type="hidden" name="km_x_rp" id="km_x_rp" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Uang Saku/Tunjangan Lainnya:</strong></td>
                            <td>
                                <input type="number" name="uang_saku_hari" id="uang_saku_hari" class="form-control" value="0" min="0" onchange="hitungTotal()">
                            </td>
                            <td class="text-center">Hari x Rp.</td>
                            <td>
                                <input type="text" id="hari_tarif_display" class="form-control" value="0" onkeyup="formatHariTarif(this)">
                                <input type="hidden" name="hari_tarif" id="hari_tarif" value="0">
                            </td>
                            <td class="text-center">=</td>
                            <td>
                                <input type="text" id="hari_x_rp_display" class="form-control" readonly value="Rp 0">
                                <input type="hidden" name="hari_x_rp" id="hari_x_rp" value="0">
                            </td>
                        </tr>
                        <tr class="table-info">
                            <td colspan="5" class="text-right"><strong>Sub Total:</strong></td>
                            <td>
                                <input type="text" id="sub_total_display" class="form-control font-weight-bold" readonly value="Rp 0">
                                <input type="hidden" name="sub_total" id="sub_total" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Potongan Uang Muka:</strong></td>
                            <td>
                                <input type="text" id="potongan_display" class="form-control" value="0" onkeyup="formatPotongan(this)">
                                <input type="hidden" name="potongan_uang_muka" id="potongan_uang_muka" value="0">
                            </td>
                        </tr>
                        <tr class="table-success">
                            <td colspan="5" class="text-right"><strong>TOTAL:</strong></td>
                            <td>
                                <input type="text" id="total_display" class="form-control font-weight-bold text-success" readonly value="Rp 0">
                                <input type="hidden" name="total" id="total" value="0">
                            </td>
                        </tr>
                    </table>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label><strong>Lokasi Pengajuan:</strong></label>
                            <input type="text" name="lokasi_pengajuan" class="form-control" value="Jakarta">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Nota
                </button>
                <a href="{{ route('notaPerdin') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let rowNumber = 0;

// Format rupiah
function formatRupiah(angka) {
    return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
}

// Parse rupiah ke angka
function parseRupiah(str) {
    return parseInt(str.replace(/[^0-9]/g, '')) || 0;
}

// Tambah baris baru
function addRow() {
    rowNumber++;
    const tbody = document.getElementById('tbody');
    const tr = document.createElement('tr');
    tr.id = 'row_' + rowNumber;
    tr.innerHTML = `
        <td class="text-center">${rowNumber}</td>
        <td><input type="date" name="detail_tanggal[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="detail_keterangan[]" class="form-control form-control-sm"></td>
        <td><input type="text" class="form-control form-control-sm uang" onkeyup="formatUang(this)" onchange="hitungBaris(${rowNumber})"></td>
        <td><input type="text" class="form-control form-control-sm uang" onkeyup="formatUang(this)" onchange="hitungBaris(${rowNumber})"></td>
        <td><input type="text" class="form-control form-control-sm uang" onkeyup="formatUang(this)" onchange="hitungBaris(${rowNumber})"></td>
        <td><input type="text" class="form-control form-control-sm uang" onkeyup="formatUang(this)" onchange="hitungBaris(${rowNumber})"></td>
        <td><input type="text" class="form-control form-control-sm uang" onkeyup="formatUang(this)" onchange="hitungBaris(${rowNumber})"></td>
        <td><input type="text" class="form-control form-control-sm" readonly value="0"></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(${rowNumber})">
                <i class="fas fa-trash"></i>
            </button>
        </td>
        <input type="hidden" name="detail_taxi[]" value="0">
        <input type="hidden" name="detail_pesawat[]" value="0">
        <input type="hidden" name="detail_hotel[]" value="0">
        <input type="hidden" name="detail_makan[]" value="0">
        <input type="hidden" name="detail_lain[]" value="0">
        <input type="hidden" name="detail_jumlah[]" value="0">
    `;
    tbody.appendChild(tr);
}

// Hapus baris
function removeRow(num) {
    document.getElementById('row_' + num).remove();
    hitungSubTotal();
}

// Format input uang
function formatUang(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    input.value = parseInt(value || 0).toLocaleString('id-ID');
}

// Hitung jumlah per baris
function hitungBaris(num) {
    const row = document.getElementById('row_' + num);
    const inputs = row.querySelectorAll('.uang');
    const hiddenInputs = row.querySelectorAll('input[type="hidden"]');
    
    let total = 0;
    inputs.forEach((input, index) => {
        const value = parseRupiah(input.value);
        hiddenInputs[index].value = value;
        total += value;
    });
    
    hiddenInputs[5].value = total; // detail_jumlah
    row.querySelector('td:nth-child(9) input').value = total.toLocaleString('id-ID');
    
    hitungSubTotal();
}

// Hitung sub total biaya
function hitungSubTotal() {
    let subTotal = 0;
    document.querySelectorAll('input[name="detail_jumlah[]"]').forEach(input => {
        subTotal += parseInt(input.value || 0);
    });
    
    document.getElementById('sub_total_biaya').value = subTotal;
    document.getElementById('sub_total_biaya_display').value = formatRupiah(subTotal);
    
    hitungTotal();
}

// Format KM Tarif
function formatKmTarif(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    input.value = parseInt(value || 0).toLocaleString('id-ID');
    document.getElementById('km_tarif').value = parseInt(value || 0);
    hitungTotal();
}

// Format Hari Tarif
function formatHariTarif(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    input.value = parseInt(value || 0).toLocaleString('id-ID');
    document.getElementById('hari_tarif').value = parseInt(value || 0);
    hitungTotal();
}

// Format Potongan
function formatPotongan(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    input.value = parseInt(value || 0).toLocaleString('id-ID');
    document.getElementById('potongan_uang_muka').value = parseInt(value || 0);
    hitungTotal();
}

// Hitung total keseluruhan
function hitungTotal() {
    const subTotalBiaya = parseInt(document.getElementById('sub_total_biaya').value || 0);
    const kmKendaraan = parseInt(document.getElementById('km_kendaraan').value || 0);
    const kmTarif = parseInt(document.getElementById('km_tarif').value || 0);
    const kmXRp = kmKendaraan * kmTarif;
    
    const uangSakuHari = parseInt(document.getElementById('uang_saku_hari').value || 0);
    const hariTarif = parseInt(document.getElementById('hari_tarif').value || 0);
    const hariXRp = uangSakuHari * hariTarif;
    
    const subTotal = subTotalBiaya + kmXRp + hariXRp;
    const potongan = parseInt(document.getElementById('potongan_uang_muka').value || 0);
    const total = subTotal - potongan;
    
    document.getElementById('km_x_rp').value = kmXRp;
    document.getElementById('km_x_rp_display').value = formatRupiah(kmXRp);
    
    document.getElementById('hari_x_rp').value = hariXRp;
    document.getElementById('hari_x_rp_display').value = formatRupiah(hariXRp);
    
    document.getElementById('sub_total').value = subTotal;
    document.getElementById('sub_total_display').value = formatRupiah(subTotal);
    
    document.getElementById('total').value = total;
    document.getElementById('total_display').value = formatRupiah(total);
}

// Tambah 1 baris saat load
window.onload = function() {
    addRow();
};
</script>

@endsection