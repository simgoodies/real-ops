<?php

namespace App\Console\Commands;

use App\Imports\AirportsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportAirportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'realops:import-airports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import airports into airports table on system database.';

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
        Excel::import(new AirportsImport, 'airports/airports-2019-03-16.csv');
    }
}
