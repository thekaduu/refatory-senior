<?php

namespace Configuration;

class Database
{
    public function a()
    {
        $manager = new \Illuminate\Database\Capsule\Manager();
        $manager->addConnection([
            'driver'    => 'pgsql',
            'host'      => getenv('DBHOST'),
            'database'  => getenv('DBNAME'),
            'username'  => getenv('DBUSER'),
            'password'  => getenv('DBPASS'),
            'charset'   => 'utf8',
            'port'      => getenv('DBPORT') ?? 5432,
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $manager->setAsGlobal();
        $manager->bootEloquent();
    }
}