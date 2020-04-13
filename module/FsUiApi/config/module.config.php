<?php

use FsUiApi\V1\Rest\Authentication\AuthenticationResource;
use FsUiApi\V1\Rest\Authentication\AuthenticationResourceFactory;
use FsUiApi\V1\Rest\UserProfile\UserProfileResource;
use FsUiApi\V1\Rest\UserProfile\UserProfileResourceFactory;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;

return [
    'service_manager' => [
        'abstract_factories' => [
            0 => ConfigAbstractFactory::class,
        ],
        'factories' => [
            AuthenticationResource::class => AuthenticationResourceFactory::class,
            UserProfileResource::class => UserProfileResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'fs-ui-api.rest.authentication' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/auth[/:auth_id]',
                    'defaults' => [
                        'controller' => 'FsUiApi\\V1\\Rest\\Authentication\\Controller',
                    ],
                ],
            ],
            'fs-ui-api.rest.user-profile' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/user[/:user_id]',
                    'defaults' => [
                        'controller' => 'FsUiApi\\V1\\Rest\\UserProfile\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'fs-ui-api.rest.authentication',
            1 => 'fs-ui-api.rest.user-profile',
        ],
    ],
    'api-tools-rest' => [
        'FsUiApi\\V1\\Rest\\Authentication\\Controller' => [
            'listener' => \FsUiApi\V1\Rest\Authentication\AuthenticationResource::class,
            'route_name' => 'fs-ui-api.rest.authentication',
            'route_identifier_name' => 'auth_id',
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
        'FsUiApi\\V1\\Rest\\UserProfile\\Controller' => [
            'listener' => \FsUiApi\V1\Rest\UserProfile\UserProfileResource::class,
            'route_name' => 'fs-ui-api.rest.user-profile',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'user_profile',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
                4 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \FsUiApi\V1\Rest\UserProfile\UserProfileEntity::class,
            'collection_class' => \FsUiApi\V1\Rest\UserProfile\UserProfileCollection::class,
            'service_name' => 'UserProfile',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'FsUiApi\\V1\\Rest\\Authentication\\Controller' => 'Json',
            'FsUiApi\\V1\\Rest\\UserProfile\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'FsUiApi\\V1\\Rest\\Authentication\\Controller' => [
                0 => 'application/vnd.fs-ui-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'FsUiApi\\V1\\Rest\\UserProfile\\Controller' => [
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
            'FsUiApi\\V1\\Rest\\UserProfile\\Controller' => [
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
                'route_identifier_name' => 'auth_id',
                'hydrator' => \Laminas\Hydrator\ObjectProperty::class,
            ],
            \FsUiApi\V1\Rest\Authentication\AuthenticationCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'fs-ui-api.rest.authentication',
                'route_identifier_name' => 'auth_id',
                'is_collection' => true,
            ],
            \FsUiApi\V1\Rest\UserProfile\UserProfileEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'fs-ui-api.rest.user-profile',
                'route_identifier_name' => 'user_id',
                'hydrator' => \Laminas\Hydrator\ObjectProperty::class,
            ],
            \FsUiApi\V1\Rest\UserProfile\UserProfileCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'fs-ui-api.rest.user-profile',
                'route_identifier_name' => 'user_id',
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
        'FsUiApi\\V1\\Rest\\UserProfile\\Controller' => [
            'input_filter' => 'FsUiApi\\V1\\Rest\\UserProfile\\Validator',
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
        'FsUiApi\\V1\\Rest\\UserProfile\\Validator' => [
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
                'field_type' => 'string',
                'error_message' => 'Invalid email',
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
                'error_message' => 'Invalid password',
            ],
        ],
    ],
];
