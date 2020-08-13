<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
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

        $event = factory(Event::class)->create();
        $file = UploadedFile::fake()->createWithContent('bookableflightimporttest.csv', file_get_contents('tests/TestFiles/bookableflightimporttest.csv'));

        Livewire::test('bookable-flight-import', ['event' => $event])
            ->set('file', $file)
            ->call('import');

        $this->assertDatabaseHas('bookables', [
            'data->callsign' => 'IMPORT',
        ]);
    }
}
