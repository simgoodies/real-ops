<?php

namespace App\Services;

use App\Models\Tenant;
use Hyn\Tenancy\Environment;

class TenantService
{
    protected $tenancy;

    public function __construct()
    {
        $this->tenancy = app(Environment::class);
    }

    /**
     * Does a tenant exist with given identifier.
     *
     * @param $identifier
     * @return bool|mixed
     */
    public function identifierExists($identifier)
    {
        $tenant = $this->findByIdentifier($identifier);

        return is_null($tenant) ? false : true;
    }

    /**
     * Does a tenant exist with given email.
     *
     * @param $email
     * @return bool|mixed
     */
    public function emailExists($email)
    {
        $tenant = $this->findByEmail($email);

        return is_null($tenant) ? false : true;
    }

    /**
     * Determine if a tenant already exists in the database.
     *
     * @param string $identifier
     * @param string $email
     * @return bool
     */
    public function tenantExists(string $identifier, string $email)
    {
        if ($this->identifierExists($identifier) || $this->emailExists($email)) {
            return true;
        }

        return false;
    }

    /**
     * @param array $attributes
     * @return Tenant|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes)
    {
        return Tenant::create($attributes);
    }

    /**
     * @param Tenant $tenant
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Tenant $tenant)
    {
        return $tenant->delete();
    }

    /**
     * Find tenant based on the identifier.
     *
     * @param $identifier
     * @return Tenant|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function findByIdentifier($identifier)
    {
        return Tenant::where('identifier', $identifier)->first();
    }

    /**
     * Find tenant based on the email.
     *
     * @param $email
     * @return Tenant|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function findByEmail($email)
    {
        return Tenant::where('email', $email)->first();
    }

    /**
     * @return Tenant
     */
    public function getCurrentTenant()
    {
        $hostname = $this->tenancy->hostname();

        return $hostname->tenant;
    }
}
