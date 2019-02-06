<?php

/*
 * WILL BE DELETED WHEN CONFIDENT ENOUGH :D
 * @TODO delete this
 */


//namespace Tests;
//
//use App\Services\Command\TenantCommandService;
//use App\Services\TenantService;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//
//abstract class TenantAwareTestCase extends TestCase
//{
//    use RefreshDatabase;
//
//    /** @var TenantService $tenantService */
//    protected $tenantService;
//
//    /** @var TenantCommandService $tenantCommandService */
//    protected $tenantCommandService;
//
//    /** @var array $tenantIdentifiers */
//    protected $tenantIdentifiers;
//
//    protected function refreshApplication()
//    {
//        parent::refreshApplication();
//    }
//
//    protected function setUp()
//    {
//        parent::setUp();
//
//        $this->tenantIdentifiers = [];
//        $this->tenantCommandService = new TenantCommandService();
//    }
//
//    /**
//     * Deletes any given tenant based on your identification provided
//     *
//     * @param array $basedOn e.g. ['identifier' => 'tjzs'] or ['email' => 'ttzp@example.org']
//     */
//    protected function deleteTenantIfExists(array $basedOn)
//    {
//        $identifier = null;
//
//        if (array_key_exists('identifier', $basedOn)) {
//            if ($this->tenantCommandService->identifierExists($basedOn['identifier']) == false) {
//                return;
//            }
//            $identifier = $basedOn['identifier'];
//        }
//
//        if (array_key_exists('email', $basedOn)) {
//            if ($this->tenantCommandService->emailExists($basedOn['email']) == false) {
//                return;
//            }
//            $identifier = $this->tenantCommandService->findByEmail($basedOn('email'))->identifier;
//        }
//
//        if (is_null($identifier) == false) {
//            $this->artisan('tenant:delete', ['identifier' => $identifier]);
//        }
//    }
//
//    protected function createTenant(
//        string $identifier = 'tjzs',
//        string $name = 'San Juan CERAP',
//        string $email = 'tjzs@example.com'
//    ) {
//        array_push($this->tenantIdentifiers, $identifier);
//        $this->artisan('tenant:create', ['identifier' => $identifier, 'name' => $name, 'email' => $email]);
//        return $this->tenantCommandService->findByIdentifier($identifier);
//    }
//
//    protected function tearDown()
//    {
//        foreach ($this->tenantIdentifiers as $identifier) {
//            $this->deleteTenantIfExists(['identifier' => $identifier]);
//        }
//
//        parent::tearDown();
//    }
//}