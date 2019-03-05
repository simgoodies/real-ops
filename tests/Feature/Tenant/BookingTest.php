<?php

namespace Tests\Feature\Tenant;

use Tests\TenantTestCase;
use App\Models\Tenants\Event;
use App\Models\Tenants\Pilot;
use App\Models\Tenants\Flight;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Services\Tenants\PilotService;
use App\Services\Tenants\BookingService;
use App\Mail\Tenants\Bookings\ConfirmedMailable;
use App\Mail\Tenants\Bookings\RequestedMailable;

class BookingTest extends TenantTestCase
{
    /**
     * @var BookingService
     */
    protected $bookingService;

    /**
     * @var PilotService
     */
    protected $pilotService;

    protected function setUp()
    {
        parent::setUp();

        $this->bookingService = new BookingService();
        $this->pilotService = new PilotService();
    }

    public function testAPilotCanRequestToBookAFlight()
    {
        $this->withoutExceptionHandling();
        $this->setUpAndActivateTenant();

        Mail::fake();
        $event = factory(Event::class)->create(['slug' => 'the-event']);
        $flight = factory(Flight::class)->state('unbooked')->create(['event_id' => $event->id, 'callsign' => 'ABC123']);

        $this->assertCount(0, $this->pilotService->getAll());

        // Execution Phase
        $response = $this->post('events/the-event/flights/ABC123/book', [
            'vatsim_id' => '1234567',
            'email' => 'pilotemail@example.com'
        ]);

        // Assertion Phase
        $flight = $flight->fresh();
        $pilot = $this->pilotService->getByVatsimId('1234567');

        Mail::assertSent(RequestedMailable::class, function ($mail) {
            $this->assertEquals('Confirm your requested flight ABC123', $mail->subject);
            $this->assertEquals('pilotemail@example.com', $mail->to[0]['address']);
            $this->assertEquals('no-reply-tjzs@realops.test', $mail->from[0]['address']);
            $this->assertEquals('San Juan CERAP Real Ops', $mail->from[0]['name']);
            return true;
        });

        $response->assertRedirect('events/the-event/flights');
        $this->assertCount(1, $this->pilotService->getAll());
        $this->assertFalse($this->bookingService->isFlightBooked($flight));
        $this->assertEquals('pilotemail@example.com', $pilot->email);
    }

    public function testAPilotCanConfirmARequestToBookAFlight()
    {
        $this->withoutExceptionHandling();
        $this->setUpAndActivateTenant();

        Mail::fake();
        $event = factory(Event::class)->create(['slug' => 'the-event']);
        $flight = factory(Flight::class)->state('unbooked')->create(['event_id' => $event->id, 'callsign' => 'ABC123']);
        $pilot = factory(Pilot::class)->create(['vatsim_id' => '1234567', 'email' => 'pilotemail@example.com']);

        $confirmationUrl = URL::signedRoute('tenants.events.bookings.store', [
            'slug' => $event->slug,
            'callsign' => $flight->callsign,
            'vatsimId' => $pilot->vatsim_id,
        ]);

        $response = $this->get($confirmationUrl);

        Mail::assertSent(ConfirmedMailable::class, function ($mail) {
            $this->assertEquals('You are booked for flight ABC123', $mail->subject);
            $this->assertEquals('pilotemail@example.com', $mail->to[0]['address']);
            $this->assertEquals('no-reply-tjzs@realops.test', $mail->from[0]['address']);
            $this->assertEquals('San Juan CERAP Real Ops', $mail->from[0]['name']);
            return true;
        });

        $response->assertRedirect('events/the-event/flights');
        $this->assertTrue($this->bookingService->isFlightBooked($flight));
    }

    public function testAPilotCannotConfirmABookingRequestThatWasConfirmedByAnotherPilot()
    {

    }

    public function testAPilotCanRequestToCancelABooking()
    {
        $this->assertTrue(true);
    }

    public function testAPilotCanConfirmARequestToCancelABooking()
    {
        $this->assertTrue(true);
    }

    public function testAPilotCanOnlyCancelTheirOwnBooking()
    {
        $this->assertTrue(true);
    }
}
