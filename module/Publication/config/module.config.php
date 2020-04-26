<?php

namespace Publication;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Publication\Creator\ImageCreator;
use Publication\Creator\PublicationCreator;
use Publication\Repository\ImageRepository;
use Publication\Repository\PublicationRepository;
use Publication\Service\PublicationsService;
use Publication\Shared\HierarchyArrayHydrator;
use User\Repository\AbstractRepositoryFactory;
use User\Service\UserService;

return [
    ConfigAbstractFactory::class => [
        EntityManager::class => [],

        PublicationCreator::class => [
          UserService::class,
          EntityManager::class,
          ImageCreator::class,
        ],

        ImageCreator::class => [
            EntityManager::class,
        ],

        PublicationsService::class => [
            PublicationRepository::class,
            PublicationCreator::class,
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            0 => ConfigAbstractFactory::class,
            1 => AbstractRepositoryFactory::class,
        ],
        'factories' => [
            PublicationRepository::class => AbstractRepositoryFactory::class,
            ImageRepository::class => AbstractRepositoryFactory::class,
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
        ],
        'configuration' => [
            'orm_default' => [
                'customHydrationModes' => [
                    HierarchyArrayHydrator::class => HierarchyArrayHydrator::class
                ]
            ]
        ]
    ]
];