<?php
require __DIR__.'/../vendor/autoload.php';
$cnt = App\Bootstrap::instance();
$app = $cnt['app'];
$app->run();