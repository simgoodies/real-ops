<?php

namespace App\Services\Tenants;

use App\Models\Tenants\Role;

class RoleService
{
    /**
     * Get role based on given id
     *
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Role::find($id);
    }
}
