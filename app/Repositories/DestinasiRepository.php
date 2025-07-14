<?php

namespace App\Repositories;

use App\Interfaces\DestinasiRepositoryInterface;
use App\Models\Destinasi;

class DestinasiRepository implements DestinasiRepositoryInterface {
  public function getAllDestinasis(){
    return Destinasi::all();
  }

  public function getDestinasiBySlug($slug){
    return Destinasi::where('slug', $slug)->first();
  }

  public function getDestinasiByIataCode($iataCode){
    return Destinasi::where('iata_code', $iataCode)->first();
  }
}
