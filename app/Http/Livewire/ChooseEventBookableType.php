<?php

namespace App\Http\Livewire;

use App\Models\BookableFlight;
use App\Models\Event;
use Livewire\Component;

class ChooseEventBookableType extends Component
{
    /** @var Event $event */
    public $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function setBookableType($type)
    {
        $allowedBookableTypes = [
            BookableFlight::TYPE,
        ];

        if (!in_array($type, $allowedBookableTypes)) {
            session()->flash('failure', 'Something went wrong, please try again!');

            $this->redirect(route('office-events.show', ['event' => $this->event]));

            return;
        }

        $this->event->bookable_type = $type;
        $this->event->save();

        session()->flash('success', 'Your event bookable type has been set successfully!');

        $this->redirect(route('office-events.show', ['event' => $this->event]));
    }

    public function render()
    {
        return view('livewire.choose-event-bookable-type');
    }
}
