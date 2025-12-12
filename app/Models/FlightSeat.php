<?php

namespace App\Models;

use App\Models\Flight;
use App\Models\TransactionPassenger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlightSeat extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function transactionPassengers()
    {
        return $this->hasMany(TransactionPassenger::class);
    }
}
