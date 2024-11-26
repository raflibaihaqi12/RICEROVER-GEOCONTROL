<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory;

    protected $table = 'lahans';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function alokasi_pupuk()
    {
        return $this->hasMany(AlokasiPupuk::class, 'lahan_id', 'id');
    }
}
