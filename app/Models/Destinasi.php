<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destinasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rute_perjalanan',
        'gambar',
        'kota'
    ];

    public function segmentKeberangkatan(){
        return $this->hasMany(SegmentKeberangkatan::class);
    }
}
