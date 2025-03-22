<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PilihanJawaban extends Model
{
    protected $fillable = [
        "soal_id",
        "teks_pilihan",
        "is_benar",
        "jawaban_id",
    ];
}
