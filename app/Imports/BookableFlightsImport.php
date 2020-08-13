<?php

namespace App\Imports;

use App\Models\BookableFlight;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BookableFlightsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BookableFlight([
            'event_id' => $this->event->id,
            'begin_date' => $row['departure_date'],
            'begin_time' => $row['departure_time'],
            'end_date' => $row['arrival_date'],
            'end_time' => $row['arrival_time'],
            'data' => [
                'callsign' => $row['callsign'],
                'origin_airport_icao' => $row['origin_airport_icao'],
                'destination_airport_icao' => $row['destination_airport_icao'],
            ]
        ]);
    }

    public function rules(): array
    {
        return [
            'departure_date' => ['required'],
            'departure_time' => ['required'],
            'arrival_date' => ['required'],
            'arrival_time' => ['required'],
        ];
    }
}
