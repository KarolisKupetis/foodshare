<?php

namespace Mytest;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Mytest\Controller\MoneyController;
use Mytest\Repository\UserRepository;
use Mytest\Repository\AbstractRepositoryFactory;

return [
    ConfigAbstractFactory::class => [
        MoneyController::class => [UserRepository::class],
    ],
    'service_manager' => [
        'abstract_factories' => [
            0 => ConfigAbstractFactory::class,
            1 => AbstractRepositoryFactory::class,
        ],
        'factories' => [
            UserRepository::class => AbstractRepositoryFactory::class,
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