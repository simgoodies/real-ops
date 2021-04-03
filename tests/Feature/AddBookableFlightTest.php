<?php

namespace Tests\Feature;

use App\Http\Livewire\AddBookableFlight;
use App\Models\BookableFlight;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->login();

        factory(Event::class)->create([
            'slug' => 'foo',
        ]);

        $this->get('office/events/foo')->assertSee('add-bookable-flight');
    }

    /** @test */
    public function can_create_a_flight()
    {
        $this->login();

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

    /** @test */
    public function a_flight_bookable_dates_is_prefilled_with_event_date()
    {
        $this->login();

        Travel::to(now());

        $event = factory(Event::class)->create([
            'start_date' => $startDate = now()->format('Y-m-d'),
        ]);

        Livewire::test(AddBookableFlight::class, ['event' => $event])
            ->assertSet('departureDate', $startDate)
            ->assertSet('arrivalDate', $startDate);

        Travel::back();
    }
}
