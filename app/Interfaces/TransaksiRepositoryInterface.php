<?php 

namespace App\Interfaces;

interface TransaksiRepositoryInterface {
  public function getTransaksiDataFromSession();

  public function saveTransaksiDataToSession($data);

  public function saveTransaksi($data);

  public function getTransaksiByCode($code);

  public function getTransaksiByCodeEmailPhone($code, $email, $phone);
}