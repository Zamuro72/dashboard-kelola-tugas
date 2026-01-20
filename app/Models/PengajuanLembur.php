<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLembur extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_lemburs';

    protected $fillable = [
        'user_id',
        'departemen',
        'tanggal_pelaksanaan',
        'hari',
        'jam_kerja_mulai',
        'jam_kerja_selesai',
        'jam_lembur_mulai',
        'jam_lembur_selesai',
        'total_jam_lembur',
        'lokasi',
        'uraian_pekerjaan',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
