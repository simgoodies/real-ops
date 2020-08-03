<?php

namespace App\Jobs;

use Stancl\Tenancy\Contracts\Tenant;

class CreateFrameworkDirectoriesForTenant
{
    protected $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        $this->tenant->run(function ($tenant) {
            $storage_path = storage_path();
            $cacheDirectory = "$storage_path/framework/cache";
            if (!file_exists($cacheDirectory)) {
                mkdir($cacheDirectory, 0777, true);
            }
        });
    }
}
