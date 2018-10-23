<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Faker\Generator;
use App\Entity\User as UserEntity;
use Slim\Http;
use League\Fractal\Manager as Fractal;
use League\Fractal\Resource\Item;
use App\Transformer\User as UserTransformer;
use Doctrine\ORM\Tools\Pagination\Paginator;
use League\Fractal\Pagination\Cursor;
use App\Service\Doctrine as DoctrineService;

class User
{
   protected $container;

   public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->faker = $this->container->get(Generator::class);
        $this->doctrine = $this->container->get(DoctrineService::class);
        $this->em = $this->doctrine->getEntityManager();
        $this->fractal = $this->container->get(Fractal::class);
   }

   public function list($request, $response, $args): Http\Response {
        $query = $this->em->createQuery("SELECT u FROM App\Entity\User u"); 
        $users = $this->doctrine->paginate($request, $query, new UserTransformer);
        return $response->withJson($users, 200);
   }

   public function create($request, $response, $args): Http\Response {
        $newRandomUser = new UserEntity($this->faker->name, $this->faker->password);
        $this->em->persist($newRandomUser);
        $this->em->flush();
        $resource = new Item($newRandomUser, new UserTransformer);
        $user = $this->fractal->createData($resource)->toArray();
        return $response->withJson($user, 201);
   }
}