<?php

namespace App\Http\Livewire;

use App\Models\Bookable;
use App\Models\BookableTimeSlot;
use App\Models\Event;
use Livewire\Component;

class OfficeDisplayBookables extends Component
{
    protected $listeners = [
        'bookableAdded' => '$refresh',
        'bookableDeleted' => '$refresh',
    ];

    public $event = null;
    public $bookables = null;

    public function mount(Event $event) {
        $this->event = $event;
        $this->bookables = [];
    }

    public function deleteBookable($bookableId)
    {
        if (!$bookable = $this->bookables->find($bookableId)) {
            return;
        }

        if ($bookable->type == 'time-slot') {
            BookableTimeSlot::where('begin_date', $bookable->begin_date)
                ->where('begin_time', $bookable->begin_time)
                ->where('end_date', $bookable->end_date)
                ->where('end_time', $bookable->end_time)
                ->where('data->assignation', $bookable->data['assignation'] ?? null)
                ->where('data->direction', $bookable->data['direction'] ?? null)
                ->delete();

            $this->render();

            return;
        }

        $bookable->delete();
        $this->render();
    }

    public function render()
    {
        if ($this->event->bookable_type == BookableTimeSlot::TYPE) {
            $this->bookables = Bookable::where('event_id', $this->event->id)->groupBy(
                'begin_date',
                'begin_time',
                'data->assignation',
                'data->direction'
            )->get();

            return view('livewire.office-display-bookables');
        }

        $this->bookables = Bookable::where('event_id', $this->event->id)->get();

        return view('livewire.office-display-bookables');
    }
}
