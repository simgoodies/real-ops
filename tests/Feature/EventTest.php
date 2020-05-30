<?php

namespace Tests\Feature;

use App\Http\Controllers\OfficeEventController;
use App\Http\Requests\StoreOfficeEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new StoreOfficeEvent();
    }

    /** @test */
    public function it_can_create_an_event()
    {
        Travel::to(now());

        $response = $this->post('office/events', [
            'title' => 'Event One',
            'description' => 'Event One Description',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHours(3)->toDateTimeString(),
        ]);

        $this->assertDatabaseHas('events', [
            'title' => 'Event One',
            'slug' => 'event-one',
            'description' => 'Event One Description',
            'start_time' => now(),
            'end_time' => now()->addHours(3),
        ]);
        $response->assertRedirect('office/events/event-one');
        $response->assertSessionHas('success', 'The event was created successfully');

        Travel::back();
    }

    /** @test */
    public function store_validates_using_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            OfficeEventController::class,
            'store',
            StoreOfficeEvent::class
        );

        $this->assertEquals([
            'title' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            ],
            $this->subject->rules()
        );
    }
}
