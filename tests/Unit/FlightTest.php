<?php

namespace Tests\Unit;

use App\Models\Flight;
use App\Services\BookingService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FlightTest extends TestCase
{
    use DatabaseMigrations;

    protected $bookingService;

    protected function setUp()
    {
        parent::setUp();
        $this->bookingService = new BookingService();
    }

    /** @test */
    function can_see_if_a_flight_is_booked()
    {
        /** @var Flight $flight */
        $flight = factory('App\Models\Flight')->states('unbooked')->create();
        $pilot = factory('App\Models\Pilot')->create();

        $this->assertFalse($flight->isBooked());

        $this->bookingService->bookFlight($pilot, $flight);

        $this->assertTrue($flight->isBooked());
    }
}
