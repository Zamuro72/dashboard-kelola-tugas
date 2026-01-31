<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketing_user_id',
        'skema',
        'tanggal',
        'timeline',
        'need_surat_tugas',
        'need_invoice',
        'need_jadwal_meeting',
        'catatan_operasional',
        'operasional_submitted_at',
        'surat_tugas_file',
        'invoice_file',
        'jadwal_meeting_tanggal',
        'jadwal_meeting_waktu',
        'catatan_supporting',
        'supporting_submitted_at',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jadwal_meeting_tanggal' => 'date',
        'need_surat_tugas' => 'boolean',
        'need_invoice' => 'boolean',
        'need_jadwal_meeting' => 'boolean',
        'operasional_submitted_at' => 'datetime',
        'supporting_submitted_at' => 'datetime',
    ];

    public function marketingUser()
    {
        return $this->belongsTo(User::class, 'marketing_user_id');
    }
}