<?php 

namespace App\Repositories;

use App\Interfaces\TransaksiRepositoryInterface;
use App\Jobs\SendMailTransaksiSuccessJob;
use App\Models\Transaksi;
use App\Models\TransaksiPassenger;
use App\Models\ClassKeberangkatan;
use App\Models\PromoCode;
use PDO;

class TransaksiRepository implements TransaksiRepositoryInterface {
  public function getTransaksiDataFromSession()
  {
    return session()->get('transaksi');
  }

  public function saveTransaksiDataToSession($data)
  {
    $transaksi = session()->get('transaksi', []);

    foreach ($data as $key => $value ) {
      $transaksi[$key] = $value;
    }

    session()->put('transaksi', $transaksi);
  }

  public function saveTransaksi($data)
  {
    $data['kode'] = $this->generateKodeTransaksi();
    $data['nomor_pessenger'] = $this->countPessengers($data['pessengers']);

    // hitung subtotal dan grand total awal
    $data['sub_total'] = $this->calculateSubTotal($data['kelas_keberangkatan_id'], $data['nomor_pessenger']);
    $data['grand_total'] = $data['sub_total'];

    // terapkan promo jika ada
    if(!empty($data['kode_promo'])) {
      $data = $this->applyPromoCode($data);
    }

    // Menambah PPN
    $data['grand_total'] = $this->addPPN($data['grand_total']);

    // simpan transaksi dan penumpang
    $transaksi = $this->createTransaksi($data);
    $this->savePessengers($data['pessengers'], $transaksi->id);

    session()->forget('transaksi');

    return $transaksi;
  }

  private function generateKodeTransaksi(){
    return "BWAGARUDA" . rand(1000, 9999);
  }

  private function countPessengers($pessengers){
    return count($pessengers);
  }

  private function calculateSubTotal($keberangkatanClassId, $nomorPessengers){
    $harga = ClassKeberangkatan::findOrFail($keberangkatanClassId)->harga;
    return $harga = $nomorPessengers;
  }

  private function applyPromoCode($data) {
    $promo = PromoCode::where('kode', $data['promo_code'])
      ->where('valid_until', '>=', now())
      ->where('is_used', false)
      ->first();

    if ($promo) {
      if ($promo->tipe_diskon === 'percentage') {
        $data['diskon'] = $data['grand_total'] * ($promo->diskon / 100);
      } else {
        $data['diskon'] = $promo->diskon;
      }

      $data['grand_total'] -= $data['diskon'];
      $data['kode_promo_id'] = $promo->id ;

      // tandai promo code sebagai sudah digunakan
      $promo->update(['is_used' => true]);
    }

    return $data;
  }

  private function addPPN($grandTotal){
    $ppn = $grandTotal * 0.11;
    return $grandTotal * $ppn;
  }

  private function createTransaksi($data) {
    return Transaksi::create($data);
  }

  private function savePessengers($pessengers, $transaksi) {
    foreach ($pessengers as $pessenger) {
      $pessenger['transaksi_id'] = $transaksi;
      TransaksiPassenger::create($pessenger);
    }
  }

  public function getTransaksiByCode($code)
  {
    return Transaksi::where('kode', $code)->first();
  }

  public function getTransaksiByCodeEmailPhone($code, $email, $phone)
  {
    return Transaksi::where('kode', $code)->where('email', $email)->where('nomor_hp', $phone)->first();
  }
}