<?php

namespace Tests\Feature;

use App\Http\Livewire\AddBookableFlight;
use App\Models\BookableFlight;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class AddBookableFlightTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function is_shown_on_office_event_show_page()
    {
        factory(Event::class)->create([
            'slug' => 'foo',
        ]);

        $this->get('tenant/office/events/foo')->assertSee('add-bookable-flight');
    }

    /** @test */
    public function can_create_a_flight()
    {
        $event = factory(Event::class)->create();

        Travel::to(now());
        $addBookableFlightComponent = Livewire::test(AddBookableFlight::class, ['event' => $event])
            ->set('callsign', 'FOO123')
            ->set('originAirportIcao', 'FOO1')
            ->set('destinationAirportIcao', 'BAR1')
            ->set('departureDate', $departureDate = now()->format('Y-m-d'))
            ->set('departureTime', $departureTime = now()->format('H:i:s'))
            ->set('arrivalDate', $arrivalDate = now()->format('Y-m-d'))
            ->set('arrivalTime', $arrivalTime = now()->addHour()->format('H:i:s'))
            ->call('save');

        $addBookableFlightComponent->assertHasNoErrors();
        $addBookableFlightComponent->assertEmitted('bookableAdded');

        $this->assertDatabaseHas('bookables', [
            'event_id' => $event->id,
            'type' => BookableFlight::TYPE,
            'begin_date' => $departureDate,
            'begin_time' => $departureTime,
            'end_date' => $arrivalDate,
            'end_time' => $arrivalTime,
            'data->callsign' => 'FOO123',
            'data->origin_airport_icao' => 'FOO1',
            'data->destination_airport_icao' => 'BAR1',
        ]);

        Travel::back();
    }

    public function an_added_bookable_flight_should_be_coupled_with_event()
    {
        $this->assertTrue(false);
    }
}
