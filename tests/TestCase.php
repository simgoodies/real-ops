<?php

namespace Tests;

use HipsterJazzbo\Landlord\Facades\Landlord;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function asTenant(int $tenant_id = 1)
    {
        Landlord::addTenant('tenant_id', $tenant_id);
    }
}
