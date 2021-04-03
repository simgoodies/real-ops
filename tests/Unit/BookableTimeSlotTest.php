<?php

namespace Tests\Unit;

use App\Models\BookableTimeSlot;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookableTimeSlotTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function it_counts_related_time_slots_total_bookables()
    {
        $this->login();

        $event = factory(Event::class)->create();
        $timeSlotOneA = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'direction' => BookableTimeSlot::DIRECTION_OUTBOUND,
                'assignation' => 'FOO1',
            ],
        ]);
        $timeSlotOneB = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'direction' => BookableTimeSlot::DIRECTION_OUTBOUND,
                'assignation' => 'FOO1',
            ],
        ]);
        $timeSlotTwoA = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'direction' => BookableTimeSlot::DIRECTION_OUTBOUND,
            ],
        ]);

        $this->assertEquals(10, $timeSlotOneA->first()->available_bookables);
        $this->assertEquals(10, $timeSlotOneB->first()->available_bookables);
        $this->assertEquals(5, $timeSlotTwoA->first()->available_bookables);
    }

    /** @test */
    public function it_counts_remaining_unbooked_for_time_slot()
    {
        $event = factory(Event::class)->create();
        $timeSlotOneA = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'direction' => BookableTimeSlot::DIRECTION_OUTBOUND,
                'assignation' => 'FOO1',
            ],
        ]);
        $timeSlotOneB = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'direction' => BookableTimeSlot::DIRECTION_OUTBOUND,
                'assignation' => 'FOO2',
            ],
        ]);

        $timeSlotOneABookable = $timeSlotOneA->first();
        $timeSlotOneABookable->booked_at = now();
        $timeSlotOneABookable->save();

        $this->assertEquals(4, $timeSlotOneABookable->non_booked_bookables);
    }

    /** @test */
    public function it_can_determine_previously_used_assignations()
    {
        $event = factory(Event::class)->create();
        $timeSlotOne = factory(BookableTimeSlot::class)->create([
            'event_id' => $event->id,
            'data' => [
                'assignation' => 'FOO1',
            ],
        ]);
        $timeSlotTwo = factory(BookableTimeSlot::class)->create([
            'event_id' => $event->id,
            'data' => [
                'assignation' => 'BAR1',
            ],
        ]);
        $timeSlotThree = factory(BookableTimeSlot::class)->create([
            'event_id' => $event->id,
            'data' => [
                'assignation' => 'BAR1',
            ],
        ]);
        $timeSlotFour = factory(BookableTimeSlot::class)->create([
            'event_id' => $event->id,
            'data' => [
                'assignation' => null,
            ],
        ]);

        $assignations = BookableTimeSlot::getPreviouslyUsedAssignations($event);

        $this->assertEquals(['FOO1', 'BAR1'], $assignations->toArray());
    }

    /** @test */
    public function it_can_get_the_next_available_time_slot_booking()
    {
        $event = factory(Event::class)->create();
        $timeSlotOneA = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'direction' => BookableTimeSlot::DIRECTION_OUTBOUND,
                'assignation' => 'FOO1',
            ],
        ]);

        $timeSlotOneABookable = $timeSlotOneA->first();
        $timeSlotOneA->booked_by_id = 1;
        $timeSlotOneABookable->booked_at = now();
        $timeSlotOneABookable->save();

        $this->assertTrue($timeSlotOneA->first()->getNextAvailableBooking()->is($timeSlotOneA[1]));
    }
}
