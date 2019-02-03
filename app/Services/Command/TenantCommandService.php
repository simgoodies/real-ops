<?php

namespace App\Services\Command;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Website;
use App\Services\TenantService;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TenantCommandService extends TenantService
{
    /**
     * The tenant will be created along with the appropriate website and subdomain
     *
     * @param string $identifier The identifier of the tenant for example: tjzs
     * @param string $name The name of the tenant for example: San Juan CERAP
     * @param string $email The email of the tenant for example: sanjuan@example.com
     * @return Tenant|void
     */
    public function createTenant($identifier, $name, $email)
    {
        if ($this->isTenantInfoValid($identifier, $name, $email) == false) {
            return;
        }

        $tenant = new Tenant();
        $tenant->identifier = $identifier;
        $tenant->name = $name;
        $tenant->email = $email;

        $tenant->save();

        return $tenant;
    }

    /**
     * The tenant will be deleted if found
     *
     * @param $identifier
     * @throws \Exception
     */
    public function deleteTenant($identifier)
    {
        $tenant = $this->findByIdentifier($identifier);
        $hostname = $tenant->hostname()->first();
        $website = $hostname->website()->first();

        $tenant->delete();
        app(HostnameRepository::class)->delete($hostname, true);
        app(WebsiteRepository::class)->delete($website, true);
    }

    /**
     * Checks to see if the provided arguments comply with validation requirements
     *
     * @param string $identifier
     * @param string $name
     * @param string $email
     * @return bool
     */
    private function isTenantInfoValid(string $identifier, string $name, string $email)
    {
        $input = [
            'identifier' => $identifier,
            'name' => $name,
            'email' => $email
        ];

        $validator = Validator::make($input, [
            'identifier' => 'required|max:4|unique:tenants',
            'name' => 'required|max:255|unique:tenants',
            'email' => 'required|max:255|unique:tenants'
        ]);

        $errors = $validator->errors()->getMessages();

        if (empty($errors)) {
            return true;
        }

        foreach ($errors as $error) {
            $this->error($error[0]);
        }

        return $errors;
    }


    /**
     * Creates the tenant environment
     *
     * @param Tenant $tenant
     * @return Tenant
     */
    public function registerTenant(Tenant $tenant)
    {
        // Formulate the subdomain e.g. tjzs.realops.example
        $hostname = new Hostname;
        $hostname->fqdn = $tenant->identifier . '.' . config('app.url_base');
        $hostname->tenant_id = $tenant->id;
        $hostname = app(HostnameRepository::class)->create($hostname);

        // Create the website
        $website = new Website(['uuid' => 'realops_tenant_' . $tenant->identifier . '_' . str_random(8)]);
        $website = app(WebsiteRepository::class)->create($website);
        app(HostnameRepository::class)->attach($hostname, $website);

        $tenancy = app(Environment::class);
        $tenancy->tenant($website);

        return $tenant;
    }

    /**
     * Creates the first user for the tenant
     *
     * @param Tenant $tenant
     * @param string $password
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function addAdminForTenant(Tenant $tenant, string $password)
    {
        $admin = User::create([
            'name' => $tenant->name,
            'email' => $tenant->email,
            'password' => Hash::make($password)
        ]);
        $admin->guard_name = 'web';
        $admin->assignRole('admin');

        return $admin;
    }
}