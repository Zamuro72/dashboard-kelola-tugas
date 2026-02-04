<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jasa extends Model
{
    use HasFactory;

    protected $table = 'jasa';

    protected $fillable = [
        'nama_jasa',
        'has_skema',
        'masa_berlaku_tahun',
    ];

    protected $casts = [
        'has_skema' => 'boolean',
        'masa_berlaku_tahun' => 'integer',
    ];

    public function skema()
    {
        return $this->hasMany(Skema::class);
    }

    public function kliens()
    {
        return $this->hasMany(Klien::class);
    }
}