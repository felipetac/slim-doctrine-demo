<?php

namespace App\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;
use App\Controller\User as UserController;

class Slim implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt['app'] = function (Container $cnt): App {
            $app = new App($cnt);
            $app->get('/user', UserController::class . ':list');
            $app->post('/user', UserController::class . ':create');
            return $app;
        };
    }
}