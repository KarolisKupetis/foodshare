<?php

namespace Application\Authorization;

use Application\Controller\IndexController;
use Laminas\ApiTools\MvcAuth\MvcAuthEvent;
use Laminas\ApiTools\OAuth2\Controller\AuthController;

final class AuthorizationListener
{
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $authorization = $mvcAuthEvent->getAuthorizationService();

        // Deny from all
        //$authorization->deny();

//        $authorization->addResource(IndexController::class . '::index');
//        $authorization->allow('guest', IndexController::class . '::index');
//
//        $authorization->addResource(AuthController::class . '::authorize');
//        $authorization->allow('user', AuthController::class . '::authorize');
    }
}