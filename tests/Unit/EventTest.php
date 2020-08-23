<?php

namespace Tests\Unit;

use App\Models\BookableFlight;
use App\Models\Booker;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_determine_if_someone_has_already_booked_something_for_this_event()
    {
        $event = factory(Event::class)->create();
        $booker = factory(Booker::class)->create();
        $bookable = factory(BookableFlight::class)->create([
            'event_id' => $event->id,
            'booked_by_id' => $booker->id,
            'booked_at' => now(),
        ]);

        $this->assertTrue($event->hasBookingFor($booker));
    }
}
