<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KursiKeberangkatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_keberangkatan',
        'row',
        'column',
        'tipe_kelas',
        'is_available'
    ];
}
