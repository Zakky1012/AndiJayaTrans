<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SegmentKeberangkatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sequence',
        'id_keberangkatan',
        'id_destinasi',
        'time'
    ];
}
