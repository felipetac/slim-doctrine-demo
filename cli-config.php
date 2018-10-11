<?php

require 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$cnt = App\Bootstrap::getAppInstance()->getContainer();
ConsoleRunner::run(ConsoleRunner::createHelperSet($cnt['em']));