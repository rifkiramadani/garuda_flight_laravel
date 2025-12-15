<?php

namespace App\Http\Controllers;

use App\interfaces\AirportRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private AirportRepositoryInterface $airportRepository;

    public function __construct(AirportRepositoryInterface $airportRepository)
    {
        $this->airportRepository = $airportRepository;
    }

    public function index()
    {
        $airports = $this->airportRepository->getAllAirports();

        return view('pages.home', compact('airports'));
    }
}
