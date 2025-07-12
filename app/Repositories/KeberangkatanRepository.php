<?php

namespace App\Repositories;

use App\Models\Keberangkatan;
use App\Interfaces\KeberangkatanRepositoryInterface;

class KeberangkatanRepository implements KeberangkatanRepositoryInterface {
  public function getAllKeberangkatans($filter = null) {
    $keberangkatan = Keberangkatan::query();

    if(!empty($filter['departure'])) {
      $keberangkatan->whereHas('segmentKeberangkatan', function ($query) use ($filter) {
        $query->where('keberangkatan_id', $filter['departure'])
          ->where('sequence', 1);
      });
    }
    
    if(!empty($filter['arrival'])) {
      $keberangkatan->whereHas('segmentKeberangkatan', function ($query) use ($filter) {
        $query->where('keberangkatan_id', $filter['arrival'])
          ->orderBy('sequence', 'desc')
          ->limit(1);
      });
    }
    
    if(!empty($filter['date'])) {
      $keberangkatan->whereHas('segmentKeberangkatan', function ($query) use ($filter) {
        $query->whereDate('time', $filter['date']);
      });
    }

    return $keberangkatan->get();
  }

  public function getKeberangkatanByNomorKeberangkatan($nomorKeberangkatan) {
    return Keberangkatan::where('nomor_keberangkatan', $nomorKeberangkatan)->first();
  }
}