<?php
// app/Models/SesiTes.php
// app/Models/SesiTes.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiTes extends Model
{
    use HasFactory;

    protected $table = 'sesi_tes';

    protected $fillable = [
        'siswa_id',
        'tes_id',
        'waktu_mulai',
        'waktu_selesai',
        'status',
        'ip_address',
        'browser',
    ];

    public function siswa()
    {
        return $this->belongsTo(SiswaProfile::class, 'siswa_id');
    }

    public function monitoringAktivitas()
    {
        return $this->hasMany(MonitoringAktivitas::class, 'sesi_id');
    }

    public function tes()
    {
        return $this->belongsTo(Tes::class, 'tes_id');
    }
}
