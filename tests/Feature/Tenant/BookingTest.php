<?php

namespace Tests\Feature\Tenant;

use Tests\TenantTestCase;
use App\Models\Tenants\Event;
use App\Models\Tenants\Pilot;
use App\Models\Tenants\Flight;
use Illuminate\Support\Facades\Mail;
use App\Services\Tenants\PilotService;
use App\Services\Tenants\BookingService;
use App\Mail\Tenants\Bookings\BookingConfirmedMailable;
use App\Mail\Tenants\Bookings\BookingRequestedMailable;
use App\Mail\Tenants\Bookings\CancellationRequestedMailable;

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
        $pilot = $this->pilotService->getByVatsimId('1234567');

        Mail::assertSent(BookingRequestedMailable::class, function ($mail) {
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
    
    public function testAPilotCannotRequestToBookAFlightThatIsAlreadyBooked()
    {
        $this->setUpAndActivateTenant();

        Mail::fake();
        $event = factory(Event::class)->create(['slug' => 'the-event']);
        $pilot = factory(Pilot::class)->create(['vatsim_id' => '1234567', 'email' => 'pilotemail@example.com']);
        $flight = factory(Flight::class)->create([
            'event_id' => $event->id,
            'pilot_id' => $pilot->id,
            'callsign' => 'ABC123',
        ]);

        // Execution Phase
        $response = $this->post('events/the-event/flights/ABC123/book', [
            'vatsim_id' => '7654321',
            'email' => 'canthaveit@example.com'
        ]);
        
        $flight = $flight->fresh();
        
        // Assertion Phase
        Mail::assertNothingSent();

        $response->assertRedirect('events/the-event/flights');
        $response->assertSessionHas('failure', 'The flight ABC123 is already booked.');
        $this->assertTrue($this->bookingService->isFlightBookedByPilot($flight, $pilot));
        $this->assertEquals('pilotemail@example.com', $flight->bookedBy->email);
    }

    public function testAPilotCanConfirmARequestToBookAFlight()
    {
        $this->setUpAndActivateTenant();

        Mail::fake();
        $event = factory(Event::class)->create(['slug' => 'the-event']);
        $flight = factory(Flight::class)->state('unbooked')->create(['event_id' => $event->id, 'callsign' => 'ABC123']);
        $pilot = factory(Pilot::class)->create(['vatsim_id' => '1234567', 'email' => 'pilotemail@example.com']);

        $confirmationUrl = $this->bookingService->getBookingConfirmationUrl(
            $event->slug,
            $flight->callsign,
            $pilot->vatsim_id
        );

        $response = $this->get($confirmationUrl);

        Mail::assertSent(BookingConfirmedMailable::class, function ($mail) {
            $this->assertEquals('You are booked for flight ABC123', $mail->subject);
            $this->assertEquals('pilotemail@example.com', $mail->to[0]['address']);
            $this->assertEquals('no-reply-tjzs@realops.test', $mail->from[0]['address']);
            $this->assertEquals('San Juan CERAP Real Ops', $mail->from[0]['name']);
            return true;
        });

        $response->assertRedirect('events/the-event/flights');
        $this->assertTrue($this->bookingService->isFlightBooked($flight));
    }

    public function testAPilotCannotConfirmARequestToBookAFlightWithoutASignature()
    {
        $this->setUpAndActivateTenant();

        $event = factory(Event::class)->create(['slug' => 'the-event']);
        $flight = factory(Flight::class)->state('unbooked')->create(['event_id' => $event->id, 'callsign' => 'ABC123']);
        $pilot = factory(Pilot::class)->create(['vatsim_id' => '1234567', 'email' => 'pilotemail@example.com']);

        $unsignedConfirmationUrl = route('tenants.events.flights.bookings.store', [
            'slug' => $event->slug,
            'callsign' => $flight->callsign,
            'vatsimId' => $pilot->vatsim_id,
        ]);

        $response = $this->get($unsignedConfirmationUrl);

        $response->assertRedirect('events/the-event/flights');
        $response->assertSessionHas('failure', 'The booking could not be confirmed due to a missing signature.');
        $this->assertFalse($this->bookingService->isFlightBooked($flight));
    }

    public function testAPilotCannotConfirmABookingRequestThatWasConfirmedByAnotherPilot()
    {
        $this->setUpAndActivateTenant();

        $event = factory(Event::class)->create(['slug' => 'the-event']);
        $pilotOne = factory(Pilot::class)->create(['vatsim_id' => '1111111', 'email' => 'pilotone@example.com']);
        $flight = factory(Flight::class)->create([
            'event_id' => $event->id,
            'pilot_id' => $pilotOne->id,
            'callsign' => 'ABC123'
        ]);
        $pilotTwo = factory(Pilot::class)->create(['vatsim_id' => '2222222', 'email' => 'pilottwo@example.com']);

        $confirmationUrlForPilotTwo = $this->bookingService->getBookingConfirmationUrl(
            $event->slug,
            $flight->callsign,
            $pilotTwo->vatsim_id
        );

        $response = $this->get($confirmationUrlForPilotTwo);
        
        $flight = $flight->fresh();

        $response->assertRedirect('events/the-event/flights');
        $response->assertSessionHas('failure',
            'The flight has already been booked and confirmed by another pilot, try booking another flight.');
        $this->assertEquals('1111111', $flight->bookedBy->vatsim_id);
    }

    public function testAPilotCanRequestToCancelABooking()
    {
        $this->setUpAndActivateTenant();

        Mail::fake();
        $event = factory(Event::class)->create(['slug' => 'the-event']);
        $pilot = factory(Pilot::class)->create(['vatsim_id' => '1234567', 'email' => 'pilotemail@example.com']);
        $flight = factory(Flight::class)->create(['event_id' => $event->id, 'pilot_id' => $pilot->id, 'callsign' => 'ABC123']);
        
        $response = $this->post('events/the-event/flights/ABC123/cancel', [
            'email' => 'pilotemail@example.com'
        ]);
        
        Mail::assertSent(CancellationRequestedMailable::class, function ($mail) {
            $this->assertEquals('Confirm your cancellation for flight ABC123', $mail->subject);
            $this->assertEquals('pilotemail@example.com', $mail->to[0]['address']);
            $this->assertEquals('no-reply-tjzs@realops.test', $mail->from[0]['address']);
            $this->assertEquals('San Juan CERAP Real Ops', $mail->from[0]['name']);
            return true;
        });

        $response->assertRedirect('events/the-event/flights');
        $response->assertSessionHas('success', 'If the provided e-mail address is correct, you will receive an e-mail to confirm the cancellation request.');
        $this->assertTrue($this->bookingService->isFlightBooked($flight));
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
