<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmedMailable;
use App\Models\BookableFlight;
use App\Models\BookableTimeSlot;
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
        Mail::fake();
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
        Mail::fake();
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

    /** @test */
    public function it_can_confirm_a_booking_request_for_time_slot()
    {
        Travel::to(now());

        Mail::fake();

        $event = factory(Event::class)->create([
            'title' => 'Foo Bar Event',
            'slug' => 'foo-bar-event',
        ]);

        $booker = factory(Booker::class)->create([
            'email' => 'foo@example.org',
        ]);

        $timeSlot = factory(BookableTimeSlot::class, 5)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'assignation' => 'FOO1',
                'direction' => BookableTimeSlot::DIRECTION_ANY,
            ],
        ]);

        $timeSlotBookableOne = $timeSlot[0];

        $this->get($timeSlotBookableOne->getConfirmationUrl($booker))->assertRedirect('events/foo-bar-event')->assertSessionHas([
            'booking-confirmed' => "You're booking is confirmed! Check your e-mail for details.",
        ]);

        $this->assertDatabaseHas('bookables', [
            'id' => $timeSlotBookableOne->id,
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
    public function it_cannot_confirm_if_time_slot_is_full()
    {
        Mail::fake();
        $event = factory(Event::class)->create(['slug' => 'foo-bar']);
        $bookerOne = factory(Booker::class)->create();
        $bookerTwo = factory(Booker::class)->create();
        $bookerThree = factory(Booker::class)->create();
        $timeSlot = factory(BookableTimeSlot::class, 2)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'assignation' => 'FOO1',
                'direction' => BookableTimeSlot::DIRECTION_ANY,
            ],
        ]);

        $timeSlotBookableOne = $timeSlot[0];
        $timeSlotBookableOne->booked_by_id = $bookerOne->id;
        $timeSlotBookableOne->booked_at = now();
        $timeSlotBookableOne->save();

        $timeSlotBookableTwo = $timeSlot[1];
        $timeSlotBookableTwo->booked_by_id = $bookerTwo->id;
        $timeSlotBookableTwo->booked_at = now();
        $timeSlotBookableTwo->save();

        $confirmationUrl = $timeSlotBookableOne->getConfirmationUrl($bookerThree);

        $this->get($confirmationUrl)
            ->assertRedirect('events/foo-bar')
            ->assertSessionHas('booking-confirmation-failed', 'This time slot is now full! Try an alternative.');

        $this->assertDatabaseMissing('bookables', [
            'id' => $timeSlotBookableOne->id,
            'booked_by_id' => $bookerThree->id,
        ]);

        $this->assertDatabaseHas('bookables', [
            'id' => $timeSlotBookableOne->id,
            'booked_by_id' => $bookerOne->id,
        ]);

        $this->assertDatabaseHas('bookables', [
            'id' => $timeSlotBookableTwo->id,
            'booked_by_id' => $bookerTwo->id,
        ]);
    }

    /** @test */
    public function it_confirms_only_available_bookings_for_time_slots()
    {
        Mail::fake();
        $event = factory(Event::class)->create(['slug' => 'foo-bar']);
        $bookerOne = factory(Booker::class)->create();
        $bookerTwo = factory(Booker::class)->create();
        $timeSlot = factory(BookableTimeSlot::class, 2)->create([
            'event_id' => $event->id,
            'begin_date' => '2020-12-15',
            'begin_time' => '01:00:00',
            'end_date' => '2020-12-15',
            'end_time' => '02:00:00',
            'data' => [
                'assignation' => 'FOO1',
                'direction' => BookableTimeSlot::DIRECTION_ANY,
            ],
        ]);

        $timeSlotBookableOne = $timeSlot[0];
        $timeSlotBookableTwo = $timeSlot[1];

        $timeSlotBookableOne->booked_by_id = $bookerOne->id;
        $timeSlotBookableOne->booked_at = now();
        $timeSlotBookableOne->save();

        $confirmationUrl = $timeSlotBookableOne->getConfirmationUrl($bookerTwo);

        $this->get($confirmationUrl)
            ->assertRedirect('events/foo-bar')
            ->assertSessionHas('booking-confirmed', "You're booking is confirmed! Check your e-mail for details.");

        $this->assertDatabaseHas('bookables', [
            'id' => $timeSlotBookableOne->id,
            'booked_by_id' => $bookerOne->id,
        ]);

        $this->assertDatabaseHas('bookables', [
            'id' => $timeSlotBookableTwo->id,
            'booked_by_id' => $bookerTwo->id,
        ]);
    }
}
