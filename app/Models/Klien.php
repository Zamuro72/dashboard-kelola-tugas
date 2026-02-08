<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'kliens';

    protected $fillable = [
        'user_id',
        'jasa_id',
        'skema_id',
        'tahun',
        'tipe_klien',
        'nama_klien',
        'nama_perusahaan',
        'nama_penanggung_jawab',
        'email',
        'no_whatsapp',
        'sertifikat_terbit',
        'tanggal_lahir',
    ];

    protected $casts = [
        'sertifikat_terbit' => 'date',
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class);
    }

    /**
     * Get tanggal expired sertifikat berdasarkan masa berlaku jasa
     */
    public function getTanggalExpiredAttribute()
    {
        if (!$this->sertifikat_terbit || !$this->jasa) {
            return null;
        }

        $masaBerlaku = $this->jasa->masa_berlaku_tahun;
        return Carbon::parse($this->sertifikat_terbit)->addYears($masaBerlaku);
    }

    /**
     * Cek apakah sertifikat sudah expired
     */
    public function isSertifikatExpired()
    {
        if (!$this->sertifikat_terbit) {
            return false;
        }

        return Carbon::now()->greaterThan($this->tanggal_expired);
    }

    /**
     * Cek apakah sertifikat akan expired dalam 3 bulan
     */
    public function isSertifikatAkanExpired()
    {
        if (!$this->sertifikat_terbit) {
            return false;
        }

        $tigaBulanKedepan = Carbon::now()->addMonths(3);

        return !$this->isSertifikatExpired() &&
            Carbon::now()->lessThan($this->tanggal_expired) &&
            $tigaBulanKedepan->greaterThanOrEqualTo($this->tanggal_expired);
    }

    /**
     * Get status sertifikat dengan badge
     */
    public function getStatusSertifikatBadge()
    {
        if (!$this->sertifikat_terbit) {
            return '<span class="badge badge-info">Proses Terbit</span>';
        }

        if ($this->isSertifikatExpired()) {
            return '<span class="badge badge-danger">Sudah Expired</span>';
        } elseif ($this->isSertifikatAkanExpired()) {
            return '<span class="badge badge-warning">Akan Expired</span>';
        } else {
            return '<span class="badge badge-success">Aktif</span>';
        }
    }

    /**
     * Get sisa hari sampai expired
     */
    public function getSisaHariExpired()
    {
        if (!$this->sertifikat_terbit) {
            return null;
        }

        $now = Carbon::now();
        $expired = $this->tanggal_expired;

        if ($now->greaterThan($expired)) {
            return 'Sudah expired sejak ' . (int)$now->diffInDays($expired) . ' hari yang lalu';
        }

        return (int)$now->diffInDays($expired) . ' hari lagi';
    }

    /**
     * Scope untuk klien yang sertifikatnya akan expired (3 bulan sebelum)
     */
    public function scopeAkanExpired($query)
    {
        $tigaBulanKedepan = Carbon::now()->addMonths(3);
        $sekarang = Carbon::now();

        // Join dengan tabel jasa untuk mendapatkan masa_berlaku_tahun
        return $query->join('jasa', 'kliens.jasa_id', '=', 'jasa.id')
            ->whereRaw(
                'DATE_ADD(kliens.sertifikat_terbit, INTERVAL jasa.masa_berlaku_tahun YEAR) BETWEEN ? AND ?',
                [$sekarang, $tigaBulanKedepan]
            )
            ->select('kliens.*'); // Pastikan hanya select kolom dari kliens
    }

    /**
     * Scope untuk klien yang sertifikatnya sudah expired
     */
    public function scopeSudahExpired($query)
    {
        $sekarang = Carbon::now();

        // Join dengan tabel jasa untuk mendapatkan masa_berlaku_tahun
        return $query->join('jasa', 'kliens.jasa_id', '=', 'jasa.id')
            ->whereRaw(
                'DATE_ADD(kliens.sertifikat_terbit, INTERVAL jasa.masa_berlaku_tahun YEAR) < ?',
                [$sekarang]
            )
            ->select('kliens.*');
    }

    /**
     * Scope untuk klien dengan status Proses Terbit
     */
    public function scopeProsesTerbit($query)
    {
        return $query->whereNull('sertifikat_terbit');
    }

    /**
     * Scope untuk klien dengan status Aktif
     */
    public function scopeAktif($query)
    {
        $sekarang = Carbon::now();

        return $query->whereNotNull('sertifikat_terbit')
            ->join('jasa', 'kliens.jasa_id', '=', 'jasa.id')
            ->whereRaw(
                'DATE_ADD(kliens.sertifikat_terbit, INTERVAL jasa.masa_berlaku_tahun YEAR) >= ?',
                [$sekarang]
            )
            ->select('kliens.*');
    }

    /**
     * Scope untuk filter berdasarkan tahun
     */
    public function scopeTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }
}
