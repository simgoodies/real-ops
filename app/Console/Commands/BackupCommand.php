<?php

namespace App\Console\Commands;

use App\Models\Website;
use Illuminate\Console\Command;
use Hyn\Tenancy\Database\Connection;
use Illuminate\Support\Facades\Artisan;

class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'realops:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup all the tenants and system';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->backupSystem();
        $sites = Website::all();
        foreach ($sites as $site) {
            $this->setupConfigForSite($site);
            $this->callBackupCommand();
        };
    }

    protected function backupSystem()
    {
        \Config::set('backup.backup.source.databases', ['system']);
        \Config::set('backup.backup.name', config('app.url_base'));
        Artisan::call('backup:run', [
            '--only-db' => 1
        ]);
    }

    protected function setupConfigForSite(Website $website)
    {
        $connection = app(Connection::class);
        $connection->set($website);
        \Config::set('backup.backup.source.databases', ['tenant']);
        \Config::set('backup.backup.name', $website->hostnames()->first()->fqdn);
    }

    protected function callBackupCommand()
    {
        Artisan::call('backup:run', [
            '--only-db' => 1
        ]);
    }
}
