<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;
use App\Entity\User as UserEntity;
use Slim\Http;

class User
{
   protected $container;

   public function __construct(ContainerInterface $container) {
       $this->container = $container;
       $this->faker = $this->container->get('faker');
       $this->em = $this->container->get('em');
   }

   public function list($request, $response, $args): Http\Response {
        $users = $this->em->getRepository(UserEntity::class)
                          ->findAll();
        return $response->withJson($users, 200);
   }

   public function create($request, $response, $args): Http\Response {
        $newRandomUser = new UserEntity($this->faker->name, $this->faker->password);
        $this->em->persist($newRandomUser);
        $this->em->flush();
        return $response->withJson($newRandomUser, 201);
   }
}