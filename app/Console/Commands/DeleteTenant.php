<?php

namespace App\Console\Commands;

use App\Services\Command\TenantCommandService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class DeleteTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:delete {identifier}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes a tenant of the provided identifier. Only available on the local environment e.g. php artisan tenant:delete boise';

    /**
     * The variable that will hold an instance of TenantCommandService
     *
     * @var TenantCommandService
     */
    protected $tenantCommandService;

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
     * @throws \Exception
     */
    public function handle()
    {
        // because this is a destructive command, we'll only allow to run this command
        // if you are on the local environment
        if (App::environment() == 'production') {
            $this->error('This command is not available in the production environment.');
            return;
        }

        $identifier = $this->argument('identifier');

        if ($this->tenantCommandService->identifierExists($identifier) == false) {
            $this->error("A tenant with the identifier '{$identifier}' does not exist.");
            return;
        }

        $this->tenantCommandService->deleteTenant($identifier);

        $this->info("Tenant {$identifier} successfully deleted.");
    }
}
