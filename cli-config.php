<?php

require 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\DBAL\Tools\Console as DBALConsole;
use App\Service\Doctrine as DoctrineService;

$cnt = App\Bootstrap::getAppInstance()->getContainer();

$connection = $cnt[DoctrineService::class]->getEntityManager()->getConnection();

$configuration = new Configuration($connection);
$configuration->setName('App Migrations');
$configuration->setMigrationsNamespace('App\Migrations');
$configuration->setMigrationsTableName('doctrine_migration_versions');
$configuration->setMigrationsColumnName('version');
$configuration->setMigrationsColumnLength(255);
$configuration->setMigrationsExecutedAtColumnName('executed_at');
$configuration->setMigrationsDirectory(__DIR__.'/var/doctrine/migrations');
$configuration->setAllOrNothing(true);

$helperSet = new HelperSet();
$helperSet->set(new QuestionHelper(), 'question');
$helperSet->set(new ConnectionHelper($connection), 'db');
$helperSet->set(new EntityManagerHelper($cnt[DoctrineService::class]->getEntityManager()), 'em');
$helperSet->set(new ConfigurationHelper($connection, $configuration));


$cli = new Application('Doctrine Migrations');
$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);

$cli->addCommands(array(
    new Command\DumpSchemaCommand(),
    new Command\ExecuteCommand(),
    new Command\GenerateCommand(),
    new Command\LatestCommand(),
    new Command\MigrateCommand(),
    new Command\RollupCommand(),
    new Command\StatusCommand(),
    new Command\VersionCommand(),

    // DBAL Commands
    new DBALConsole\Command\ImportCommand(),
    new DBALConsole\Command\ReservedWordsCommand(),
    new DBALConsole\Command\RunSqlCommand(),

    // ORM Commands
    new Doctrine\ORM\Tools\Console\Command\ClearCache\CollectionRegionCommand(),
    new Doctrine\ORM\Tools\Console\Command\ClearCache\EntityRegionCommand(),
    new Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
    new Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
    new Doctrine\ORM\Tools\Console\Command\ClearCache\QueryRegionCommand(),
    new Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
    new Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
    new Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
    new Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
    new Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
    new Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
    new Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
    new Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
    new Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
    new Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
    new Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
    new Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
    new Doctrine\ORM\Tools\Console\Command\InfoCommand(),
    new Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand(),
));

$cli->run();

/* 

// Montei o cli conforme os exemplos no site

// https://www.doctrine-project.org/projects/doctrine-migrations/en/latest/reference/custom-integration.html#custom-integration
// https://www.doctrine-project.org/projects/doctrine-migrations/en/latest/reference/custom-configuration.html#custom-configuration


// Código do exemplo porém estava dand bug onde não trazia os comandos do migration. [OLD]

require 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$cnt = App\Bootstrap::getAppInstance()->getContainer();
ConsoleRunner::run(ConsoleRunner::createHelperSet($cnt[EntityManager::class]));

*/