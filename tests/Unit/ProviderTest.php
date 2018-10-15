<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Container;
use App\Provider;
use Faker\Generator;

class ProvidersTest extends TestCase
{
    public function testContainer(): void
    {
        $sut = new Container(require APP_ROOT . '/settings.php');
        $sut->register(new Provider\Slim())
            ->register(new Provider\Doctrine())
            ->register(new Provider\Faker())
            ->register(new Provider\User());
        self::assertInstanceOf(App::class, $sut[App::class]);
        self::assertInstanceOf(EntityManager::class, $sut[EntityManager::class]);
        self::assertInstanceOf(Generator::class, $sut[Generator::class]);
    }
}