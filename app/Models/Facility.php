<?php

namespace App\Models;

use App\Models\FlightClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function flightClasses()
    {
        return $this->belongsToMany(FlightClass::class, 'flight_class_facility_pivot', 'facility_id', 'flight_class_id');
    }
}
