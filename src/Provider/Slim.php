<?php

declare(strict_types=1);

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;

class Slim implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt[App::class] = function ($cnt): App {
            $app = new App($cnt);
            return $app;
        };
    }
}