<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class BookableFlightImportTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function flights_can_be_imported()
    {
        $this->login();

        Storage::fake();

        $event = factory(Event::class)->create(['slug' => 'import-event']);
        $file = UploadedFile::fake()->createWithContent('bookableflightimporttest.csv', file_get_contents('tests/TestFiles/bookableflightimporttest.csv'));

        Livewire::test('bookable-flight-import', ['event' => $event])
            ->set('file', $file)
            ->call('import')
            ->assertRedirect('office/events/import-event');

        $this->assertDatabaseHas('bookables', [
            'data->callsign' => 'IMPORT',
        ]);
    }

    /** @test */
    public function flights_without_dates_assume_event_date()
    {
        Travel::to(now());
        Storage::fake();
        $this->login();


        $event = factory(Event::class)->create(['start_date' => $startDate = now()->format('Y-m-d')]);
        $file = UploadedFile::fake()->createWithContent('bookableflightimporttest.csv', file_get_contents('tests/TestFiles/bookableflightimporttest.csv'));

        Livewire::test('bookable-flight-import', ['event' => $event])
            ->set('file', $file)
            ->call('import');

        $this->assertDatabaseHas('bookables', [
            'data->origin_airport_icao' => 'FOO2',
            'begin_date' => $startDate,
            'end_date' => $startDate,
        ]);

        Travel::back();
    }

    /** @test */
    public function flights_with_only_departure_date_assume_that_day_for_arrival_date()
    {
        Travel::to(now());
        Storage::fake();
        $this->login();


        $event = factory(Event::class)->create(['start_date' => $startDate = now()->format('Y-m-d')]);
        $file = UploadedFile::fake()->createWithContent('bookableflightimporttest.csv', file_get_contents('tests/TestFiles/bookableflightimporttest.csv'));

        Livewire::test('bookable-flight-import', ['event' => $event])
            ->set('file', $file)
            ->call('import');

        $this->assertDatabaseHas('bookables', [
            'data->origin_airport_icao' => 'FOO4',
            'begin_date' => '2020-10-10',
            'end_date' => '2020-10-10',
        ]);

        Travel::back();
    }

    /** @test */
    public function flights_without_origin_and_destination_are_skipped()
    {
        Travel::to(now());
        Storage::fake();
        $this->login();


        $event = factory(Event::class)->create(['start_date' => $startDate = now()->format('Y-m-d')]);
        $file = UploadedFile::fake()->createWithContent('bookableflightimporttest.csv', file_get_contents('tests/TestFiles/bookableflightimporttest.csv'));

        Livewire::test('bookable-flight-import', ['event' => $event])
            ->set('file', $file)
            ->call('import');

        $this->assertDatabaseMissing('bookables', [
            'data->callsign' => 'NOPLACES',
        ]);

        Travel::back();
    }

    /** @test */
    public function flights_without_dates_where_arrival_time_is_lower_then_departure_assume_next_day()
    {
        Travel::to(now());
        Storage::fake();
        $this->login();

        $event = factory(Event::class)->create(['start_date' => now()->format('Y-m-d')]);
        $file = UploadedFile::fake()->createWithContent('bookableflightimporttest.csv', file_get_contents('tests/TestFiles/bookableflightimporttest.csv'));

        Livewire::test('bookable-flight-import', ['event' => $event])
            ->set('file', $file)
            ->call('import');

        $this->assertDatabaseHas('bookables', [
            'data->origin_airport_icao' => 'FOO5',
            'begin_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDay()->format('Y-m-d'),
        ]);

        Travel::back();
    }

    /** @test */
    public function flights_without_callsign_are_skipped()
    {
        Travel::to(now());
        Storage::fake();
        $this->login();

        $event = factory(Event::class)->create(['start_date' => now()->format('Y-m-d')]);
        $file = UploadedFile::fake()->createWithContent('bookableflightimporttest.csv', file_get_contents('tests/TestFiles/bookableflightimporttest.csv'));

        Livewire::test('bookable-flight-import', ['event' => $event])
            ->set('file', $file)
            ->call('import');

        $this->assertDatabaseMissing('bookables', [
            'data->origin_airport_icao' => 'FOO6',
        ]);

        Travel::back();
    }
}
