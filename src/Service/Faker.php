<?php

namespace App\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Faker\Factory;
use Faker\Generator;
class Faker implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt['faker'] = function (Container $cnt): Generator {
            return Factory::create();
        };
    }
}