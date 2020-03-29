<?php

use Application\Authentication\Adapter\SessionAdapter;

return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'DBMysql' => [],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authentication' => [
            'map' => [
                'DbApi\\V1' => 'oauth2',
                'Laminas\\ApiTools\\OAuth2' => 'session',
                'User\\V1' => 'session',
            ],
            'adapters' => [
                'oauth2' => [
                    'adapter' => \Laminas\ApiTools\MvcAuth\Authentication\OAuth2Adapter::class,
                    'storage' => [
                        'adapter' => \pdo::class,
                        'dsn' => 'mysql:host=localhost;dbname=foodsharing',
                        'username' => 'root',
                        'password' => '',
                        'options' => [
                            1002 => 'SET NAMES utf8',
                        ],
                    ],
                ],
                'session' => [
                    'adapter' => SessionAdapter::class,
                ],
            ],
        ],
    ],
];
