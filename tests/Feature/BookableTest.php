<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmedMailable;
use App\Models\BookableFlight;
use App\Models\Booker;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class BookableTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function it_can_confirm_a_booking_request()
    {
        Travel::to(now());

        Mail::fake();

        /** @var Event $event */
        $event = factory(Event::class)->create([
            'title' => 'Foo Bar Event',
            'slug' => 'foo-bar-event',
        ]);

        /** @var Booker $booker */
        $booker = factory(Booker::class)->create([
            'email' => 'foo@example.org',
        ]);

        /** @var BookableFlight $bookableFlight */
        $bookableFlight = factory(BookableFlight::class)->create(['event_id' => $event]);

        $this->get($bookableFlight->getConfirmationUrl($booker))->assertRedirect('events/foo-bar-event')->assertSessionHas([
            'booking-confirmed' => "You're booking is confirmed! Check your e-mail for details.",
        ]);

        $this->assertDatabaseHas('bookables', [
            'id' => $bookableFlight->id,
            'booked_by_id' => $booker->id,
            'booked_at' => now()->format('Y-m-d H:i:s'),
        ]);

        Mail::assertSent(BookingConfirmedMailable::class, function ($mail) {
            $this->assertEquals('Your booking was confirmed!', $mail->subject);
            $this->assertEquals('foo@example.org', $mail->to[0]['address']);
            $this->assertEquals('info@realops.test', $mail->from[0]['address']);
            $this->assertEquals('Foo Bar Event', $mail->from[0]['name']);
            return true;
        });

        Travel::back();
    }

    /** @test */
    public function it_cannot_confirm_with_wrong_signature()
    {
        /** @var Event $event */
        $event = factory(Event::class)->create(['slug' => 'foo-bar']);

        /** @var Booker $booker */
        $booker = factory(Booker::class)->create();

        /** @var BookableFlight $bookableFlight */
        $bookableFlight = factory(BookableFlight::class)->create(['event_id' => $event]);

        $confirmationUrl = $bookableFlight->getConfirmationUrl($booker);
        $confirmationUrlWithoutSignature = Str::before($confirmationUrl, '?signature');

        $this->get($confirmationUrlWithoutSignature)->assertRedirect('events/foo-bar')->assertSessionHas([
            'booking-confirmation-failed' => "Something went wrong... Try again.",
        ]);

        $this->assertDatabaseMissing('bookables', [
            'id' => $bookableFlight->id,
            'booked_by_id' => $booker->id,
        ]);
    }

    /** @test */
    public function it_cannot_confirm_if_already_confirmed_by_other()
    {
        /** @var Event $event */
        $event = factory(Event::class)->create(['slug' => 'foo-bar']);

        /** @var Booker $bookerOne */
        $bookerOne = factory(Booker::class)->create();

        /** @var Booker $bookerTwo */
        $bookerTwo = factory(Booker::class)->create();

        /** @var BookableFlight $bookableFlight */
        $bookableFlight = factory(BookableFlight::class)->create([
            'event_id' => $event,
            'booked_by_id' => $bookerOne,
        ]);

        $confirmationUrl = $bookableFlight->getConfirmationUrl($bookerTwo);

        $this->get($confirmationUrl)
            ->assertRedirect('events/foo-bar')
            ->assertSessionHas('booking-confirmation-failed', 'This booking was confirmed by someone else! Try an alternative.');

        $this->assertDatabaseMissing('bookables', [
            'id' => $bookableFlight->id,
            'booked_by_id' => $bookerTwo->id,
        ]);

        $this->assertDatabaseHas('bookables', [
            'id' => $bookableFlight->id,
            'booked_by_id' => $bookerOne->id,
        ]);
    }
}
