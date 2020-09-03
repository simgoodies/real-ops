<?php

namespace Tests\Feature;

use App\Http\Livewire\ChooseEventBookableType;
use App\Models\BookableFlight;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ChooseEventBookableTypeTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function it_can_choose_a_bookable_type()
    {
        $this->login();

        $event = factory(Event::class)->create([
            'slug' => 'no-event-type-yet',
            'bookable_type' => null,
        ]);

        Livewire::test(ChooseEventBookableType::class, ['event' => $event])
            ->call('setBookableType', 'flight')
            ->assertRedirect('office/events/no-event-type-yet');

        $this->assertDatabaseHas('events', [
            'slug' => 'no-event-type-yet',
            'bookable_type' => BookableFlight::TYPE,
        ]);
    }

    /** @test */
    public function it_cannot_set_an_unknown_bookable_type()
    {
        $this->login();

        $event = factory(Event::class)->create([
            'slug' => 'no-event-type-yet',
            'bookable_type' => null,
        ]);

        Livewire::test(ChooseEventBookableType::class, ['event' => $event])
            ->call('setBookableType', 'blablabla')
            ->assertRedirect('office/events/no-event-type-yet');

        $this->assertDatabaseMissing('events', [
            'slug' => 'no-event-type-yet',
            'bookable_type' => 'blablabla',
        ]);

        $this->assertDatabaseHas('events', [
            'slug' => 'no-event-type-yet',
            'bookable_type' => null,
        ]);
    }
}
