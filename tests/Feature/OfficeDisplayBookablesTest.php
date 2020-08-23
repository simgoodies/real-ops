<?php

namespace Tests\Feature;

use App\Models\BookableFlight;
use App\Models\BookableTimeSlot;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class OfficeDisplayBookablesTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function only_bookables_for_a_specific_event_is_shown()
    {
        $eventOne = factory(Event::class)->create();
        $eventOneFlights = factory(BookableFlight::class, 3)->create([
            'event_id' => $eventOne->id,
        ]);
        $eventTwo = factory(Event::class)->create();
        $eventTwoFlights = factory(BookableFlight::class, 4)->create([
            'event_id' => $eventTwo->id,
        ]);

        $officeDisplayBookablesComponent = Livewire::test('office-display-bookables', ['event' => $eventOne]);

        $bookables = $officeDisplayBookablesComponent->viewData('bookables');

        $this->assertCount(3, $bookables);
        $eventOneFlights->assertEquals($bookables);
    }
}
