<?php

namespace App\Models;

use App\Models\Airline;
use App\Models\FlightSeat;
use App\Models\FlightClass;
use App\Models\FlightSegment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flight extends Model
{

    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function flightSegments()
    {
        return $this->hasMany(FlightSegment::class);
    }

    public function flightClasses()
    {
        return $this->hasMany(FlightClass::class);;
    }

    public function flightSeats()
    {
        return $this->hasMany(FlightSeat::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
