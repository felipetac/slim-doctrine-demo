<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Faker\Generator;
use App\Entity\User as UserEntity;
use Slim\Http;
use League\Fractal\Manager as Fractal;
use League\Fractal\Resource\Collection;
use App\Transformer\User as UserTransformer;

class User
{
   protected $container;

   public function __construct(ContainerInterface $container) {
       $this->container = $container;
       $this->faker = $this->container->get(Generator::class);
       $this->em = $this->container->get(EntityManager::class);
       $this->fractal = $this->container->get(Fractal::class);
   }

   public function list($request, $response, $args): Http\Response {
        $users = $this->em->getRepository(UserEntity::class)->findAll();
        $resource = new Collection($users, new UserTransformer);                       
        return $response->withJson($this->fractal->createData($resource)->toArray(), 200);
   }

   public function create($request, $response, $args): Http\Response {
        $newRandomUser = new UserEntity($this->faker->name, $this->faker->password);
        $this->em->persist($newRandomUser);
        $this->em->flush();
        return $response->withJson($newRandomUser, 201);
   }
}