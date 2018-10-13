<?php



namespace App\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Doctrine implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt[EntityManager::class] = function (Container $cnt): EntityManager {
            $config = Setup::createAnnotationMetadataConfiguration(
                $cnt['settings']['doctrine']['metadata_dirs'],
                $cnt['settings']['doctrine']['dev_mode']
            );
            $config->setMetadataDriverImpl(
                new AnnotationDriver(
                    new AnnotationReader,
                    $cnt['settings']['doctrine']['metadata_dirs']
                )
            );
            $config->setMetadataCacheImpl(
                new FilesystemCache(
                    $cnt['settings']['doctrine']['cache_dir']
                )
            );
            return EntityManager::create(
                $cnt['settings']['doctrine']['connection'],
                $config
            );
        };
    }
}