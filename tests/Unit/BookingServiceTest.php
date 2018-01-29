<?php

namespace Tests\Unit;

use App\Services\BookingService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\Flight;
use App\Models\Pilot;

class BookingServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var BookingService
     */
    protected $bookingService;

    protected function setUp()
    {
        parent::setUp(); //
        $this->bookingService = new BookingService();
    }

    /** @test */
    function a_flight_can_be_booked_for_a_pilot()
    {
        $pilot = factory(Pilot::class)->create();
        $flight = factory(Flight::class)->states('unbooked')->create();

        $bookingSuccessful = $this->bookingService->bookFlight($pilot, $flight);

        $this->assertTrue($bookingSuccessful);
        $this->assertCount(1, $pilot->bookings()->get());
    }

    /** @test */
    function a_booked_flight_cannot_be_associated_with_another_pilot()
    {
        $pilotOne = factory(Pilot::class)->create();
        $pilotTwo = factory(Pilot::class)->create();

        $onlyFlight = factory(Flight::class)->states('unbooked')->create();

        $pilotOneBookedOnlyFlight = $this->bookingService->bookFlight($pilotOne, $onlyFlight);

        $this->assertTrue($pilotOneBookedOnlyFlight);

        $pilotTwoFailedBookingOnlyFlight = $this->bookingService->bookFlight($pilotTwo, $onlyFlight);

        $this->assertFalse($pilotTwoFailedBookingOnlyFlight);
    }
}
