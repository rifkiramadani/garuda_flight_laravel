<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePassangerDetailRequest;
use App\interfaces\FlightRepositoryInterface;
use App\interfaces\TransactionRepositoryInterface;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private FlightRepositoryInterface $flightRepository;
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(
        FlightRepositoryInterface $flightRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        $this->flightRepository = $flightRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function booking(Request $request, $flightNumber)
    {
        // dd($request->all());
        // dd(session()->all());

        $this->transactionRepository->saveTransactionDataToSession($request->all());
        return redirect()->route('booking.chooseSeat', ['flightNumber' => $flightNumber]);
    }

    public function chooseSeat(Request $request, $flightNumber)
    {
        // dd(session()->all());

        $transaction = $this->transactionRepository->getTransactionDataFromSession();

        // --- Perbaikan dimulai di sini ---

        // Pengecekan jika data 'flight_class_id' tidak ada dalam session
        // Ini mencegah akses offset pada null jika transaction belum disimpan
        if (!isset($transaction['flight_class_id'])) {
            // Redirect ke halaman pilih tier/flight jika data session hilang
            return redirect()->route('flight.index')->with('error', 'Please select a flight and a class tier first.');
        }

        // --- Perbaikan berakhir di sini ---

        $flight = $this->flightRepository->getFlightByFlightNumber($flightNumber);
        $tier = $flight->flightClasses->find($transaction['flight_class_id']);

        return view('pages.booking.choose-seat', compact('transaction', 'flight', 'tier'));
    }

    public function confirmSeat(Request $request, $flightNumber)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->all());
        return redirect()->route('booking.passangerDetails', ['flightNumber' => $flightNumber]);
    }

    public function passangerDetails(Request $request, $flightNumber)
    {
        // dd(session()->all());

        $transaction = $this->transactionRepository->getTransactionDataFromSession();

        // --- Perbaikan dimulai di sini ---

        // Pengecekan jika data 'flight_class_id' tidak ada dalam session
        // Ini mencegah akses offset pada null jika transaction belum disimpan
        if (!isset($transaction['flight_class_id'])) {
            // Redirect ke halaman pilih tier/flight jika data session hilang
            return redirect()->route('flight.index')->with('error', 'Please select a flight and a class tier first.');
        }

        // --- Perbaikan berakhir di sini ---

        $flight = $this->flightRepository->getFlightByFlightNumber($flightNumber);
        $tier = $flight->flightClasses->find($transaction['flight_class_id']);

        return view('pages.booking.passanger-details', compact('transaction', 'flight', 'tier'));
    }

    public function savePassangerDetails(Request $request, $flightNumber)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->all());
        return redirect()->route('booking.checkout', ['flightNumber' => $flightNumber]);
    }

    public function checkout($flightNumber)
    {
        // dd(session()->all());

        $transaction = $this->transactionRepository->getTransactionDataFromSession();

        // --- Perbaikan dimulai di sini ---

        // Pengecekan jika data 'flight_class_id' tidak ada dalam session
        // Ini mencegah akses offset pada null jika transaction belum disimpan
        if (!isset($transaction['flight_class_id'])) {
            // Redirect ke halaman pilih tier/flight jika data session hilang
            return redirect()->route('flight.index')->with('error', 'Please select a flight and a class tier first.');
        }

        // --- Perbaikan berakhir di sini ---

        $flight = $this->flightRepository->getFlightByFlightNumber($flightNumber);
        $tier = $flight->flightClasses->find($transaction['flight_class_id']);

        // dd($transaction);

        return view('pages.booking.checkout', compact('transaction', 'flight', 'tier'));
    }

    public function payment(Request $request)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->all());

        $transaction = $this->transactionRepository->saveTransaction($this->transactionRepository->getTransactionDataFromSession());

        //set your merchant server key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        //set to development/sandbox environtment (default). set to true for production environtment(accept real transaction)
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        //set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        //set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => $transaction->grandtotal
            ]
        ];

        $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

        return redirect($paymentUrl);
    }

    public function success(Request $request)
    {
        $transaction = $this->transactionRepository->getTransactionByCode($request->order_id);

        if (!$transaction) {
            return redirect()->route('home');
        }

        return view('pages.booking.success', compact('transaction'));
    }

    public function checkBooking()
    {
        return view('pages.booking.check-booking');
    }
}
