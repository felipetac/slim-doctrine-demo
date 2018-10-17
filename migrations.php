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

$cnt = App\Bootstrap::getAppInstance()->getContainer();

$connection = $cnt[EntityManager::class]->getConnection();

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
    new Command\VersionCommand()
));

$cli->run();

/* 

Versão dev do doctrine/migration está com bug no bin do composer. 
Criei este arquivo CLI customizado conforme documentação

https://www.doctrine-project.org/projects/doctrine-migrations/en/latest/reference/custom-integration.html#custom-integration
https://www.doctrine-project.org/projects/doctrine-migrations/en/latest/reference/custom-configuration.html#custom-configuration


Uso - Para executar o migrate é:

php migrations.php [command]

*/