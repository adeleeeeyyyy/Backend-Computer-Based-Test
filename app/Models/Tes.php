<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    protected $fillable = [
        "kode_tes","guru_id","judul","deskripsi","durasi_menit","tanggal_mulai","tanggal_selesai","batas_percobaan","status","password_tes","kategori",
    ];
}
