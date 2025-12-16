<?php

namespace App\Http\Controllers;

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

        return view('pages.booking.choose-seat', compact('transaction', 'flight', 'tier'));
    }

    public function confirmSeat(Request $request)
    {

        dd($request->all());
        $this->transactionRepository->saveTransactionDataToSession($request->all());
    }

    public function checkBooking()
    {
        return view('pages.booking.check-booking');
    }
}
