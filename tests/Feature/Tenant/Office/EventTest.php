<?php

namespace Tests\Feature\Tenant\Office;

use Carbon\Carbon;
use Tests\TenantTestCase;
use App\Models\Tenants\Event;
use App\Services\Tenants\EventService;

class EventTest extends TenantTestCase
{

    /**
     * @var EventService $eventService
     */
    protected $eventService;

    protected function setUp()
    {
        parent::setUp();
        $this->eventService = new EventService();
    }

    public function testItCanCreateNewEvent()
    {
        $this->withoutExceptionHandling();
        $this->setUpAndActivateTenant();
        $this->loggedInAdminUser();

        $response = $this->post('office/events', [
            'title' => 'Hakuna Matata Real Ops 2018',
            'description' => 'Super awesome description as to why Hakuna Matata Real Ops 2018 will be the bomb!',
            'start_date' => Carbon::now()->addDays(3)->toDateTimeString(),
            'start_time' => Carbon::now()->toDateTimeString(),
            'end_date' => Carbon::now()->addDays(3)->addHours(4)->toDateTimeString(),
            'end_time' => Carbon::now()->addHours(4)->toDateTimeString(),
            'banner_image_link' => 'https://www.example.com/image.jpeg'
        ]);

        $response->assertRedirect('office/events/hakuna-matata-real-ops-2018');

        $events = $this->eventService->getAll();

        $this->assertCount(1, $events);
        $this->assertEquals('Hakuna Matata Real Ops 2018', $events->first()->title);
        $this->assertEquals('hakuna-matata-real-ops-2018', $events->first()->slug);
    }

    public function testItCanUpdateDetailsOfAnEvent()
    {
        $this->withoutExceptionHandling();
        $this->setUpAndActivateTenant();
        $this->loggedInAdminUser();

        factory(Event::class)->create([
            'title' => 'Original Name',
            'description' => 'Original Description',
            'start_date' => '2018-12-31',
            'start_time' => '18:00',
            'end_date' => '2018-12-31',
            'end_time' => '20:00',
            'banner_image_link' => 'https://www.exampple.com/image.jpeg'
        ]);

        $response = $this->put('office/events/original-name/edit', [
            'title' => 'Changed Name',
            'description' => 'New Description',
            'start_date' => '2018-12-30',
            'start_time' => '19:00',
            'end_date' => '2018-12-30',
            'end_time' => '21:00',
            'banner_image_link' => 'https://www.exampple.com/new_image.jpeg'
        ]);

        $response->assertRedirect('office/events/changed-name');
        $event = $this->eventService->getAll()->first();

        $this->assertEquals('Changed Name', $event->title);
        $this->assertEquals('New Description', $event->description);
        $this->assertEquals('2018-12-30', $event->start_date);
        $this->assertEquals('19:00:00', $event->start_time);
        $this->assertEquals('2018-12-30', $event->end_date);
        $this->assertEquals('21:00:00', $event->end_time);
        $this->assertEquals('https://www.exampple.com/new_image.jpeg', $event->banner_image_link);
    }

    function testItCanDeleteEvents()
    {
        $this->setUpAndActivateTenant();
        $this->loggedInAdminUser();

        factory(Event::class)->create([
            'slug' => 'to-be-deleted-event'
        ]);

        $events = $this->eventService->getAll();
        $this->assertCount(1, $events);

        $response =  $this->delete('office/events/to-be-deleted-event');
        $response->assertRedirect('office/events');

        $events = $this->eventService->getAll();
        $this->assertCount(0, $events);

    }
}
