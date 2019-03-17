<?php

namespace Tests\Traits;

use App\Models\Airport;
use App\Models\Tenant;
use App\Models\Website;
use App\Models\Hostname;
use Hyn\Tenancy\Providers\Tenants\RouteProvider;
use Illuminate\Support\Arr;
use App\Models\Tenants\User;
use Hyn\Tenancy\Environment;
use App\Services\TenantService;
use Illuminate\Support\Facades\URL;
use Hyn\Tenancy\Database\Connection;
use Hyn\Tenancy\Traits\DispatchesEvents;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

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
     * @var array|Website[]
     */
    protected $tenants = [];

    /**
     * @var Tenant
     */
    protected $tenant;

    /**
     * @var Hostname
     */
    protected $hostname;

    /**
     * @var Website
     */
    protected $website;

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

        if ($this->connection->system()->getConfig('driver') !== 'pgsql') {
            $this->connection->system()->beginTransaction();
        }

        $this->tenantService = new TenantService();

        $this->handleTenantDestruction();
    }

    protected function cleanupTenancy()
    {
        $this->connection->purge();

        collect($this->tenants)
            ->filter()
            ->each(function ($website) {
                $this->connection->set($website);
                $this->connection->purge();

                $this->websiteRepository->delete($website, true);
            });

        if ($this->connection->system()->getConfig('driver') !== 'pgsql') {
            $this->connection->system()->rollback();
        }

        $this->connection->system()->disconnect();
    }

    protected function handleTenantDestruction()
    {
        Website::created(function (Website $website) {
            $this->tenants[$website->uuid] = $website;
        });

        Website::updating(function (Website $website) {
            if ($website->isDirty('uuid')) {
                $this->tenants[$website->getOriginal('uuid')] = Website::unguarded(function () use ($website) {
                    return new Website($website->getOriginal());
                });
            }
        });

        Website::deleted(function (Website $website) {
            Arr::forget($this->tenants, $website->uuid);
        });
    }

    public function setUpTenant(bool $save = false)
    {
        Tenant::unguard();
        if ($this->tenant === null) {
            $tenant = Tenant::firstOrNew([
                'identifier' => 'tjzs',
                'name' => 'San Juan CERAP',
                'email' => 'tjzs@example.com',
            ]);

            $this->tenant = $tenant;
        }
        Tenant::reguard();

        if ($save && $this->tenant->exists == false) {
            $this->tenant = $this->tenant->create($this->tenant->attributesToArray());
        }
    }

    protected function setUpHostname(bool $save = false)
    {
        Hostname::unguard();
        if ($this->hostname === null) {
            $hostname = Hostname::firstOrNew([
                'fqdn' => $this->tenant->identifier . '.' . config('app.url_base'),
                'tenant_id' => $this->tenant->id,
            ]);

            $this->hostname = $hostname;
        }
        Hostname::reguard();

        if ($save && $this->hostname->exists == false) {
            $this->hostnameRepository->create($this->hostname);
        }
    }

    protected function setUpWebsite(bool $save = false, bool $connect = false)
    {
        if ($this->website === null) {
            $uuid = implode(
                '_',
                [config('extras.database.tenancy_database'), $this->tenant->identifier, str_random(6)]
            );
            $this->website = new Website(['uuid' => $uuid]);
        }

        if ($save && $this->website->exists == false) {
            $this->websiteRepository->create($this->website);
        }

        if ($connect && $this->hostname->website_id !== $this->website->id) {
            $this->hostnameRepository->attach($this->hostname, $this->website);
        }
    }

    protected function activateTenant()
    {
        app(Environment::class)->tenant($this->website);
        app(Environment::class)->hostname($this->hostname);

        $this->setAppUrl();

        (new RouteProvider(app()))->boot();

        // Start global tenant transaction.
        $this->connection->get()->beginTransaction();
    }

    private function setAppUrl()
    {
        $scheme = parse_url(config('app.url'), PHP_URL_SCHEME);
        $url = sprintf('%s://%s.%s', $scheme, $this->tenant->identifier, config('tenancy.hostname.default'));

        config(['app.url' => $url]);
        URL::forceRootUrl($url);
    }

    protected function setUpAndActivateTenant()
    {
        $this->setUpTenant(true);
        $this->setUpHostname(true);
        $this->setUpWebsite(true, true);
        $this->activateTenant();
    }

    protected function loggedInAdminUser()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);
    }

    protected function loggedInStaffUser()
    {
        $user = factory(User::class)->create();
        $user->assignRole('staff');
        $this->actingAs($user);
    }

    public function withDummyAirports()
    {
        factory(Airport::class)->create(['icao' => 'TJSJ']);
        factory(Airport::class)->create(['icao' => 'TNCM']);
        factory(Airport::class)->create(['icao' => 'TTPP']);
        factory(Airport::class)->create(['icao' => 'KMIA']);
        factory(Airport::class)->create(['icao' => 'TNCC']);
    }
}
