<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringAktivitas extends Model
{
    use HasFactory;

    protected $table = 'monitoring_aktivitas';

    protected $fillable = [
        'sesi_id',
        'jenis_aktivitas',
        'waktu',
        'screenshot',
    ];

    public function sesi()
    {
        return $this->belongsTo(SesiTes::class, 'sesi_id');
    }
}
