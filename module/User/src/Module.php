<?php

namespace User;

use User\Adapter\SessionAdapter;
use Laminas\ApiTools\MvcAuth\Authentication\DefaultAuthenticationListener;
use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Mvc\ApplicationInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(EventInterface $e): void
    {
        /** @var ApplicationInterface $application */
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();

        /** @var ServiceLocatorInterface $container */
        $container = $application->getServiceManager();

        // Add Authentication Adapter for session
        $defaultAuthenticationListener = $container->get(DefaultAuthenticationListener::class);
        $defaultAuthenticationListener->attach(new SessionAdapter());
    }
}