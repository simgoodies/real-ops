<?php

namespace App\Http\Livewire;

use App\Imports\BookableFlightsImport;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class BookableFlightImport extends Component
{
    use WithFileUploads;

    public $file;
    public $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }


    public function import()
    {
        $this->validate([
            'file' => 'file|max:5120|mimes:csv,txt'
        ]);

        Excel::import(new BookableFlightsImport($this->event), $this->file);
    }

    public function render()
    {
        return view('livewire.bookable-flight-import');
    }
}
