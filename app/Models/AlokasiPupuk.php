<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlokasiPupuk extends Model
{
    use HasFactory;

    protected $table = 'alokasi_pupuk';

    public function lahan()
    {
        return $this->belongsTo(lahan::class, 'lahan_id', 'id');
    }

    public function list_pupuk()
    {
        return $this->hasMany(ListPupuk::class, 'alokasi_id', 'id');
    }
}
