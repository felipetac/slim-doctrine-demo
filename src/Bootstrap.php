<?php

namespace App;

use Slim\App;
use Slim\Container;
use Monolog\Logger;
use App\Service\Doctrine;
use App\Service\Slim;
use App\Service\Faker;

class Bootstrap
{
    public static function getAppInstance(): App
    {
        define('APP_ROOT', __DIR__.'/../');

        $config = [
            'settings' => [
                'displayErrorDetails' => true,   
                'logger' => [
                    'name' => 'slim-doctrine-demo',
                    'level' => Logger::DEBUG,
                    'path' => APP_ROOT . 'log/app.log',
                ],
                'doctrine' => [
                    'dev_mode' => true,
                    'cache_dir' => APP_ROOT . 'var/doctrine',
                    'metadata_dirs' => [APP_ROOT . 'src/Entity'],
                    'connection' => [
                        'driver' => 'pdo_sqlite',
                        'path' => APP_ROOT . 'var/app.db'
                    ]
                ]
            ],
        ];
        
        $cnt = new Container($config);

        $cnt->register(new Doctrine())
            ->register(new Slim())
            ->register(new Faker());

        return $cnt["app"];
    }
}