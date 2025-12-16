<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PromoCode;

class CheckPromoCode extends Component
{

    public $promo_code;
    public $discount = 0;
    public $discount_type;

    public $isValid = false;
    public $message;

    public function checkPromoCode()
    {
        // Jika input kosong, reset status dan pesan
        if (empty($this->promo_code)) {
            $this->invalidatePromoCode();
            $this->message = ''; // Hapus pesan jika input kosong
            $this->dispatchPromoCodeUpdate();
            return;
        }

        $promo = $this->findPromoCode($this->promo_code);

        if ($promo) {
            $this->applyPromoCode($promo);
            $this->message = 'Kode promo tersedia.'; // Set pesan berhasil
        } else {
            $this->invalidatePromoCode();
            $this->message = 'Kode promo tidak tersedia.'; // Set pesan gagal
        }

        $this->dispatchPromoCodeUpdate();
    }

    public function findPromoCode($promoCode)
    {
        return PromoCode::where('code', $promoCode)
            ->where('valid_until', '>=', now())
            ->where('is_used', false)
            ->first();
    }

    public function applyPromoCode($promo)
    {
        $this->isValid = true;
        $this->discount = $promo->discount ?? 0;
        $this->discount_type = $promo->discount_type;
    }

    public function invalidatePromoCode()
    {
        $this->isValid = false;
        $this->discount = 0;
        $this->discount_type = null;
    }

    private function dispatchPromoCodeUpdate()
    {
        $this->dispatch('promoCodeUpdated', [
            'promo_code' => $this->promo_code,
            'discount' => $this->discount,
            'discount_type' => $this->discount_type
        ]);
    }

    public function render()
    {
        return view('livewire.check-promo-code');
    }
}
