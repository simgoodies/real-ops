<?php

return [
    'database' => [
        'tenancy_database' => env('TENANCY_DATABASE', 'tenancy'),
        'db_connection' => env('DB_CONNECTION', 'mysql'),
    ],

    'office' => [
        'events' => [
            'flights' => [
                'per_page' => 12
            ],
        ],
    ],
];
