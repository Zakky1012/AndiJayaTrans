<?php

namespace App\Repositories;

use App\Models\Keberangkatan;
use App\Interfaces\KeberangkatanRepositoryInterface;

class KeberangkatanRepository implements KeberangkatanRepositoryInterface {
public function getAllKeberangkatans($filter = null)
{
    $query = Keberangkatan::with([
        'segmentKeberangkatan.destinasi',
        'classKeberangkatan.fasilitas',
        'mobil',
    ]);

    // Filter: Departure
    if (!empty($filter['departure'])) {
        $query->whereHas('segmentKeberangkatan', function ($q) use ($filter) {
            $q->where('destinasi_id', $filter['departure']);
        });
    }

    // Filter: Arrival
    if (!empty($filter['arrival'])) {
        $query->whereHas('segmentKeberangkatan', function ($q) use ($filter) {
            $q->where('destinasi_id', $filter['arrival']);
        });
    }

    // Filter: Date
    if (!empty($filter['date'])) {
        $query->whereHas('segmentKeberangkatan', function ($q) use ($filter) {
            $q->whereDate('time', $filter['date']);
        });
    }

    // ✅ Filter: Quantity (INI YANG PENTING)
    if (!empty($filter['quantity'])) {
        $query->whereHas('classKeberangkatan', function ($q) use ($filter) {
            $q->where('total_kursi', '>=', (int) $filter['quantity']);
        });
    }

    return $query->get();
    dd($query->toSql());
}


public function getKeberangkatanByNomorKeberangkatan($nomorKeberangkatan) {
    return Keberangkatan::where('nomor_keberangkatan', $nomorKeberangkatan)->first();
  }

}
