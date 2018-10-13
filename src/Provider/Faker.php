<?php

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Faker\Factory;
use Faker\Generator;
class Faker implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt[Generator::class] = function (Container $cnt): Generator {
            return Factory::create();
        };
    }
}