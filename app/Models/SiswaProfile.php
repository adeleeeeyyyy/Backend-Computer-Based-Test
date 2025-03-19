<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaProfile extends Model
{
    protected $fillable = [
        "user_id",
        "nis",
        "kelas",
        "jurusan",
    ];


}
