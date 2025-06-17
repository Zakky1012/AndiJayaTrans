<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keberangkatan extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'nomor_keberangkatan',
        'mobil_id'
    ];
}
