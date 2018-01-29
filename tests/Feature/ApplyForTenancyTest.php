<?php

namespace Tests\Feature;

use App\Mail\ApplicationReceived;
use App\Models\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ApplyForTenancyTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /** @test */
    function it_can_apply_for_tenancy()
    {
        $this->withoutExceptionHandling();
        //Mail::fake();

        $response = $this->post('apply', [
            'fir_name' => 'Hakuna Matata FIR',
            'contact_first_name' => 'John',
            'contact_last_name' => 'Doe',
            'contact_email' => 'johndoe@example.org',
            'vatsim_id' => '1234567',
            'icao' => 'HKMT',
            'motivation' => 'I would like to apply because I want to throw dope events'
        ]);

        Mail::assertSent(ApplicationReceived::class, function ($mail) {
            return $mail->hasTo('johndoe@example.org') &&
                $mail->hasBcc(env('SUPER_ADMIN_EMAIL'));
        });

        $response->assertRedirect('/successfully-applied');
        $this->assertCount(1, Application::all());
        $this->assertEquals('Hakuna Matata FIR', Application::all()->first()->fir_name);
    }
}