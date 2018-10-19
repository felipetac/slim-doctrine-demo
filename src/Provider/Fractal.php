<?php

declare(strict_types=1);

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class Fractal implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt[Manager::class] = function (Container $cnt): Manager {
            return new Manager();
        };
    }
}