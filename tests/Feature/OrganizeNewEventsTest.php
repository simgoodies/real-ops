<?php

namespace Tests\Feature;

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

        $response = $this->post('events', [
            'name' => 'Hakuna Matata Real Ops 2018',
            'description' => 'Super awesome description as to why Hakuna Matata Real Ops 2018 will be the bomb!',
            'start_time' => Carbon::now()->addDays(3)->format('Y-m-d H:i:s'),
            'end_time' => Carbon::now()->addDays(3)->addHours(4)->format('Y-m-d H:i:s')
        ]);

        $response->assertRedirect('events/hakuna-matata-real-ops-2018');

        $events = Event::all();

        $this->assertCount(1, $events);
        $this->assertEquals('Hakuna Matata Real Ops 2018', $events->first()->name);
        $this->assertEquals('hakuna-matata-real-ops-2018', $events->first()->slug);
    }
}
