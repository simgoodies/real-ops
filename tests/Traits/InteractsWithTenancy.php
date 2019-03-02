<?php

namespace Tests\Traits;

use App\Models\Tenant;
use App\Models\Tenants\User;
use App\Services\TenantService;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Database\Connection;
use App\Models\Hostname;
use App\Models\Website;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Traits\DispatchesEvents;
use Illuminate\Config\Repository;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;

trait InteractsWithTenancy
{
    use DispatchesEvents;

    /**
     * @var HostnameRepository
     */
    protected $hostnameRepository;
    /**
     * @var WebsiteRepository
     */
    protected $websiteRepository;
    /**
     * @var Connection
     */
    protected $connection;
    /**
     * Created tenants, so we can destroy databases after a test.
     *
     * @var array|Tenant[]
     */
    protected $tenants = [];

    /**
     * @var TenantService
     */
    protected $tenantService;

    /**
     * @var string
     */
    protected $tenantUrl;

    protected function setUpTenancy()
    {
        $this->websiteRepository = app(WebsiteRepository::class);
        $this->hostnameRepository = app(HostnameRepository::class);
        $this->connection = app(Connection::class);
        $this->tenantService = new TenantService();

        $this->handleTenantDestruction();
    }

    protected function handleTenantDestruction()
    {
        Tenant::created(function (Tenant $tenant) {
            $this->tenants[$tenant->identifier] = $tenant;
        });

        Tenant::updating(function (Tenant $tenant) {
            if ($tenant->isDirty('identifier')) {
                $this->tenants[$tenant->getOriginal('identifier')] = Tenant::unguarded(function () use ($tenant) {
                    return new Tenant($tenant->getOriginal());
                });
            }
        });

        Tenant::deleted(function (Tenant $tenant) {
            array_forget($this->tenants, $tenant->identifier);
        });
    }

    protected function createTenant($identifier = 'tjzs', $name = 'San Juan CERAP', $email = 'tjzs@example.com')
    {
        $tenant = $this->tenantService->create(['identifier' => $identifier, 'name' => $name, 'email' => $email]);
        $hostname = $this->handleHostname($tenant);
        $website = $this->handleWebsite($hostname);
        $this->activateWebsite($website);
    }

    private function handleHostname(Tenant $tenant)
    {
        $hostname = Hostname::unguarded(function () use ($tenant) {
            return new Hostname([
                    'fqdn' => $tenant->identifier . '.' . config('app.url_base'),
                    'tenant_id' => $tenant->id
                ]
            );
        });

        return app(HostnameRepository::class)->create($hostname);
    }

    private function handleWebsite(Hostname $hostname)
    {
        $uuid = implode('_', [config('extras.tenancy_database'), $hostname->tenant->identifier, str_random(6)]);
        $website = new Website(['uuid' => $uuid]);
        $website = $this->websiteRepository->create($website);
        $this->hostnameRepository->attach($hostname, $website);
        return $website->fresh();
    }

    protected function activateTenant(Tenant $tenant)
    {
        $website = $tenant->hostname->website;
        $this->activateWebsite($website);
    }

    protected function activateWebsite(Website $website)
    {
        $this->tenantUrl = $website->hostnames()->first()->fqdn;
        app(Environment::class)->tenant($website);
        $this->refreshTenantRoutes();
    }

    protected function prepareTenantUrl($uri = null)
    {
        return implode('/', ['http://' . $this->tenantUrl, $uri]);
    }

    protected function cleanupTenancy()
    {
        $this->connection->purge();
        collect($this->tenants)
            ->filter()
            ->each(function ($tenant) {
                $website = $tenant->hostname->website;
                $hostname = $tenant->hostname;
                $this->connection->set($website);
                $this->connection->purge();

                $this->tenantService->delete($tenant);
                $this->hostnameRepository->delete($hostname, false);
                $this->websiteRepository->delete($website, false);
            });

        $this->connection->system()->disconnect();
    }

    private function refreshTenantRoutes()
    {
        $config = $this->app->make(Repository::class);
        $path = $config->get('tenancy.routes.path');

        /** @var Router $router */
        $router = $this->app->make(Router::class);

        if ($path && file_exists($path)) {
            if ($config->get('tenancy.routes.replace-global')) {
                $router->setRoutes(new RouteCollection());
            }

            $router->middleware([])->group($path);
        }
    }

    protected function loggedInAdminUser() {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);
    }
}
