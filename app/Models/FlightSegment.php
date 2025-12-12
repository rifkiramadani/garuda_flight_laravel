<?php

namespace App\Models;

use App\Models\Flight;
use App\Models\Airport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlightSegment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function airport()
    {
        return $this->belongsTo(Airport::class);
    }
}
