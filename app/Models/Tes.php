<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    protected $fillable = [
        "kode_tes","guru_id","judul","deskripsi","jam_mulai","durasi_menit","tanggal_mulai","tanggal_selesai","batas_percobaan","status","password_tes", "mapel","jenis_ujian", "semester", "kelas","tes_id",
    ];

    protected $casts = [
        'kelas' => 'array',
    ];

    public function soal() {
        return $this->hasMany(Soal::class, 'tes_id', 'tes_id'); 
    }
}
