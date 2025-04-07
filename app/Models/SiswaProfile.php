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

    public function user() {
        return $this->belongsTo(User::class,"siswa_profile_id");
    }

    
    public function sesiTes()
    {
        return $this->hasMany(SesiTes::class, 'siswa_id');
    }
}
