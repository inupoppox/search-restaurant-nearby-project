<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
// could use this instead                   'url' => 'mysql://dbuser:dbpassword@localhost/dbname',
                    'driver' => 'pdo_mysql',
                    'host' => 'db', // uses the name of the container from docker-compose
                    'dbname' => 'dbname',
                    'user' => 'dbuser',
                    'password' => '654321',
                    'charset'  => 'utf8',
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'app_entity',
                ],
            ],
            'app_entity' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../../src/App/src/Entity'],
            ],
        ],
    ],
];