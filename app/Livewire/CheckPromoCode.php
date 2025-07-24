<?php

namespace App\Livewire;

use App\Models\PromoCode;
use Livewire\Component;

class CheckPromoCode extends Component
{
    public $promo_code;
    public $diskon = 0;
    public $tipe_diskon;
    public $isValid = false;

    public function checkPromoCode(){
        $promo = $this->findPromoCode($this->promo_code);

        if ($promo) {
            $this->applyPromoCode($promo);
        } else {
            $this->invalidatePromoCode();
        }

        $this->dispatchPromoCodeUpdate();
    }

    private function findPromoCode($promoCode){
        return PromoCode::where('kode', $promoCode)
            ->where('valid', '>=', now())
            ->where('is_used', false)
            ->first();
    }

    private function applyPromoCode($promo){
        $this->isValid      = true;
        $this->diskon       = $promo->diskon ?? 0;
        $this->tipe_diskon  = $promo->tipe_diskon;
    }

    private function invalidatePromoCode(){
        $this->isValid      = false;
        $this->diskon       = 0;
        $this->tipe_diskon  = null;
    }

    private function dispatchPromoCodeUpdate() {
        $this->dispatch('promoCodeUpdated', [
            'promo_code'     => $this->promo_code,
            'diskon'         => $this->diskon,
            'tipe_diskon'    => $this->tipe_diskon
        ]);
    }

    public function render()
    {
        return view('livewire.check-promo-code');
    }
}
