<?php

namespace User\Adapter;

use Laminas\ApiTools\MvcAuth\Authentication\AdapterInterface;
use Laminas\ApiTools\MvcAuth\Identity\GuestIdentity;
use Laminas\Http\Header\Location;
use Laminas\Http\Request;
use Laminas\Http\Response;
use Laminas\ApiTools\MvcAuth\MvcAuthEvent;
use Laminas\Session\Container;
use User\Identity\UserIdentity;

class SessionAdapter implements AdapterInterface
{
    /**
     * User email.
     * @var string
     */
    private $email;

    /**
     * Password
     * @var string
     */
    private $password;

    public function provides()
    {
        return [
            'session',
        ];
    }

    public function matches($type)
    {
        return $type == 'session';
    }

    public function getTypeFromRequest(Request $request)
    {
        return false;
    }

    public function preAuth(Request $request, Response $response)
    {
    }

    public function authenticate(Request $request, Response $response, MvcAuthEvent $mvcAuthEvent)
    {
        $session = new Container('authorization');

        if ($request->getRequestUri() === '/auty' && $request->getMethod() === 'POST') {
            return new GuestIdentity();
        }

        return new GuestIdentity();

        if ($session->user) {
            $userIdentity = new UserIdentity($session->user);
            $userIdentity->setName('user');

            return $userIdentity;
        }

        $mvcAuthEvent->stopPropagation();
        $session->redirect = 'http://localhost:3000';
        $location = new Location();
        $location->setUri('http://localhost:3000/login');
        $response->getHeaders()->addHeader($location);
        $response->setStatusCode(302);
        $response->sendHeaders();

        return $response;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = (string)$password;
    }

}