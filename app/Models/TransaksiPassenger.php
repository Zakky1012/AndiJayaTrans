<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiPassenger extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaksi_id',
        'kursi_keberangkatan_id',
        'nama',
        'date_of_birth',
        'kewarganeraan',
    ];

    public function transaksi(){
        return $this->belongsTo(Transaksi::class);
    }

    public function kursi(){
        return $this->belongsTo(KursiKeberangkatan::class, 'kursi_keberangkatan_id');
    }
}
