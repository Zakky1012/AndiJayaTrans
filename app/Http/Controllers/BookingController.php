<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePassangerDetailRequest;
use App\Interfaces\KeberangkatanRepositoryInterface;
use App\Interfaces\TransaksiRepositoryInterface;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private KeberangkatanRepositoryInterface $keberangkatanRepository;
    private TransaksiRepositoryInterface $transaksiRepository;

    public function __construct
    (
        KeberangkatanRepositoryInterface $keberangkatanRepository,
        TransaksiRepositoryInterface $transaksiRepository
    ) {
        $this->keberangkatanRepository = $keberangkatanRepository;
        $this->transaksiRepository     = $transaksiRepository;
    }

    public function booking(Request $request, $nomorKeberangkatan) {
        $this->transaksiRepository->saveTransaksiDataToSession(request()->all());

        return redirect()->route('booking.chooseSeat', ['nomorKeberangkatan' => $nomorKeberangkatan]);
    }

    public function chooseSeat(Request $request, $nomorKeberangkatan) {
        $transaction    = $this->transaksiRepository->getTransaksiDataFromSession();
        $keberangkatan  = $this->keberangkatanRepository->getKeberangkatanByNomorKeberangkatan($nomorKeberangkatan);
        $tier           = $keberangkatan->classKeberangkatan->find($transaction['keberangkatan_class_id']);

        return view('pages.booking.choose-seat', compact('transaction','keberangkatan','tier'));
    }

    public function confirmSeat(Request $request, $nomorKeberangkatan) {

        $this->transaksiRepository->saveTransaksiDataToSession($request->all());

        return redirect()->route('booking.passengerDetails', ['nomorKeberangkatan' => $nomorKeberangkatan]);
    }

    public function passengerDetails(Request $request, $nomorKeberangkatan){
        $transaction    = $this->transaksiRepository->getTransaksiDataFromSession();
        $keberangkatan  = $this->keberangkatanRepository->getKeberangkatanByNomorKeberangkatan($nomorKeberangkatan);
        $tier           = $keberangkatan->classKeberangkatan->find($transaction['keberangkatan_class_id']);

        return view('pages.booking.passenger-details', compact('transaction','keberangkatan','tier'));
    }

    public function savePassengerDetails(StorePassangerDetailRequest $request, $nomorKeberangkatan){
        dd($request->all());
        $this->transaksiRepository->saveTransaksiDataToSession($request->all());
    }

    public function checkout($nomorKeberangkatan) {
        $transaction    = $this->transaksiRepository->getTransaksiDataFromSession();
        $keberangkatan  = $this->keberangkatanRepository->getKeberangkatanByNomorKeberangkatan($nomorKeberangkatan);
        $tier           = $keberangkatan->classKeberangkatan->find($transaction['keberangkatan_class_id']);

        return view('pages.booking.passenger-details', compact('transaction','keberangkatan','tier'));
    }

    public function checkBooking() {
        return view('pages.booking.check-booking');
    }
}
