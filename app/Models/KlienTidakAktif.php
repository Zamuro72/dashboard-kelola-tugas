<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlienTidakAktif extends Model
{
    use HasFactory;

    protected $table = 'klien_tidak_aktifs';

    protected $fillable = [
        'user_id',
        'tahun',
        'nama_klien',
        'nama_perusahaan',
        'bidang_usaha',
        'kota',
        'email',
        'no_whatsapp',
        'produk_minat',
        'pic_sales',
        'status',
        'harga',
        'terakhir_blasting_wa',
        'terakhir_blasting_email',
    ];

    protected $casts = [
        'terakhir_blasting_wa' => 'datetime',
        'terakhir_blasting_email' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
