<?php

namespace App\Models;

use App\Models\FlightSegment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airport extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function flightSegments()
    {
        return $this->hasMany(FlightSegment::class);
    }
}
