<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanPeserta extends Model
{
    protected $fillable = [
        "jawaban",
        "siswa_id",
        "tes_id",
        "soal_id",
    ];
}
