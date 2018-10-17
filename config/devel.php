<?php

use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails' => true,
        'logger' => [
            'name' => 'slim-doctrine-demo',
            'level' => Logger::DEBUG,
            'path' => APP_ROOT . 'log/app.log',
        ],
        'doctrine' => [
            'dev_mode' => true,
            'cache_dir' => APP_ROOT . '/var/doctrine/cache',
            'metadata_dirs' => [APP_ROOT . '/src/Entity'],
            'connection' => [
                'driver' => 'pdo_sqlite',
                'path' => APP_ROOT . '/var/app.db'
            ]
        ]
    ]
];