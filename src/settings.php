<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../views/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        //databases
        'database' => [
            'default' => [
                'driver'    => 'pgsql',
                'host'      => getenv('DBHOST'),
                'database'  => getenv('DBNAME'),
                'username'  => getenv('DBUSER'),
                'password'  => getenv('DBPASS'),
                'charset'   => 'utf8',
                'port'      => 5454 ,
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]
        ]

    ],
];
