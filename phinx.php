<?php

use Dotenv\Dotenv;

require __DIR__.'/vendor/autoload.php';



return [
    'paths'         => [
        'migrations' => __DIR__.'/database',
    ],
    'environments'  => [
        'default_migration_table' => 'phinxlog',
        'default_database'        => 'development',
        'development'              => [
            'adapter' => 'pgsql',
            'host'    => getenv('DBHOST'),
            'name'    => getenv('DBNAME'),
            'user'    => getenv('DBUSER'),
            'pass'    => getenv('DBPASS'),
            'port'    => 5454,
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];