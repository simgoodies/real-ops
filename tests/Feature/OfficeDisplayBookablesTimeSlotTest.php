<?php

namespace Tests\Feature;

use App\Models\BookableFlight;
use App\Models\BookableTimeSlot;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class OfficeDisplayBookablesTimeSlotTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function a_bookable_can_be_deleted()
    {
        $this->assertTrue(false);
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

    /** @test */
    public function it_shows_time_slots_grouped_by_the_assignation()
    {
        $event = factory(Event::class)->create(['bookable_type' => BookableTimeSlot::TYPE]);
        $timeSlotOne = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'assignation' => 'FOO1',
                'direction' => BookableTimeSlot::DIRECTION_ANY,
            ],
        ]);
        $timeSlotTwo = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'assignation' => 'FOO2',
                'direction' => BookableTimeSlot::DIRECTION_ANY,
            ],
        ]);

        $officeDisplayBookablesComponent = Livewire::test('office-display-bookables', ['event' => $event]);

        $expectedBookables = collect([
            BookableTimeSlot::where('data->assignation', 'FOO1')->first(),
            BookableTimeSlot::where('data->assignation', 'FOO2')->first(),
        ]);
        $bookables = $officeDisplayBookablesComponent->viewData('bookables');

        $this->assertCount(2, $bookables);
        $this->assertDatabaseCount('bookables', 10);
        $expectedBookables->assertEquals($bookables);
    }

    /** @test */
    public function it_shows_time_slots_grouped_by_the_direction()
    {
        $event = factory(Event::class)->create(['bookable_type' => BookableTimeSlot::TYPE]);
        $timeSlotOne = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'direction' => BookableTimeSlot::DIRECTION_INBOUND,
            ],
        ]);
        $timeSlotTwo = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'direction' => BookableTimeSlot::DIRECTION_OUTBOUND,
            ],
        ]);

        $officeDisplayBookablesComponent = Livewire::test('office-display-bookables', ['event' => $event]);

        $expectedBookables = collect([
            BookableTimeSlot::where('data->direction', BookableTimeSlot::DIRECTION_INBOUND)->first(),
            BookableTimeSlot::where('data->direction', BookableTimeSlot::DIRECTION_OUTBOUND)->first(),
        ]);
        $bookables = $officeDisplayBookablesComponent->viewData('bookables');

        $this->assertCount(2, $bookables);
        $this->assertDatabaseCount('bookables', 10);
        $expectedBookables->assertEquals($bookables);
    }
}
