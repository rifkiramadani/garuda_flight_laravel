<?php

namespace App\Repositories;

use App\Models\Airport;
use App\interfaces\AirportRepositoryInterface;

class AirportRepository implements AirportRepositoryInterface
{
    public function getAllAirports()
    {
        return Airport::all();
    }

    public function getAirportBySlug($slug)
    {
        return Airport::where('slug', $slug)->first();
    }

    public function getAirportByIataCode($iataCode)
    {
        return Airport::where('iatacode', $iataCode)->first();
    }
}
