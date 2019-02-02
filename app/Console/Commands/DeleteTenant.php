<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Repositories\HostnameRepository;
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
        $this->deleteTenant($identifier);
    }

    /**
     * The tenant will be deleted if found
     *
     * @param $identifier
     * @throws \Exception
     */
    private function deleteTenant($identifier)
    {
        if (Tenant::identifierExists($identifier) == false) {
            $this->error("A tenant with the identifier '{$identifier}' does not exist.");
            return;
        }

        $tenant = $tenant = Tenant::where('identifier', $identifier)->firstOrFail();
        $hostname = $tenant->hostname()->first();
        $website = $hostname->website()->first();

        $tenant->delete();
        app(HostnameRepository::class)->delete($hostname, true);
        app(WebsiteRepository::class)->delete($website, true);

        $this->info("Tenant {$identifier} successfully deleted.");

    }
}
