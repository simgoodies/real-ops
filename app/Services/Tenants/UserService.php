<?php

namespace App\Services\Tenants;

use App\Models\Tenants\User;

class UserService
{
    /**
     * Get all a user based on given id.
     *
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return User::find($id);
    }

    public function getByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * Get all users.
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return User::all();
    }

    /**
     * Determine whether a user exists based on given email.
     *
     * @param string $email
     * @return mixed
     */
    public function existsByEmail(string $email)
    {
        return User::where('email', $email)->exists();
    }
}
