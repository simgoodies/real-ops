<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;

class EditEvent extends Component
{
    public $event;

    public $title;
    public $description;
    public $startDate;
    public $startTime;
    public $endDate;
    public $endTime;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->startDate = $event->start_date->format('Y-m-d');
        $this->startTime = $event->start_time->format('H:i');
        $this->endDate = $event->end_date->format('Y-m-d');
        $this->endTime = $event->end_time->format('H:i');
    }

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required',
            'startDate' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'endDate' => 'required|date',
            'endTime' => 'required|date_format:H:i',
        ]);

        $this->event->fill([
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
        ]);

        $this->event->save();

        $this->dispatchBrowserEvent('event-saved');
    }

    public function render()
    {
        return view('livewire.edit-event');
    }
}
