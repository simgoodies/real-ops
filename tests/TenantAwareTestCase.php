<?php

namespace Tests;

use App\Services\Command\TenantCommandService;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TenantAwareTestCase extends TestCase
{
    use RefreshDatabase;

    protected $tenantCommandService;

    protected function refreshApplication()
    {
        parent::refreshApplication();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->tenantCommandService = new TenantCommandService();
    }

    protected function assertSystemDatabaseHas($table, array $data)
    {
        $this->assertDatabaseHas($table, $data, env('DB_CONNECTION'));
    }

    protected function assertSystemDatabaseMissing($table, array $data)
    {
        $this->assertDatabaseMissing($table, $data, env('DB_CONNECTION'));
    }

    /**
     * Deletes any given tenant based on your identification provided
     *
     * @param array $basedOn e.g. ['identifier' => 'tjzs'] or ['email' => 'ttzp@example.org']
     */
    protected function deleteTenantIfExists(array $basedOn)
    {
        $identifier = null;

        if (array_key_exists('identifier', $basedOn)) {
            if ($this->tenantCommandService->identifierExists($basedOn['identifier']) == false) {
                return;
            }
            $identifier = $basedOn['identifier'];
        }

        if (array_key_exists('email', $basedOn)) {
            if ($this->tenantCommandService->emailExists($basedOn['email']) == false) {
                return;
            }
            $identifier = $this->tenantCommandService->findByEmail($basedOn('email'))->identifier;
        }

        if (is_null($identifier) == false) {
            $this->tenantCommandService->deleteTenant($identifier);
        }
    }
}