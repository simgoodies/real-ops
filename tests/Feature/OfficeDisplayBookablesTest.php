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
    public function show_all_bookables()
    {
        $event = factory(Event::class)->create();
        $flights = factory(BookableFlight::class, 3)->create([
            'event_id' => $event->id,
        ]);

        $officeDisplayBookablesComponent = Livewire::test('office-display-bookables', ['event' => $event]);

        $bookables = $officeDisplayBookablesComponent->viewData('bookables');

        $flights->assertEquals($bookables);
    }

    /** @test */
    public function a_bookable_can_be_deleted()
    {
        $event = factory(Event::class)->create();
        $flight = factory(BookableFlight::class)->create([
            'event_id' => $event->id,
            'data->callsign' => 'DELETE'
        ]);

        Livewire::test('office-display-bookables', ['event' => $event])
            ->call('deleteBookable', $flight->id);

        $this->assertDatabaseMissing('bookables', [
            'data->callsign' => 'DELETE',
        ]);
    }

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

    /** @test */
    public function show_all_time_slot_bookables()
    {
        $event = factory(Event::class)->create(['bookable_type' => BookableTimeSlot::TYPE]);
        $timeSlotOne = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
        ]);
        $timeSlotTwo = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '02:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '03:00:00',
        ]);

        $officeDisplayBookablesComponent = Livewire::test('office-display-bookables', ['event' => $event]);

        $expectedBookables = collect([
            BookableTimeSlot::where('begin_date', '2020-12-15')->where('begin_time', '01:00:00')->first(),
            BookableTimeSlot::where('begin_date', '2020-12-15')->where('begin_time', '02:00:00')->first(),
        ]);
        $bookables = $officeDisplayBookablesComponent->viewData('bookables');

        $this->assertCount(2, $bookables);
        $this->assertDatabaseCount('bookables', 10);
        $expectedBookables->assertEquals($bookables);
    }
}
