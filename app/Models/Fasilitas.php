<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gambar',
        'nama',
        'deskripsi'
    ];

    public function classes(){
        return $this->belongsToMany(Fasilitas::class, 'keberangkatan_class_fasilitas', 'keberangkatan_class_id', 'fasilitas_id');
    }
}
