<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaPerjalananDinas extends Model
{
    use HasFactory;

    protected $table = 'nota_perjalanan_dinas';

    protected $fillable = [
        'user_id',
        'nama',
        'jabatan',
        'unit_kerja',
        'tanggal_berangkat',
        'jam_berangkat',
        'tanggal_kembali',
        'jam_kembali',
        'tujuan_keperluan',
        'detail_biaya',
        'sub_total_biaya',
        'km_kendaraan',
        'km_x_rp',
        'uang_saku_hari',
        'hari_x_rp',
        'sub_total',
        'potongan_uang_muka',
        'total',
        'lokasi_pengajuan',
        'tanggal_pengajuan',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_pengajuan' => 'date',
        'detail_biaya' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}