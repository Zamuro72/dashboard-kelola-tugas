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
        'tipe_klien',
        'tahun',
        'nama_klien',
        'tanggal_lahir',
        'nama_perusahaan',
        'nama_penanggung_jawab',
        'email',
        'no_whatsapp',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
