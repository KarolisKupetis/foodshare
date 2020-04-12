<?php
return [
    'service_manager' => [
        'abstract_factories' => [
            0 => \Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory::class,
        ],
        'factories' => [
            \FsUiApi\V1\Rest\Authentication\AuthenticationResource::class => \FsUiApi\V1\Rest\Authentication\AuthenticationResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'fs-ui-api.rest.authentication' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/auty[/:auty_id]',
                    'defaults' => [
                        'controller' => 'FsUiApi\\V1\\Rest\\Authentication\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'fs-ui-api.rest.authentication',
        ],
    ],
    'api-tools-rest' => [
        'FsUiApi\\V1\\Rest\\Authentication\\Controller' => [
            'listener' => \FsUiApi\V1\Rest\Authentication\AuthenticationResource::class,
            'route_name' => 'fs-ui-api.rest.authentication',
            'route_identifier_name' => 'auty_id',
            'collection_name' => 'authentication',
            'entity_http_methods' => [
                0 => 'POST',
                1 => 'DELETE',
                2 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \FsUiApi\V1\Rest\Authentication\AuthenticationEntity::class,
            'collection_class' => \FsUiApi\V1\Rest\Authentication\AuthenticationCollection::class,
            'service_name' => 'Authentication',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'FsUiApi\\V1\\Rest\\Authentication\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'FsUiApi\\V1\\Rest\\Authentication\\Controller' => [
                0 => 'application/vnd.fs-ui-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'FsUiApi\\V1\\Rest\\Authentication\\Controller' => [
                0 => 'application/vnd.fs-ui-api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \FsUiApi\V1\Rest\Authentication\AuthenticationEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'fs-ui-api.rest.authentication',
                'route_identifier_name' => 'auty_id',
                'hydrator' => \Laminas\Hydrator\ObjectProperty::class,
            ],
            \FsUiApi\V1\Rest\Authentication\AuthenticationCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'fs-ui-api.rest.authentication',
                'route_identifier_name' => 'auty_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'FsUiApi\\V1\\Rest\\Authentication\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'FsUiApi\\V1\\Rest\\Authentication\\Controller' => [
            'input_filter' => 'FsUiApi\\V1\\Rest\\Authentication\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'FsUiApi\\V1\\Rest\\Authentication\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\EmailAddress::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'email',
                'field_type' => 'email',
                'error_message' => 'Email not provided',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'password',
                'error_message' => 'Password is required.',
            ],
        ],
    ],
];
