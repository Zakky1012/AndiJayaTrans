<?php

namespace App\Http\Controllers;

use App\Interfaces\DestinasiRepositoryInterface;
use App\Interfaces\KeberangkatanRepositoryInterface;
use App\Interfaces\MobilRepositoryInterface;
use App\Models\Keberangkatan;
use Illuminate\Http\Request;

class KeberangkatanController extends Controller
{
    private DestinasiRepositoryInterface $destinasiRepository;
    private MobilRepositoryInterface $mobilRepository;
    private KeberangkatanRepositoryInterface $keberangkatanRepository;

    public function __construct(DestinasiRepositoryInterface $destinasiRepository,
                                MobilRepositoryInterface $mobilRepository,
                                KeberangkatanRepositoryInterface $keberangkatanRepository) {
        $this->destinasiRepository      = $destinasiRepository;
        $this->keberangkatanRepository  = $keberangkatanRepository;
        $this->mobilRepository          = $mobilRepository;
    }

    public function index(Request $request) {

        $departure = $this->destinasiRepository->getDestinasiByIataCode($request->departure);
        $arrival   = $this->destinasiRepository->getDestinasiByIataCode($request->arrival);

        $keberangkatans = $this->keberangkatanRepository->getAllKeberangkatans([
            'departure' => $departure->id ?? null,
            'arrival'   => $arrival->id ?? null,
            'date'      => $request->date ?? null,
        ]);

        $mobils      = $this->mobilRepository->getAllMobils();

        return view('pages.keberangkatan.index', compact('keberangkatans', 'mobils'));
    }
}
