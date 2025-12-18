<?php

namespace App\Repositories;

use App\Models\PromoCode;
use App\Models\FlightClass;
use App\Models\Transaction;
use App\Models\TransactionPassenger;
use App\interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{

    public function getTransactionDataFromSession()
    {
        // return session()->get('transaction');
        return session()->get('transaction', []);
    }

    public function saveTransactionDataToSession($data)
    {
        $transaction = session()->get('transaction', []);

        foreach ($data as $key => $value) {
            $transaction[$key] = $value;
        }

        session()->put('transaction', $transaction);
    }

    public function saveTransaction($data)
    {
        $data['code'] = $this->generateTransactionCode();
        $data['number_of_passangers'] = $this->countPassangers($data['passangers']);

        //hitung subtotal dan grand total awal
        $data['subtotal'] = $this->calculateSubtotal($data['flight_class_id'], $data['number_of_passangers']);
        $data['grandtotal'] = $data['subtotal'];

        //terapkan promo code jika ada
        if (!empty($data['promo_code'])) {
            $this->applyPromoCode($data);
        }

        //tambahkan ppn
        $data['grandtotal'] = $this->addPPN($data['grandtotal']);

        //simpan transaksi dan penumpang
        $transaction  = $this->createTransaction($data);
        $this->savePassangers($data['passangers'], $transaction->id);

        session()->forget('transaction');

        return $transaction;
    }

    private function generateTransactionCode()
    {
        return "BWAGARUDA" . rand(1000, 9999);
    }

    private function countPassangers($passangers)
    {
        return count($passangers);
    }

    private function calculateSubtotal($flightClassId, $numberOfPassangers)
    {
        $price = FlightClass::findOrFail($flightClassId)->price;

        return $price * $numberOfPassangers;
    }

    private function applyPromoCode($data)
    {
        $promo = PromoCode::where('code', $data['promo_code'])
            ->where('valid_until', '>=', now())
            ->where('is_used', false)
            ->first();

        if ($promo) {
            if ($promo->discount_type === 'percentage') {
                $data['discount'] = $data['grandtotal'] * ($promo->discount / 100);
            } else {
                $data['discount'] = $promo->discount;
            }

            $data['grandtotal'] -= $data['discount'];
            $data['promo_code_id'] = $promo->id;

            //tandai promo code sebagai sudah digunakan
            $promo->update(['is_used' => true]);
        }
    }

    private function addPPN($grandTotal)
    {
        $ppn = $grandTotal * 0.11;
        return $grandTotal + $ppn;
    }

    private function createTransaction($data)
    {
        return Transaction::create($data);
    }

    private function savePassangers($passangers, $transactionId)
    {
        // dd($passangers);
        foreach ($passangers as $passanger) {
            $passanger['transaction_id'] = $transactionId;
            TransactionPassenger::create($passanger);
        }
    }

    public function getTransactionByCode($code)
    {
        return Transaction::where('code', $code)->first();
    }

    public function getTransactionByCodePhone($code, $phone)
    {
        return Transaction::with([
            'flight.flightSegments.airport',
            'flight.airline',
            'flightClass',
            'transactionPassangers.flightSeat',
            'promoCode'
        ])
            ->where('code', $code)
            ->where('phone', $phone)
            ->first(); // 🔥 INI WAJIB
    }
}
