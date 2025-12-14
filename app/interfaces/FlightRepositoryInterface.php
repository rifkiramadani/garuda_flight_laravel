<?php

namespace App\interfaces;

interface FlightRepositoryInterface
{
    public function getAllFlights($filter = null);

    public function getFlightByFlightNumber($flightNumber);
}
