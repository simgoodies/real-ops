<?php

namespace App\Http\Livewire;

use App\Models\BookableTimeSlot;
use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AddBookableTimeSlot extends Component
{
    public $event;

    public $direction;
    public $assignation;
    public $startDate;
    public $startTime;
    public $duration;
    public $availableBookables;
    public $placeholderAvailableBookables;
    public $assignations;

    public $added = false;

    public function mount(Event $event)
    {
        $this->event = $event;

        $this->startDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->event->start_date)->format('Y-m-d');
        $this->startTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->event->start_time)->format('H:i');
        $this->direction = BookableTimeSlot::DIRECTION_ANY;
        $this->duration = BookableTimeSlot::DURATION_HALFHOUR;
        $this->placeholderAvailableBookables = 'e.g. ' . $this->duration / 2;
        $this->assignations = BookableTimeSlot::getPreviouslyUsedAssignations($event)->toArray();
    }

    public function updated($field, $value)
    {
        if ($field !== 'added') {
            $this->added = false;
        }

        if (in_array($field, ['assignation'])) {
            $this->$field = strtoupper($value);
        }

        if ($field == 'duration') {
            $this->placeholderAvailableBookables = 'e.g. ' . $this->duration / 2;
        }
    }

    public function save()
    {
        $this->validate([
            'direction' => [
                'required',
                Rule::in(
                    BookableTimeSlot::DIRECTION_ANY,
                    BookableTimeSlot::DIRECTION_INBOUND,
                    BookableTimeSlot::DIRECTION_OUTBOUND
                )
            ],
            'assignation' => 'nullable',
            'startDate' => 'required',
            'startTime' => 'required',
            'duration' => ['required', 'numeric', Rule::in(BookableTimeSlot::DURATION_HOUR, BookableTimeSlot::DURATION_HALFHOUR)],
            'availableBookables' => ['required', 'numeric', 'integer', 'min:1'],
        ]);

        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $this->startDate . ' ' . $this->startTime);
        $endDateTime = $startDateTime->copy()->addMinutes($this->duration);

        $startDate = $startDateTime->format('Y-m-d');
        $startTime = $startDateTime->format('H:i:00');
        $endDate = $endDateTime->format('Y-m-d');
        $endTime = $endDateTime->format('H:i:00');

        for ($i = $this->availableBookables; $i > 0; $i--) {

            $timeslot = new BookableTimeSlot([
                'event_id' => $this->event->id,
                'begin_date' => $startDate,
                'begin_time' => $startTime,
                'end_date' => $endDate,
                'end_time' => $endTime,
                'data' => [
                    'assignation' => $this->assignation,
                    'direction' => $this->direction,
                    'available_bookables' => $this->availableBookables,
                ],
            ]);

            $timeslot->save();
        }


        $this->added = true;

        $this->reset([
            'assignation',
        ]);

        $this->emit('bookableAdded');
    }

    public function render()
    {
        return view('livewire.add-bookable-time-slot');
    }
}
