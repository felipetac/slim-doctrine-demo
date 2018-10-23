<?php

declare(strict_types=1);

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use App\Service\Doctrine as DoctrineService;

class Doctrine implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt[DoctrineService::class] = function ($cnt): DoctrineService {
            return new DoctrineService($cnt);
        };
    }
}