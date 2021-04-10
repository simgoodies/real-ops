<?php

namespace App\Models;

use Mpociot\Teamwork\TeamInvite as TeamworkTeamInvite;

class TeamInvite extends TeamworkTeamInvite
{
    public function setTenantIdAttribute($value)
    {
        $this->team_id = $value;
    }

    public function getTenantIdAttribute()
    {
        return $this->team_id;
    }
}
