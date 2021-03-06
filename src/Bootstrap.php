<?php

declare(strict_types=1);

namespace App;

use Slim\App;
use Slim\Container;
use App\Provider\Doctrine;
use App\Provider\Slim;
use App\Provider\Faker;
use App\Provider\Router;
use App\Provider\CORS;
use App\Provider\Fractal;

class Bootstrap
{
    public static function getAppInstance(): App
    {
        define('APP_ROOT', __DIR__.'/../');

        if (!file_exists(APP_ROOT . '/settings.php')) {
            copy(APP_ROOT . '/config/devel.php', APP_ROOT . '/settings.php');
        }
        
        $cnt = new Container(require APP_ROOT . '/settings.php');
        
        $cnt->register(new Doctrine())
            ->register(new Slim())
            ->register(new CORS())
            ->register(new Faker())
            ->register(new Fractal())
            ->register(new Router());

        return $cnt[App::class];
    }
}