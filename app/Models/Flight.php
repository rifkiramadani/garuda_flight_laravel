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

    public function generateSeats()
    {
        $flightClasses = $this->flightClasses;

        foreach ($flightClasses as $class) {
            $totalSeats = $class->total_seats;
            $seatsPerRow = $this->getSeatsPerRow($class->class_type);
            $rows = ceil($totalSeats / $seatsPerRow);

            $existingSeats = FlightSeat::where('flight_id', $this->id)
                ->where('class_type', $class->class_type)
                ->get();

            $existingRows = $existingSeats->pluck('row')->toArray();

            $seatCounter = 1;

            for ($row = 1; $row <= $rows; $row++) {
                if (!in_array($row, $existingRows)) {
                    for ($column = 1; $column <= $seatsPerRow; $column++) {
                        if ($seatCounter > $totalSeats) {
                            break;
                        }

                        $seatCode = $this->generateSeatCode($row, $column);

                        FlightSeat::create([
                            'flight_id' => $this->id,
                            'name' => $seatCode,
                            'row' => $row,
                            'column' => $column,
                            'is_available' => true,
                            'class_type' => $class->class_type,
                        ]);

                        $seatCounter++;
                    }
                }
            }

            foreach ($existingSeats as $existingSeat) {
                if ($existingSeat->column > $seatsPerRow || $existingSeat->row > $rows) {
                    $existingSeat->is_available = false;
                    $existingSeat->save();
                }
            }
        }
    }

    protected function getSeatsPerRow($classType)
    {
        switch ($classType) {
            case 'bussiness':
                return 4;
            case 'economic':
                return 6;
            default:
                return 4;
        }
    }

    private function generateSeatCode($row, $column)
    {
        $rowLetter = chr(64 + $row);

        return $rowLetter . $column;
    }
}
