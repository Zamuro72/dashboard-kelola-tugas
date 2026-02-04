<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'skema';

    protected $fillable = [
        'jasa_id',
        'nama_skema',
    ];

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }

    public function kliens()
    {
        return $this->hasMany(Klien::class);
    }
}