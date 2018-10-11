<?php

namespace App\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;

class User implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt[App::class]->group('/user', function () {
            $this->get('', 'App\Controller\User:list')->setName("list-user");
            $this->post('', 'App\Controller\User::create')->setName("create-user");
        });
    }
}