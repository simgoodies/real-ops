<?php

namespace Tests\Feature;

use App\Http\Controllers\OfficeEventController;
use App\Http\Requests\StoreOfficeEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class OfficeEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_event()
    {
        Travel::to(now());

        $response = $this->post('office/events', [
            'title' => 'Event One',
            'description' => 'Event One Description',
            'start_date' => now()->format('Y-m-d'),
            'start_time' => now()->format('H:i'),
            'end_date' => now()->addHours(3)->format('Y-m-d'),
            'end_time' => now()->addHours(3)->format('H:i'),
        ]);

        $this->assertDatabaseHas('events', [
            'title' => 'Event One',
            'slug' => 'event-one',
            'description' => 'Event One Description',
            'start_date' => now()->format('Y-m-d'),
            'start_time' => now()->format('H:i'),
            'end_date' => now()->addHours(3)->format('Y-m-d'),
            'end_time' => now()->addHours(3)->format('H:i'),
        ]);
        $response->assertRedirect('office/events/event-one');
        $response->assertSessionHas('success', 'The event was created successfully');

        Travel::back();
    }

    /** @test */
    public function store_validates_using_a_form_request()
    {
        $formRequest = new StoreOfficeEvent();

        $this->assertActionUsesFormRequest(
            OfficeEventController::class,
            'store',
            StoreOfficeEvent::class
        );

        $this->assertEquals([
            'title' => 'required',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'required|date_format:H:i',
        ],
            $formRequest->rules()
        );
    }
}
