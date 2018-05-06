<?php

namespace App\Controller;

use Slim\Container;

abstract class BaseController
{
    protected $containerProvider;

    public function __construct(Container $container)
    {
        $this->containerProvider = $container;
    }

    protected function resolve($containerName)
    {
        return $this->containerProvider->get($containerName);
    }


}