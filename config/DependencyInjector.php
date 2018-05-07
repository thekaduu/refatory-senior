<?php

namespace Configuration;

use Slim\App;
use Monolog\Processor;
use Slim\Views\PhpRenderer;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;
use App\Request\Student\CreateStudentRequest;
use App\Services\StudentService;
use App\Repository\StudentRepository;

class DependencyInjector
{
    public static function bootstrap(App $app)
    {
        $container = $app->getContainer();
        $container[StudentRepository::class] = function ($container) {
            return new StudentRepository();
        };

        $container[StudentService::class] = function ($container) {
            return new StudentService();
        };

        //Renderer
        $container['renderer'] = function ($container) {
            $settings = $container->get('settings')['renderer'];
            return new PhpRenderer($settings['template_path']);
        };



        //MonoLog
        $container['logger'] = function ($c) {
            $settings = $c->get('settings')['logger'];
            $logger = new Logger($settings['name']);
            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
            return $logger;
        };
    }
}
