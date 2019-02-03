<?php

namespace App\Services;

use App\Models\Tenant;

class TenantService
{
    /**
     * Does a tenant exist with given identifier
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
     * Does a tenant exist with given email
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
     * Determine if a tenant already exists in the database
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
     * Find tenant based on the identifier
     *
     * @param $identifier
     * @return Tenant|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function findByIdentifier($identifier) {
        return Tenant::where('identifier', $identifier)->first();
    }

    /**
     * Find tenant based on the email
     *
     * @param $email
     * @return Tenant|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function findByEmail($email) {
        return Tenant::where('email', $email)->first();
    }
}