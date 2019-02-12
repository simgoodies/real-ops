<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\MessageBag;
use App\Services\Command\TenantCommandService;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create {identifier} {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a tenant with the provided identifier, name and email address e.g. php artisan tenant:create tjzs "San Juan CERAP" sanjuan@example.org';

    private $tenantCommandService;

    /**
     * Create a new command instance.
     *
     * @param TenantCommandService $tenantCommandService
     */
    public function __construct(TenantCommandService $tenantCommandService)
    {
        parent::__construct();

        $this->tenantCommandService = $tenantCommandService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $identifier = $this->argument('identifier');
        $name = $this->argument('name');
        $email = $this->argument('email');

        if ($this->tenantCommandService->tenantExists($identifier, $email)) {
            $this->error("A tenant with identifier '{$identifier}' and/or email '{$email}' already exists");

            return;
        }

        $result = $this->tenantCommandService->createTenant($identifier, $name, $email);

        if ($result instanceof MessageBag) {
            foreach ($result->getMessages() as $message) {
                $this->error($message[0]);
            }

            return;
        }

        $tenant = $result;
        $tenant = $this->tenantCommandService->registerTenant($tenant);

        $password = str_random(16);
        $this->tenantCommandService->addAdminForTenant($tenant, $password);

        $hostname_fqdn = $tenant->hostname->fqdn;

        $this->info("Tenant '{$name}' is created and is now accessible at {$hostname_fqdn}");
        $this->info("Admin {$email} can log in using password {$password}");
    }
}
