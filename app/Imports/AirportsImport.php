<?php

namespace App\Imports;

use Exception;
use App\Models\Airport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AirportsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            try {
                Airport::firstOrCreate(
                    [
                        'icao' => $row['ident']
                    ],
                    [
                        'iata' => $row['iata_code'],
                        'name' => $row['name'],
                        'elevation_feet' => $row['elevation_ft'],
                        'continent' => $row['continent'],
                        'iso_country' => $row['iso_country'],
                        'iso_region' => $row['iso_region'],
                        'municipality' => $row['municipality'],
                        'coordinates' => $row['coordinates'],
                    ]
                );
            } catch (Exception $exception) {
                continue;
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
