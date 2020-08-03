<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    public function getTenantKey()
    {
        return $this->getAttribute($this->primaryKey);
    }

    public function getTenantKeyName(): string
    {
        return 'code';
    }

    public function getIncrementing()
    {
        return true;
    }

    public static function getCustomColumns(): array
    {
        return [
            'code',
            'name',
        ];
    }
}
