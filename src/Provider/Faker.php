<?php

declare(strict_types=1);

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Faker\Factory;
use Faker\Generator;
class Faker implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt[Generator::class] = function ($cnt): Generator {
            return Factory::create();
        };
    }
}