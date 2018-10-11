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
        $cnt[App::class] = function (Container $cnt): App {
            $app = new App($cnt);
            $app->group('/user', function() {
                $this->get('', '\App\Controller\User:list');
                $this->post('', '\App\Controller\User:create');
            });
            return $app;
        };
    }
}