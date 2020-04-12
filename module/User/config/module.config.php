<?php

namespace User;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\ApiTools\MvcAuth\Factory\AuthenticationServiceFactory;
use Laminas\ApiTools\OAuth2\Provider\UserId\AuthenticationService;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use User\Service\AuthManager;
use User\Repository\UserRepository;
use User\Repository\AbstractRepositoryFactory;
use User\Service\UserService;

return [
    ConfigAbstractFactory::class => [
        UserService::class => [
            UserRepository::class
        ],

        AuthManager::class => [
            UserService::class,
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            0 => ConfigAbstractFactory::class,
            1 => AbstractRepositoryFactory::class,
        ],
        'factories' => [
            UserRepository::class => AbstractRepositoryFactory::class,
            AuthenticationService::class => AuthenticationServiceFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];