<?php 

namespace App\Interfaces;

interface KeberangkatanRepositoryInterface {
  public function getAllKeberangkatans($filter = null);

  public function getKeberangkatanByNomorKeberangkatan($nomorKeberangkatan);
}
