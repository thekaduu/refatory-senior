<?php

use Dotenv\Dotenv;
use Configuration\DependencyInjector;
use Configuration\ConnectionManager;
use Slim\App;

require __DIR__ . '/../vendor/autoload.php';
$settings = require __DIR__ . '/../src/settings.php';

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
session_start();
// Instantiate the app
$app = new App($settings);

/**
 * Resolve um container
 *
 * @author Carlos Eduardo L. Braz <carloseduardolbraz@gmail.com>
 * @param string $serviceName
 * @return mixed
 */
function resolve(string $serviceName)
{
    global $app;
    $container = $app->getContainer();
    return $container->get($serviceName);
}

// Register routes
require __DIR__ . '/../src/routes.php';

(new Dotenv(__DIR__ . '/..'))->load();

DependencyInjector::bootstrap($app);
ConnectionManager::createConnection();

// Run app
$app->run();