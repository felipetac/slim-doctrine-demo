<?php

namespace App\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;

class User implements ServiceProviderInterface
{
    public function register(Container $cnt)
    { 
        $cnt[App::class]->group('/user', function($app) {
            $app->get('', '\App\Controller\User:list');
            $app->post('', '\App\Controller\User:create');
        }); 
    }
}