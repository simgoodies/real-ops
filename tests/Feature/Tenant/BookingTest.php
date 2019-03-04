<?php

namespace Tests\Feature\Tenant;

use Tests\TenantTestCase;
use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use App\Models\Tenants\Pilot;
use App\Services\Tenants\BookingService;
use App\Services\Tenants\PilotService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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
        $flight = $flight->fresh();
        $pilot = $this->pilotService->getByVatsimId('1234567');

        Mail::assertSent(BookingForFlightRequested::class, function($mail) {
            return $mail->build() &&
                $mail->hasTo('pilotemail@example.com') &&
                $mail->hasFrom('no-reply-tjzs@realops.main', 'San Juan CERAP Real Ops');
        });

        $response->assertRedirect('events/the-event/flights/ABC123');
        $this->assertCount(1, $this->pilotService->getAll());
        $this->assertFalse($this->bookingService->isFlightBooked($event, $flight));
        $this->assertEquals('pilotemail@example.com', $pilot->email);
    }

    public function testAPilotCanConfirmARequestToBooking()
    {
        $this->withoutExceptionHandling();
        $this->createTenant();

        $hostname = app(Environment::class)->hostname();
        // Setup Phase
        $event = factory(Event::class)->create(['slug' => 'the-event']);
        $flight = factory(Flight::class)->state('unbooked')->create(['event_id' => $event->id, 'callsign' => 'ABC123']);
        $pilot = factory(Pilot::class)->create(['vatsim_id' => '1234567']);

        $url = $this->bookingService->getBookingConfirmationUrl($event->slug, $flight->callsign, $pilot->vatsim_id);

        // Execution Phase
        $response = $this->get($this->prepareTenantUrl('events/the-event/flights/ABC123/book/1234567'));
        dd();
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
