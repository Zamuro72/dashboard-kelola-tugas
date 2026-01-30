<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
        'tahun',
        'nama',
        'nama_perusahaan',
        'email',
        'no_whatsapp',
        'tanggal_lahir',
        'skema',
        'tanggal_sertifikat_diterima',
        'suka_telat_bayar',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_sertifikat_diterima' => 'date',
        'suka_telat_bayar' => 'boolean',
    ];

    /**
     * Get tanggal expired sertifikat (3 tahun setelah diterima)
     */
    public function getTanggalExpiredAttribute()
    {
        return $this->tanggal_sertifikat_diterima ?
            Carbon::parse($this->tanggal_sertifikat_diterima)->addYears(3) : null;
    }

    /**
     * Cek apakah sertifikat sudah expired
     */
    public function isSertifikatExpired()
    {
        if (!$this->tanggal_sertifikat_diterima) {
            return false;
        }

        return Carbon::now()->greaterThan($this->tanggal_expired);
    }

    /**
     * Cek apakah sertifikat akan expired dalam 3 bulan
     */
    public function isSertifikatAkanExpired()
    {
        if (!$this->tanggal_sertifikat_diterima) {
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
        if (!$this->tanggal_sertifikat_diterima) {
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
     * Scope untuk filter berdasarkan tahun
     */
    public function scopeTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    /**
     * Scope untuk peserta yang sertifikatnya akan expired
     */
    public function scopeAkanExpired($query)
    {
        $tigaBulanKedepan = Carbon::now()->addMonths(3);
        $sekarang = Carbon::now();

        return $query->whereRaw(
            'DATE_ADD(tanggal_sertifikat_diterima, INTERVAL 3 YEAR) BETWEEN ? AND ?',
            [$sekarang, $tigaBulanKedepan]
        );
    }

    /**
     * Scope untuk peserta yang sertifikatnya sudah expired
     */
    public function scopeSudahExpired($query)
    {
        $sekarang = Carbon::now();

        return $query->whereRaw('DATE_ADD(tanggal_sertifikat_diterima, INTERVAL 3 YEAR) < ?', [$sekarang]);
    }
}
