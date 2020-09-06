<?php

namespace App\Models;

use Mpociot\Teamwork\Traits\TeamworkTeamTrait;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use HasDomains, TeamworkTeamTrait;

    public function getIncrementing()
    {
        return true;
    }

    public static function getCustomColumns(): array
    {
        return [
            'owner_id',
            'name',
        ];
    }
}
