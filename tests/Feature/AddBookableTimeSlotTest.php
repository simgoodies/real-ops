<?php

namespace Tests\Feature;

use App\Http\Livewire\AddBookableTimeSlot;
use App\Models\BookableTimeSlot;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class AddBookableTimeSlotTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function it_can_add_time_slot_bookables()
    {
        Travel::to(now());

        $this->login();

        $event = factory(Event::class)->create([
            'slug' => 'time-slots',
            'bookable_type' => 'time-slot',
        ]);

        Livewire::test(AddBookableTimeSlot::class, ['event' => $event])
            ->set('direction', BookableTimeSlot::DIRECTION_INBOUND)
            ->set('assignation', 'FOO1')
            ->set('startDate', '2020-12-31')
            ->set('startTime', '23:45')
            ->set('availableBookables', 10)
            ->set('duration', BookableTimeSlot::DURATION_HOUR)
            ->call('save');

        $this->assertDatabaseCount('bookables', 10);
        $this->assertDatabaseHas('bookables', [
            'type' => BookableTimeSlot::TYPE,
            'begin_date' => '2020-12-31',
            'begin_time' => '23:45:00',
            'end_date' => '2021-01-01',
            'end_time' => '00:45:00',
            'data->assignation' => 'FOO1',
            'data->direction' => BookableTimeSlot::DIRECTION_INBOUND,
            'data->available_bookables' => 10,
        ]);

        Travel::back();
    }
}
