<?php

namespace App\interfaces;

interface AirportRepositoryInterface
{
    public function getAllAirports();

    public function getAirportBySlug($slug);

    public function getAirportByIataCode($iataCode);
}
