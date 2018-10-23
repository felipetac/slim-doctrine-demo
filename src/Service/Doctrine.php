<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Container\ContainerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use League\Fractal\Manager as Fractal;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\Cursor;
use League\Fractal\TransformerAbstract;
use Slim\Http\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Query;

class Doctrine
{
    protected $container;

    public function __construct(ContainerInterface $container) {
            $this->container = $container;
            $this->fractal = $this->container->get(Fractal::class);
    }

    public function getEntityManager() {
        $config = Setup::createAnnotationMetadataConfiguration(
            $this->container['settings']['doctrine']['metadata_dirs'],
            $this->container['settings']['doctrine']['dev_mode']
        );
        $config->setMetadataDriverImpl(
            new AnnotationDriver(
                new AnnotationReader,
                $this->container['settings']['doctrine']['metadata_dirs']
            )
        );
        $config->setMetadataCacheImpl(
            new FilesystemCache(
                $this->container['settings']['doctrine']['cache_dir']
            )
        );
        return EntityManager::create(
            $this->container['settings']['doctrine']['connection'],
            $config
        );
    }
    
    public function paginate(Request $request, Query $query, TransformerAbstract $transform): array
    {
        $paginator = new Paginator($query);
        $total = $paginator->count();
        $params = (object) $request->getParams();
        $default_limit = $this->container['settings']['doctrine']['pagination']['limit'];
        $currentCursor = property_exists($params, 'cursor') ? (int) $params->cursor : 0;
        $previousCursor = property_exists($params, 'previous') ? (int) $params->previous : null;
        $limit = property_exists($params, 'limit') ? (int) $params->limit : $default_limit;
        if ($limit > $default_limit) {
            $limit = $default_limit;
        }
        if($previousCursor == null && $currentCursor != 0) {
            $previousCursor = $currentCursor - $limit;
            if ($previousCursor <= 0) {
                $previousCursor = null;
            }
        }
        $paginator->getQuery()
                    ->setFirstResult($currentCursor)
                    ->setMaxResults($limit);
        $resource = new Collection($paginator, $transform);       
        $users = $this->fractal->createData($resource)->toArray();
        $newCursor = end($users["data"])["id"];
        if($total == $newCursor) {
            $newCursor = null;
        }
        $cursor = new Cursor($currentCursor, $previousCursor, $newCursor, $total);
        $resource->setCursor($cursor);
        return $this->fractal->createData($resource)->toArray();
    }
}