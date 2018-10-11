<?php

namespace App\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;

class Slim implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt[App::class] = function (Container $cnt): App {
            $app = new App($cnt);
            return $app;
        };
    }
}