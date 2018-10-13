<?php
require __DIR__.'/../vendor/autoload.php';
$cnt = App\Bootstrap::getAppInstance()->getContainer();
return $cnt;