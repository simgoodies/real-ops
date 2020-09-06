<?php

namespace Tests\Feature;

use App\Mail\StaffInvitedMailable;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class StaffTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function it_can_invite_a_user_to_tenant()
    {
        Mail::fake();

        factory(User::class)->create(['email' => 'invitee@example.org']);

        $this->login();

        Livewire::test('staff')
            ->set('email', 'invitee@example.org')
            ->call('invite');

        Mail::assertSent(StaffInvitedMailable::class, function ($mail) {
            $this->assertEquals("Invitation staff member (Foo Tenant)", $mail->subject);
            $this->assertEquals('invitee@example.org', $mail->to[0]['address']);
            $this->assertEquals('info@realops.test', $mail->from[0]['address']);
            $this->assertEquals('Simgoodies.app', $mail->from[0]['name']);
            return true;
        });
    }

    /** @test */
    public function it_fails_if_non_email_format_was_invited()
    {
        $this->assertTrue(false);
    }

    /** @test */
    public function it_only_displays_members_that_are_actually_part_of_the_team()
    {
        $this->assertTrue(false);
    }

    /** @test */
    public function it_does_not_remove_the_owner_of_the_team()
    {
        $this->assertTrue(false);
    }
}
