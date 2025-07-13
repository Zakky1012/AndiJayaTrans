<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\KeberangkatanRepositoryInterface;
use App\Models\Destinasi;

class HomeController extends Controller
{
    private $keberangkatanRepository;

    public function __construct(KeberangkatanRepositoryInterface $keberangkatanRepository)
    {
        $this->keberangkatanRepository = $keberangkatanRepository;
    }

    public function index(Request $request)
    {
        $filter = [
            'departure' => $request->input('departure'),
            'arrival'   => $request->input('arrival'),
            'date'      => $request->input('date'),
            'quantity'  => $request->input('quantity', 1), // default 1
        ];

        $destinasis = Destinasi::all();
        $keberangkatans = $this->keberangkatanRepository->getAllKeberangkatans($filter);

        return view('pages.home', compact('destinasis', 'keberangkatans'));
    }
}
