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
     * @return bool
     */
    public function identifierExists($identifier)
    {
        return Tenant::where('identifier', $identifier)->exists();
    }

    /**
     * Does a tenant exist with given email.
     *
     * @param $email
     * @return bool
     */
    public function emailExists($email)
    {
        return Tenant::where('email', $email)->exists();
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
        return Tenant::where([
            'identifier' => $identifier,
            'email' => $email,
        ])->exists();
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
        $website = $this->tenancy->tenant();
        return $website->hostnames()->firstOrFail()->tenant;
    }

    /**
     * @return Tenant[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Tenant::all();
    }
}
