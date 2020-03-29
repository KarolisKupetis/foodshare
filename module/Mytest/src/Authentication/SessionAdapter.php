<?php

namespace Mytest\Authentication;

use Laminas\ApiTools\MvcAuth\Authentication\AdapterInterface;
use Laminas\ApiTools\MvcAuth\Identity\IdentityInterface;
use Laminas\ApiTools\MvcAuth\MvcAuthEvent;
use Laminas\Http\Request;
use Laminas\Http\Response;
use Laminas\Session\Container;
use Laminas\ApiTools\MvcAuth\Identity;

final class SessionAdapter implements AdapterInterface
{

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            'session',
        ];
    }

    /**
     * @inheritDoc
     */
    public function matches($type)
    {
        return $type == 'session';
    }

    /**
     * @inheritDoc
     */
    public function getTypeFromRequest(Request $request)
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function preAuth(Request $request, Response $response)
    {

    }

    /**
     * @inheritDoc
     */
    public function authenticate(Request $request, Response $response, MvcAuthEvent $mvcAuthEvent)
    {
        $session = new Container('webauth');

        if ($session->auth) {
            $userIdentity = new Identity\UserIdentity($session->auth);
            $userIdentity->setName('user');

            return $userIdentity;
        }

        // Force login for all other routes
        $mvcAuthEvent->stopPropagation();
        $session->redirect = $request->getUriString();
        $response->getHeaders()->addHeaderLine('Location', '/login');
        $response->setStatusCode(302);
        $response->sendHeaders();

        return $response;
    }
}