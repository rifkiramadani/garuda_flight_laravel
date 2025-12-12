<?php

namespace App\Models;

use App\Models\Flight;
use App\Models\Facility;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlightClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'flight_class_facility_pivot', 'flight_class_id', 'facility_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
