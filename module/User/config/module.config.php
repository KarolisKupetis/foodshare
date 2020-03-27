<?php
return [
    'service_manager' => [
        'factories' => [
            \User\V1\Rest\UserAuth\UserAuthResource::class => \User\V1\Rest\UserAuth\UserAuthResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'user.rest.user-auth' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/user-auth[/:user_auth_id]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\UserAuth\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'user.rest.user-auth',
        ],
    ],
    'api-tools-rest' => [
        'User\\V1\\Rest\\UserAuth\\Controller' => [
            'listener' => \User\V1\Rest\UserAuth\UserAuthResource::class,
            'route_name' => 'user.rest.user-auth',
            'route_identifier_name' => 'user_auth_id',
            'collection_name' => 'user_auth',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \User\V1\Rest\UserAuth\UserAuthEntity::class,
            'collection_class' => \User\V1\Rest\UserAuth\UserAuthCollection::class,
            'service_name' => 'UserAuth',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'User\\V1\\Rest\\UserAuth\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'User\\V1\\Rest\\UserAuth\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'User\\V1\\Rest\\UserAuth\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \User\V1\Rest\UserAuth\UserAuthEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-auth',
                'route_identifier_name' => 'user_auth_id',
                'hydrator' => \Laminas\Hydrator\ObjectProperty::class,
            ],
            \User\V1\Rest\UserAuth\UserAuthCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user-auth',
                'route_identifier_name' => 'user_auth_id',
                'is_collection' => true,
            ],
        ],
    ],
];
