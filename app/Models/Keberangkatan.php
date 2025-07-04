<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Builder\Class_;

class Keberangkatan extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'nomor_keberangkatan',
        'mobil_id'
    ];

    public function mobil(){
        return $this->belongsTo(Mobil::class);
    }

    public function segmentKeberangkatan(){
        return $this->hasMany(SegmentKeberangkatan::class);
    }

    public function classKeberangkatan(){
        return $this->hasMany(ClassKeberangkatan::class);
    }

    public function kursiKeberangkatan(){
        return $this->hasMany(KursiKeberangkatan::class);
    }

    public function transaksi(){
        return $this->hasMany(Transaksi::class);
    }
}
