<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'keberangkatan_id',
        'kelas_keberangkatan_id',
        'nama',
        'email',
        'nomor_hp',
        'nomor_pessenger',
        'kode_promo_id',
        'status_payment',
        'sub_total',
        'grand_total',
    ];

    public function keberangkatan(){
        return $this->belongsTo(Keberangkatan::class);
    }

    public function classKeberangkatan(){
        return $this->belongsTo(ClassKeberangkatan::class);
    }

    public function promoCode(){
        return $this->belongsTo(PromoCode::class);
    }

    public function transaksiPessenger(){
        return $this->hasMany(TransaksiPassenger::class);
    }
}
