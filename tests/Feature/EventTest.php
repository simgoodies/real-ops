<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    /** @test */
    public function it_can_create_an_event()
    {
        $response = $this->post('office/events', [
            'origin_airport_icao' => 'TJSJ',
            'destination_airport_icao' => 'TIST',
            'departure_time' => now()->toDateTimeString(),
            'arrival_time' => now()->addHours(2)->toDateTimeString(),
        ]);
    }
}
