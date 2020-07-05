<?php

namespace Tests\Feature;

use App\Http\Livewire\AddBookableFlight;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class AddBookableFlightTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function is_shown_on_office_event_show_page()
    {
        $event = factory(Event::class)->create([
            'slug' => 'foo',
        ]);

        $this->get('office/events/foo')->assertSee('add-bookable-flight');
    }

    /** @test */
    public function can_create_a_flight()
    {
        $event = factory(Event::class)->create();

        Travel::to(now());
        Livewire::test(AddBookableFlight::class, ['event' => $event])
            ->set('callsign', 'FOO123')
            ->set('originAirportIcao', 'FOO1')
            ->set('destinationAirportIcao', 'BAR1')
            ->set('departureDate', $departureDate = now()->format('Y-m-d'))
            ->set('departureTime', $departureTime = now()->format('H:i:s'))
            ->set('arrivalDate', $arrivalDate = now()->format('Y-m-d'))
            ->set('arrivalTime', $arrivalTime = now()->addHour()->format('H:i:s'))
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('bookables', [
            'data->callsign' => 'FOO123',
            'data->origin_airport_icao' => 'FOO1',
            'data->destination_airport_icao' => 'BAR1',
            'data->departure_date' => $departureDate,
            'data->departure_time' => $departureTime,
            'data->arrival_date' => $arrivalDate,
            'data->arrival_time' => $arrivalTime,
        ]);

        Travel::back();
    }

    public function an_added_bookable_flight_should_be_coupled_with_event()
    {
        $this->assertTrue(false);
    }
}
