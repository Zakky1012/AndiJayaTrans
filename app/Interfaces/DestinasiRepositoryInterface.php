<?php 

namespace App\Interfaces;

interface DestinasiRepositoryInterface {
  public function getAllDestinasis();

  public function getDestinasiBySlug($slug);

  public function getDestinasiByIataCode($iataCode);
}