<?php

namespace Tests\Feature\Tenant;

use App\Mail\BookingForFlightRequested;
use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use App\Services\Tenants\BookingService;
use App\Services\Tenants\PilotService;
use Illuminate\Support\Facades\Mail;
use Tests\TenantTestCase;

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

    public function testAPilotCanBookAFlight()
    {
        $this->createTenant('tjzs', 'San Juan CERAP');

        Mail::fake();

        $event = factory(Event::class)->create([
            'slug' => 'the-event',
        ]);

        $flight = factory(Flight::class)->state('unbooked')->create([
            'event_id' => $event->id,
        ]);

        $this->assertCount(0, $this->pilotService->getAll());

        $response = $this->post($this->prepareTenantUrl('events/the-event/flights/ABC123/book'), [
            'vatsim_id' => '1234567',
            'email' => 'pilotemail@example.com'
        ]);

        $flight = $flight->fresh();
        $pilot = $this->pilotService->getByVatsimId('1234567');

        Mail::assertSent(BookingForFlightRequested::class, function($mail) use ($flight, $pilot) {
            return $mail->build() &&
                $mail->hasTo($pilot->email) &&
                $mail->hasFrom('no-reply-tjzs@realops.main', 'San Juan CERAP Real Ops');
        });

        $response->assertRedirect('events/the-event/flights/ABC123');
        $this->assertCount(1, $this->pilotService->getAll());
        $this->assertTrue($this->bookingService->isFlightBooked($event, $flight));
        $this->assertEquals('pilotemail@example.com', $pilot->email);
    }
}
