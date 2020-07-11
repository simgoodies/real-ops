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
        $this->startDate = $event->start_date;
        $this->startTime = $event->start_time;
        $this->endDate = $event->end_date;
        $this->endTime = $event->end_time;
    }

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required',
            'startDate' => 'required|date',
            'startTime' => 'required|date_format:H:i:s',
            'endDate' => 'required|date',
            'endTime' => 'required|date_format:H:i:s',
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
    }

    public function render()
    {
        return view('livewire.edit-event');
    }
}
