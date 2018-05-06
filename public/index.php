<?php

use Dotenv\Dotenv;
use Configuration\DependencyInjector;

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register routes
require __DIR__ . '/../src/routes.php';

(new Dotenv(__DIR__ . '/..'))->load();

DependencyInjector::bootstrap($app);

$manager = new \Illuminate\Database\Capsule\Manager();
$manager->addConnection([
    'driver'    => 'pgsql',
    'host'      => getenv('DBHOST'),
    'database'  => getenv('DBNAME'),
    'username'  => getenv('DBUSER'),
    'password'  => getenv('DBPASS'),
    'charset'   => 'utf8',
    'port'      => 5454 ,
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$manager->setAsGlobal();
$manager->bootEloquent();

// Run app
$app->run();
