<?php

namespace Tests\Feature\Tenants\Office;

use Carbon\Carbon;
use Tests\TenantTestCase;
use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use App\Services\Tenants\FlightService;
use App\Services\Tenants\AirportService;

class FlightTest extends TenantTestCase
{
    /**
     * @var FlightService
     */
    protected $flightService;

    /**
     * @var AirportService
     */
    protected $airportService;

    protected function setUp()
    {
        parent::setUp();

        $this->flightService = $this->app->make(FlightService::class);
        $this->airportService = $this->app->make(AirportService::class);
    }

    public function testItCanCreateAFlight()
    {
        $this->setUpAndActivateTenant();
        $this->withDummyAirports();
        $this->loggedInAdminUser();

        $event = factory(Event::class)->create([
            'slug' => 'event-one'
        ]);

        $flights = $this->flightService->getAllForEvent($event);
        $this->assertCount(0, $flights);

        $response = $this->post('office/events/event-one/flights', [
            'event_id' => $event->id,
            'callsign' => 'ABC123',
            'origin_airport_icao' => 'TJSJ',
            'destination_airport_icao' => 'TNCM',
            'departure_time' => Carbon::now()->toTimeString(),
            'arrival_time' => Carbon::now()->addHours(2)->toTimeString(),
            'route' => 'ABCDE1 ABC ABC ABC ABCDE2',
            'aircraft_type_icao' => 'B734'
        ]);

        $flights = $this->flightService->getAllForEvent($event->fresh());

        $this->assertCount(1, $flights);
        $response->assertRedirect('office/events/event-one/flights');
    }

    public function testItCanDeleteAFlight()
    {
        $this->setUpAndActivateTenant();
        $this->loggedInAdminUser();

        $event = factory(Event::class)->create([
            'slug' => 'the-event'
        ]);

        $this->assertCount(0, $this->flightService->getAllForEvent($event));

        factory(Flight::class)->create([
            'event_id' => $event->id,
            'callsign' => 'ABC123'
        ]);

        $this->assertCount(1, $this->flightService->getAllForEvent($event->fresh()));

        $response = $this->delete('office/events/the-event/flights/ABC123');

        $response->assertRedirect('office/events/the-event/flights');
        $this->assertCount(0, $this->flightService->getAllForEvent($event->fresh()));
    }

    public function testItCanUpdateAFlight()
    {
        $this->setUpAndActivateTenant();
        $this->withDummyAirports();
        $this->loggedInAdminUser();

        $event = factory(Event::class)->create([
            'slug' => 'event-one'
        ]);

        $flight = factory(Flight::class)->create([
            'event_id' => $event->id,
            'callsign' => 'ABC123',
            'origin_airport_id' => $this->airportService->getByIcao('TJSJ')->id,
            'destination_airport_id' => $this->airportService->getByIcao('TNCM')->id,
            'departure_time' => '14:00:00',
            'arrival_time' => '16:00:00',
            'route' => 'QWER QEWR QERT',
            'aircraft_type_icao' => 'B787'
        ]);

        $this->assertCount(1, $this->flightService->getAllForEvent($event->fresh()));

        $response = $this->patch('office/events/event-one/flights/ABC123', [
            'event_id' => $event->id,
            'origin_airport_icao' => 'TNCM',
            'destination_airport_icao' => 'TTPP',
            'departure_time' => '15:00:00',
            'arrival_time' => '17:00:00',
            'route' => 'TROLI5 NOT TROLLING5',
            'aircraft_type_icao' => 'B734'
        ]);

        $flight = $flight->fresh();

        $this->assertEquals('TNCM', $flight->originAirport->icao);
        $this->assertEquals('TTPP', $flight->destinationAirport->icao);
        $this->assertEquals('15:00:00', $flight->departure_time);
        $this->assertEquals('17:00:00', $flight->arrival_time);
        $this->assertEquals('TROLI5 NOT TROLLING5', $flight->route);
        $this->assertEquals('B734', $flight->aircraft_type_icao);
        $response->assertRedirect('office/events/event-one/flights');
    }

    public function testItCanAddTheSameCallsignForTwoDifferentEvents()
    {
        $this->setUpAndActivateTenant();
        $this->withDummyAirports();
        $this->loggedInAdminUser();

        $eventOne = factory(Event::class)->create(['slug' => 'event-one']);
        $eventTwo = factory(Event::class)->create(['slug' => 'event-two']);

        $this->post('office/events/event-one/flights', [
            'event_id' => $eventOne->id,
            'callsign' => 'ABC123',
            'origin_airport_icao' => 'TJSJ',
            'destination_airport_icao' => 'TNCM',
            'departure_time' => '10:00:00',
            'arrival_time' => '11:00:00',
            'route' => 'I WANT TO IDENTIFY FLIGHT ONE'
        ]);

        $this->post('office/events/event-two/flights', [
            'event_id' => $eventTwo->id,
            'callsign' => 'ABC123',
            'origin_airport_icao' => 'TJSJ',
            'destination_airport_icao' => 'TNCM',
            'departure_time' => '10:00:00',
            'arrival_time' => '11:00:00',
            'route' => 'I WANT TO IDENTIFY FLIGHT TWO'
        ]);

        $flightsInEventOne = $this->flightService->getAllForEvent($eventOne);
        $flightsInEventTwo = $this->flightService->getAllForEvent($eventTwo);

        $this->assertCount(1, $flightsInEventOne);
        $this->assertCount(1, $flightsInEventTwo);
        $this->assertEquals('I WANT TO IDENTIFY FLIGHT ONE', $flightsInEventOne[0]->route);
        $this->assertEquals('I WANT TO IDENTIFY FLIGHT TWO', $flightsInEventTwo[0]->route);
    }

    public function testItCannotAddTheSameCallsignWithinSameEvent()
    {
        $this->setUpAndActivateTenant();
        $this->withDummyAirports();
        $this->loggedInAdminUser();

        $event = factory(Event::class)->create(['slug' => 'event-one']);

        $responseOne = $this->post('office/events/event-one/flights', [
            'event_id' => $event->id,
            'callsign' => 'ABC123',
            'origin_airport_icao' => 'TJSJ',
            'destination_airport_icao' => 'TNCM',
            'departure_time' => '10:00:00',
            'arrival_time' => '11:00:00',
            'route' => 'I WANT TO IDENTIFY FLIGHT ONE'
        ]);
        $responseOne->assertSessionHasNoErrors();

        $responseTwo = $this->post('office/events/event-one/flights', [
            'event_id' => $event->id,
            'callsign' => 'ABC123',
            'origin_airport_icao' => 'AAAA',
            'destination_airport_icao' => 'BBBB',
            'departure_time' => '10:00:00',
            'arrival_time' => '11:00:00',
            'route' => 'I WANT TO IDENTIFY FLIGHT ONE'
        ]);
        $responseTwo->assertSessionHasErrors('callsign');


        $flights = $this->flightService->getAllForEvent($event);

        $this->assertCount(1, $flights);
    }
}
