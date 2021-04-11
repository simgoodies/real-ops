<?php

namespace Tests\Feature;

use App\Mail\BookingRequestedMailable;
use App\Models\BookableTimeSlot;
use App\Models\Booker;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class DisplayBookablesTimeSlotTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function it_does_not_immediately_book()
    {
        Mail::fake();
        Travel::to(now());

        $event = factory(Event::class)->create([
            'slug' => 'foo-event',
        ]);
        $timeSlot = factory(BookableTimeSlot::class, 2)->create([
            'event_id' => $event->id,
        ]);
        $booker = factory(Booker::class)->create([
            'email' => 'foo@example.org',
        ]);

        $firstBookable = $timeSlot->first();

        Livewire::test('display-bookables', ['event' => $event])
            ->set('email', $booker->email)
            ->call('bookBookable', $firstBookable->id);

        $this->assertTrue($firstBookable->is($firstBookable->getNextAvailableBooking()));
        $this->assertDatabaseMissing('bookables', [
            'id' => $firstBookable->id,
            'event_id' => $event->id,
            'booked_by_id' => $booker->id,
            'booked_at' => now()->format('Y-m-d H:i:s'),
        ]);

        Travel::back();
    }

    /** @test */
    public function it_wont_book_for_time_slots_that_have_no_more_spots()
    {
        Travel::to(now());
        Mail::fake();

        $event = factory(Event::class)->create([
            'slug' => 'foo-event',
        ]);
        $bookerOne = factory(Booker::class)->create([
            'email' => 'foo@example.org',
        ]);
        $bookerTwo = factory(Booker::class)->create([
            'email' => 'bar@example.org',
        ]);
        $timeSlot = factory(BookableTimeSlot::class, 2)->create([
            'event_id' => $event->id,
            'booked_at' => now(),
            'booked_by_id' => $bookerOne->id,
        ]);

        $firstBookable = $timeSlot->first();

        Livewire::test('display-bookables', ['event' => $event])
            ->set('email', $bookerTwo->email)
            ->call('bookBookable', $firstBookable->id);

        Mail::assertNothingSent();

        $this->assertDatabaseHas('bookables', [
            'id' => $firstBookable->id,
            'event_id' => $event->id,
            'booked_by_id' => $bookerOne->id,
            'booked_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseMissing('bookables', [
            'event_id' => $event->id,
            'booked_by_id' => $bookerTwo->id,
        ]);

        Travel::back();
    }

    /** @test */
    public function it_sends_a_confirmation_mail_to_booker()
    {
        Mail::fake();
        $event = factory(Event::class)->create([
            'title' => 'Foo Bar Event'
        ]);
        $timeslotBookable = factory(BookableTimeSlot::class)->create(['event_id' => $event->id]);

        Livewire::test('display-bookables', ['event' => $event])
            ->set('email', 'foo@example.org')
            ->call('bookBookable', $timeslotBookable->id);

        Mail::assertSent(BookingRequestedMailable::class, function ($mail) {
            $this->assertEquals('Confirm your requested booking', $mail->subject);
            $this->assertEquals('foo@example.org', $mail->to[0]['address']);
            $this->assertEquals('info@realops.test', $mail->from[0]['address']);
            $this->assertEquals('Foo Bar Event', $mail->from[0]['name']);
            return true;
        });
    }

    /** @test */
    public function it_wont_book_for_someone_that_already_has_a_time_slot_for_current_event()
    {
        Travel::to(now());
        Mail::fake();

        $event = factory(Event::class)->create([
            'slug' => 'foo-event',
        ]);
        $bookerOne = factory(Booker::class)->create([
            'email' => 'foo@example.org',
        ]);
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

        $firstBookable = $timeSlot[0];
        $secondBookable = $timeSlot[1];

        $firstBookable->booked_at = now();
        $firstBookable->booked_by_id = $bookerOne->id;
        $firstBookable->save();

        Livewire::test('display-bookables', ['event' => $event])
            ->set('email', $bookerOne->email)
            ->call('bookBookable', $secondBookable->id);

        Mail::assertNothingSent();

        Travel::back();
    }
}
