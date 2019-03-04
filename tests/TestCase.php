<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();
        $this->migrateSystem();
    }

    protected function assertSystemDatabaseHas($table, array $data)
    {
        $this->assertDatabaseHas($table, $data, config('extras.database.db_connection', 'system'));
    }

    protected function assertSystemDatabaseMissing($table, array $data)
    {
        $this->assertDatabaseMissing($table, $data, config('extras.database.db_connection', 'system'));
    }

    protected function migrateSystem()
    {
        $this->connection->system()->getSchemaBuilder()->dropAllTables();

        // refresh database
        $this->artisan('migrate:fresh', [
            '--no-interaction' => 1,
            '--force' => 1
        ]);
    }
}
