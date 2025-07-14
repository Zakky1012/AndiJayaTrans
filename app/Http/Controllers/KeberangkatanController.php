<?php

namespace App\Http\Controllers;

use App\Interfaces\DestinasiRepositoryInterface;
use App\Interfaces\KeberangkatanRepositoryInterface;
use App\Interfaces\MobilRepositoryInterface;
use App\Models\Keberangkatan;
use App\Models\SegmentKeberangkatan;
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

    public function index(Request $request)
    {
        $segments = SegmentKeberangkatan::orderBy('keberangkatan_id')->get(['id', 'keberangkatan_id', 'destinasi_id', 'sequence', 'time']);

        // Ambil data destinasi berdasarkan kode IATA jika tersedia
        $departure = $request->filled('departure')
            ? $this->destinasiRepository->getDestinasiByIataCode($request->departure)
            : null;

        $arrival = $request->filled('arrival')
            ? $this->destinasiRepository->getDestinasiByIataCode($request->arrival)
            : null;

        // Siapkan filter hanya jika data tersedia dan valid
        $filters = [
            'departure' => $departure?->id,  // gunakan null-safe operator
            'arrival'   => $arrival?->id,
            'date'      => $request->date,
            'quantity'  => $request->quantity,
        ];

        // Ambil data berdasarkan filter (jika kosong akan mengambil semua)
        $keberangkatans = $this->keberangkatanRepository->getAllKeberangkatans($filters);

        // Ambil semua data mobil
        $mobils = $this->mobilRepository->getAllMobils();

        // Ambil data semua destinasi (untuk dropdown filter)
        $destinasis = $this->destinasiRepository->getAllDestinasis();

        // Kirim data ke view
        return view('pages.keberangkatan.index', compact('keberangkatans', 'mobils', 'destinasis'));
    }

}
