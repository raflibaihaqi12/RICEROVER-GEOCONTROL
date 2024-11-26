<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPupuk extends Model
{
    use HasFactory;

    protected $table = 'list_pupuk';

    public function alokasi()
    {
        return $this->belongsTo(AlokasiPupuk::class, 'alokasi_id', 'id');
    }
}
