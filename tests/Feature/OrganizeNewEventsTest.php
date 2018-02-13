<?php

namespace Tests\Feature;

use App\Models\Airline;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;

class OrganizeNewEventsTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /** @test */
    public function it_can_organize_a_new_event()
    {
        $this->withoutExceptionHandling();
        $this->asTenant();

        $response = $this->post('office/events', [
            'name' => 'Hakuna Matata Real Ops 2018',
            'description' => 'Super awesome description as to why Hakuna Matata Real Ops 2018 will be the bomb!',
            'start_date' => Carbon::now()->addDays(3)->toDateTimeString(),
            'start_time' => Carbon::now()->toDateTimeString(),
            'end_date' => Carbon::now()->addDays(3)->addHours(4)->toDateTimeString(),
            'end_time' => Carbon::now()->addHours(4)->toDateTimeString()
        ]);

        $response->assertRedirect('office/events/hakuna-matata-real-ops-2018');

        $events = Event::all();

        $this->assertCount(1, $events);
        $this->assertEquals('Hakuna Matata Real Ops 2018', $events->first()->name);
        $this->assertEquals('hakuna-matata-real-ops-2018', $events->first()->slug);
    }

    /** @test */
    function it_can_add_a_new_airline()
    {
        $this->withoutExceptionHandling();
        $this->asTenant();

        $response = $this->post('airlines', [
            'name' => 'Hakuna Matata Airline',
            'callsign' => 'Hakuna',
            'icao' => 'hkm'
        ]);

        $response->assertRedirect('airlines');

        $airlines = Airline::all();

        $this->assertCount(1, $airlines);
        $this->assertEquals('Hakuna Matata Airline', $airlines->first()->name);
        $this->assertEquals('HAKUNA', $airlines->first()->callsign);
        $this->assertEquals('HKM', $airlines->first()->icao);
    }

    /** @test */
    function it_can_update_details_of_an_event()
    {
        $this->withoutExceptionHandling();
        $this->asTenant();

        factory('App\Models\Event')->create([
            'name' => 'Original Name',
            'slug' => 'original-name',
            'description' => 'Original Description',
            'start_date' => '2018-12-31',
            'start_time' => '18:00',
            'end_date' => '2018-12-31',
            'end_time' => '20:00'
        ]);

        $response = $this->patch('office/events/original-name/edit', [
            'description' => 'New Description',
            'start_date' => '2018-12-30',
            'start_time' => '19:00',
            'end_date' => '2018-12-30',
            'end_time' => '21:00'
        ]);

        $response->assertRedirect('office/events/original-name');
        $event = Event::all()->first();

        $this->assertEquals('New Description', $event->description);
        $this->assertEquals('2018-12-30', $event->start_date);
        $this->assertEquals('19:00:00', $event->start_time);
        $this->assertEquals('2018-12-30', $event->end_date);
        $this->assertEquals('21:00:00', $event->end_time);
    }
}
