<?php

namespace Configuration;

use Slim\App;

class DependencyInjector
{
    public static function bootstrap(App $app)
    {
        $container = $app->getContainer();
        $container["teste"] = function ($container) {
            return "a1";
        };
    }
}
