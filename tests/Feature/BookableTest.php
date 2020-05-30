<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class BookableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_flight_booking()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create([
            'slug' => 'event-one',
        ]);

        Travel::to(now());

        $response = $this->post('office/events/event-one/bookables/flight', [
            'origin_airport_icao' => 'TJSJ',
            'destination_airport_icao' => 'TIST',
            'departure_time' => now()->toDateTimeString(),
            'arrival_time' => now()->addHours(2)->toDateTimeString(),
        ]);

        $this->assertDatabaseHas('bookables', [
            'event_id' => $event->id,
            'type' => 'flight',
            'booked_at' => null,
            'booked_by_id' => null,
            'data->origin_airport_icao' => 'TJSJ',
            'data->destination_airport_icao' => 'TIST',
            'data->departure_time' => now()->toDateTimeString(),
            'data->arrival_time' => now()->addHours(2)->toDateTimeString(),
        ]);

        $response->assertRedirect('office/events/event-one/bookables');

        Travel::back();
    }
}
