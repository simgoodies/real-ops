<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Website;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     */
    public function handle()
    {
        $identifier = $this->argument('identifier');
        $name = $this->argument('name');
        $email = $this->argument('email');


        if ($this->tenantExists($identifier, $email)) {
            $this->error("A tenant with identifier '{$identifier}' and/or email '{$email}' already exists");

            return;
        }

        $tenant = $this->createTenant($identifier, $name, $email);
        $tenant = $this->registerTenant($tenant);

        $password = str_random(16);
        $this->addAdminForTenant($tenant, $password);

        $hostname_fqdn = $tenant->hostname->fqdn;

        $this->info("Tenant '{$name}' is created and is now accessible at {$hostname_fqdn}");
        $this->info("Admin {$email} can log in using password {$password}");
    }

    /**
     * The tenant will be created along with the appropriate website and subdomain
     *
     * @param string $identifier The identifier of the tenant for example: tjzs
     * @param string $name The name of the tenant for example: San Juan CERAP
     * @param string $email The email of the tenant for example: sanjuan@example.com
     * @return Tenant|void
     */
    private function createTenant($identifier, $name, $email)
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
     * Creates the tenant environment
     *
     * @param Tenant $tenant
     * @return Tenant
     */
    private function registerTenant(Tenant $tenant)
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
     * Determine if a tenant already exists in the database
     *
     * @param string $identifier
     * @param string $email
     * @return bool
     */
    private function tenantExists(string $identifier, string $email)
    {
        if (Tenant::identifierExists($identifier) || Tenant::emailExists($email)) {
            return true;
        }

        return false;
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

        return false;
    }

    /**
     * Creates the first user for the tenant
     *
     * @param Tenant $tenant
     * @param string $password
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    private function addAdminForTenant(Tenant $tenant, string $password)
    {
        $admin = User::create(['name' => $tenant->name, 'email' => $tenant->email, 'password' => Hash::make($password)]);
        $admin->guard_name = 'web';
        $admin->assignRole('admin');

        return $admin;
    }

}
