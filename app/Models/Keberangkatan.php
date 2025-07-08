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

    public function generateSeats()
    {
        $classes = $this->classKeberangkatan;

        foreach ($classes as $class) {
            $totalSeats     = $class->total_seats;
            $seatsPerRow    = $this->getSeatsPerRow($class->tipe_kelas);
            $rows           = ceil($totalSeats / $seatsPerRow);

            $existingSeats = kursiKeberangkatan::where('keberangkatan_id', $this->id)
                ->where('tipe_kelas', $class->tipe_kelas)
                ->get();

            $existingRows   = $existingSeats->pluck('row')->toArray();

            $seatCounter    = 1;

            for ($row = 1; $row <= $rows; $row++) {
                if (!in_array($row, $existingRows)) {
                    for ($column = 1; $column <= $seatsPerRow; $column++) {
                        if ($seatCounter > $totalSeats) {
                            break;
                        }

                        kursiKeberangkatan::create([
                            'keberangkatan_id'  => $this->id,
                            'row'               => $row,
                            'column'            => $column,
                            'tipe_kelas'        => $class->tipe_kelas,
                            'is_available'      => true,
                        ]);

                        $seatCounter++;
                    }
                }
            }

            foreach ($existingSeats as $existingSeat) {
                if ($existingSeat->column > $seatsPerRow || $existingSeat->row > $rows) {
                    $existingSeat->is_available = false;
                    $existingSeat->save();
                }
            }
        }
    }

    protected function getSeatsPerRow($tipeKelas)
    {
        switch ($tipeKelas) {
            case 'ekonomi':
                return 2;
            case 'premium':
                return 2;
            default:
                return 2;
        }
    }

}
