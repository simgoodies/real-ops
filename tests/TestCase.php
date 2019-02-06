<?php

namespace Tests;

use HipsterJazzbo\Landlord\Facades\Landlord;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function assertSystemDatabaseHas($table, array $data)
    {
        $this->assertDatabaseHas($table, $data, config('extras.db_connection', 'system'));
    }

    protected function assertSystemDatabaseMissing($table, array $data)
    {
        $this->assertDatabaseMissing($table, $data, config('extras.db_connection', 'system'));
    }
}
