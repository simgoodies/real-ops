<?php

namespace App\Console\Commands;

use App\Models\Airport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateAirportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'realops:import-airports-v2';

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
        $airports = File::get(resource_path('airports/airports-2019-04-02.json'));
        $airports = json_decode($airports);
        
        foreach ($airports as $airport) {
            Airport::updateOrCreate([
                'icao' => $airport->icao,
            ],[
                'name' => $airport->name,
            ]);
        }
    }
}
