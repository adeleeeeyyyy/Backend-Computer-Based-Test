<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $fillable = [ 
        'soal_id', 
        'tes_id', 
        'jenis_soal', 
        'pertanyaan', 
        'file_gambar', 
        'poin'
    ];
}
