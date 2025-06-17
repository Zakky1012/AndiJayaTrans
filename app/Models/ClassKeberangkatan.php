<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassKeberangkatan extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'id_keberangkatan',
        'tipe_kelas',
        'harga',
        'total_kursi'
    ];
}
