<?php

use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;

return [
    'doctrine' => [
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/Migrations',
                'name'      => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table'     => 'migrations',
            ],
        ],
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'user' => 'root',
                    'password' => '',
                    'host' => 'localhost',
                    'dbname' => 'foodsharing',
                    'port' => '3306',
                    'charset' => 'utf8',
                    'collate' => 'utf8_general_ci',
                ],
            ],
        ],
    ],
];
