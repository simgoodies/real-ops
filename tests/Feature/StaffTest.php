<?php

namespace Tests\Feature;

use App\Mail\StaffInvitedMailable;
use App\Models\TeamInvite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use RachidLaasri\Travel\Travel;
use Tests\TestCase;

class StaffTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    /** @test */
    public function it_can_invite_an_existing_user_to_tenant()
    {
        Mail::fake();
        $this->login();

        $response = $this->post('office/staff/invite', [
            'email' => 'invitee@example.org',
        ]);

        Mail::assertSent(StaffInvitedMailable::class, function ($mail) {
            $this->assertEquals("Invitation staff member (Foo Tenant)", $mail->subject);
            $this->assertEquals('invitee@example.org', $mail->to[0]['address']);
            $this->assertEquals('info@realops.test', $mail->from[0]['address']);
            $this->assertEquals('Simgoodies.app', $mail->from[0]['name']);
            return true;
        });

        $this->assertDatabaseHas('team_invites', [
            'team_id' => tenant('id'),
            'email' => 'invitee@example.org',
        ]);

        $response->assertRedirect('office/staff');
        $response->assertSessionHas('success', 'invitee@example.org has successfully been invited.');
    }

    /** @test */
    public function it_does_not_invite_a_user_that_is_already_member_of_the_tenant()
    {
        Mail::fake();
        $this->login();

        factory(User::class)->create([
            'email' => 'alreadymember@example.org',
        ])->attachTeam($this->tenant);

        $response = $this->post('office/staff/invite', [
            'email' => 'alreadymember@example.org',
        ]);

        Mail::assertNotSent(StaffInvitedMailable::class);

        $this->assertDatabaseMissing('team_invites', [
            'team_id' => tenant('id'),
            'email' => 'alreadymember@example.org',
        ]);

        $response->assertRedirect('office/staff');
        $response->assertSessionHas('failure', 'alreadymember@example.org is already member of this team.');
    }

    /** @test */
    public function it_does_not_invite_a_user_that_has_already_been_invited_within_24_hours()
    {
        Mail::fake();
        $this->login();

        $timeToEarly = now()->subHour(23);
        Travel::to($timeToEarly);
        factory(TeamInvite::class)->create([
            'team_id' => $this->tenant->id,
            'email' => 'alreadyinvited@example.org',
        ]);
        Travel::back();

        $response = $this->post('office/staff/invite', [
            'email' => 'alreadyinvited@example.org',
        ]);

        Mail::assertNotSent(StaffInvitedMailable::class);

        $this->assertDatabaseHas('team_invites', [
            'team_id' => tenant('id'),
            'email' => 'alreadyinvited@example.org',
        ]);

        $response->assertRedirect('office/staff');
        $response->assertSessionHas('failure', 'alreadyinvited@example.org has recently already been invited.');
    }

    /** @test */
    public function it_allows_an_already_invited_member_to_be_reinvited_after_24_hours_elapsed_since_last_invitation()
    {
        Mail::fake();
        $this->login();

        $enoughTimePassed = now()->subHour(25);
        Travel::to($enoughTimePassed);
        factory(TeamInvite::class)->create([
            'team_id' => $this->tenant->id,
            'email' => 'cangetanotherinvite@example.org',
        ]);
        Travel::back();

        $response = $this->post('office/staff/invite', [
            'email' => 'cangetanotherinvite@example.org',
        ]);

        Mail::assertSent(StaffInvitedMailable::class);

        $this->assertDatabaseHas('team_invites', [
            'team_id' => tenant('id'),
            'email' => 'cangetanotherinvite@example.org',
        ]);

        $response->assertRedirect('office/staff');
        $response->assertSessionHas('success', 'cangetanotherinvite@example.org has successfully been invited.');
    }

    /** @test */
    public function it_deletes_existing_invites_if_a_reinvite_has_been_sent()
    {
        Mail::fake();
        $this->login();


        $now = now()->toDateTimeString();
        $enoughTimePassed = now()->subHour(25)->toDateTimeString();

        Travel::to($enoughTimePassed);
        factory(TeamInvite::class)->create([
            'team_id' => $this->tenant->id,
            'email' => 'cangetanotherinvite@example.org',
            'created_at' => $enoughTimePassed,
            'updated_at' => $enoughTimePassed,
        ]);
        Travel::to($now);

        $response = $this->post('office/staff/invite', [
            'email' => 'cangetanotherinvite@example.org',
        ]);

        Mail::assertSent(StaffInvitedMailable::class);

        $this->assertDatabaseHas('team_invites', [
            'team_id' => tenant('id'),
            'email' => 'cangetanotherinvite@example.org',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->assertDatabaseMissing('team_invites', [
            'team_id' => tenant('id'),
            'email' => 'cangetanotherinvite@example.org',
            'created_at' => $enoughTimePassed,
            'updated_at' => $enoughTimePassed,
        ]);

        $response->assertRedirect('office/staff');
        $response->assertSessionHas('success', 'cangetanotherinvite@example.org has successfully been invited.');
    }

    /** @test */
    public function it_shows_errors_if_accept_invitation_is_no_longer_valid_or_existant()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_fails_if_non_email_format_was_invited()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_only_displays_members_that_are_actually_part_of_the_team()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_does_not_remove_the_owner_of_the_team()
    {
        $this->markTestIncomplete('TODO');
    }
}
