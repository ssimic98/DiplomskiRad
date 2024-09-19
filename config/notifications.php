<?php

return [
    'channels' => [
        'database' => [
            'driver' => 'database',
            'table' => 'notifications', // Provjerite da li postoji migracija za ovu tablicu
        ],
        // Ostali kanali
    ],
];