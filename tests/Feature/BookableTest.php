<?php

namespace Tests\Feature;

use App\Models\BookableFlight;
use App\Models\Booker;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class BookableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_confirm_a_booking_request()
    {
        Travel::to(now());

        /** @var Event $event */
        $event = factory(Event::class)->create(['slug' => 'foo-bar']);

        /** @var Booker $booker */
        $booker = factory(Booker::class)->create();

        /** @var BookableFlight $bookableFlight */
        $bookableFlight = factory(BookableFlight::class)->create(['event_id' => $event]);

        $this->get($bookableFlight->getConfirmationUrl($booker))->assertRedirect('events/foo-bar')->assertSessionHas([
            'booking-confirmed' => "You're booking is confirmed!",
        ]);

        $this->assertDatabaseHas('bookables', [
            'id' => $bookableFlight->id,
            'booked_by_id' => $booker->id,
            'booked_at' => now()->format('Y-m-d H:i:s'),
        ]);

        Travel::back();
    }

    /** @test */
    public function it_cannot_confirm_with_wrong_signature()
    {
        $this->assertTrue(false);
    }

    /** @test */
    public function it_cannot_confirm_if_already_confirmed_by_other()
    {
        $this->assertTrue(false);
    }
}
