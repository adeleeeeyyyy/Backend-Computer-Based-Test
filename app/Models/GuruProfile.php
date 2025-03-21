<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nig',
        'mata_pelajaran',
    ];

    public function user() {
        return $this->belongsTo(User::class,"user_id");
    }
}
