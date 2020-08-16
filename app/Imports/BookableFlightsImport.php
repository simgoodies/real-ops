<?php

namespace App\Imports;

use App\Models\BookableFlight;
use App\Models\Event;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BookableFlightsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function model(array $row)
    {
        $row['departure_time'] = Carbon::createFromFormat('Hi', $row['departure_time']);
        $row['arrival_time'] = Carbon::createFromFormat('Hi', $row['arrival_time']);

        if (empty($row['departure_date'])) {
            $row['departure_date'] = $this->event->start_date;

            if ($row['arrival_time'] > $row['departure_time']) {
                $row['arrival_date'] = $this->event->start_date;
            } else {
                $row['arrival_date'] = $this->event->start_date->addDay();
            }
        }

        if ($row['departure_date'] && empty($row['arrival_date'])) {
            $row['arrival_date'] = $row['departure_date'];
        }

        if (empty($row['callsign'])) {
            return null;
        }

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
            'callsign' => ['required'],
            'departure_date' => ['nullable'],
            'departure_time' => ['required'],
            'arrival_date' => ['nullable'],
            'arrival_time' => ['required'],
            'origin_airport_icao' => ['required'],
            'destination_airport_icao' => ['required'],
        ];
    }
}
