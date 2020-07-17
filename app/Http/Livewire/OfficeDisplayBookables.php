<?php

namespace App\Http\Livewire;

use App\Models\Bookable;
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
        $this->bookables->find($bookableId)->delete();
        $this->render();
    }

    public function render()
    {
        $this->bookables = Bookable::all();
        return view('livewire.office-display-bookables');
    }
}
