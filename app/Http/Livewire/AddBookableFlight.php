<?php

namespace App\Http\Livewire;

use App\Models\BookableFlight;
use App\Models\Event;
use Livewire\Component;

class AddBookableFlight extends Component
{
    public $event;

    public $callsign;
    public $originAirportIcao;
    public $destinationAirportIcao;
    public $departureDate;
    public $departureTime;
    public $arrivalDate;
    public $arrivalTime;

    public $added = false;

    public function mount(Event $event)
    {
        $this->fill([
            'event' => $event,
            'callsign' => null,
            'originAirportIcao' => null,
            'destinationAirportIcao' => null,
            'departureDate' => null,
            'departureTime' => null,
            'arrivalDate' => null,
            'arrivalTime' => null,
        ]);
    }

    public function updated($field, $value)
    {
        if ($field !== 'added') {
            $this->added = false;
        }

        if (in_array($field, ['callsign', 'originAirportIcao', 'destinationAirportIcao'])) {
            $this->$field = strtoupper($value);
        }
    }

    public function save()
    {
        $this->validate([
            'callsign' => 'required',
            'originAirportIcao' => 'required',
            'destinationAirportIcao' => 'required',
            'departureDate' => 'required',
            'departureTime' => 'required',
            'arrivalDate' => 'required',
            'arrivalTime' => 'required',
        ]);

        $flight = new BookableFlight([
            'event_id' => $this->event->id,
            'begin_date' => $this->departureDate,
            'begin_time' => $this->departureTime,
            'end_date' => $this->arrivalDate,
            'end_time' => $this->arrivalTime,
            'data' => [
                'callsign' => $this->callsign,
                'origin_airport_icao' => $this->originAirportIcao,
                'destination_airport_icao' => $this->destinationAirportIcao,
            ],
        ]);

        $flight->save();

        $this->added = true;

        $this->reset([
            'callsign',
            'originAirportIcao',
            'destinationAirportIcao',
            'departureDate',
            'departureTime',
            'arrivalDate',
            'arrivalTime',
        ]);

        $this->emit('bookableAdded');
    }

    public function render()
    {
        return view('livewire.add-bookable-flight');
    }
}
