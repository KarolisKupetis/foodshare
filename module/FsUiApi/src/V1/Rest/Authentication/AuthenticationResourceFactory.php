<?php
namespace FsUiApi\V1\Rest\Authentication;

use User\Service\AuthManager;
use Psr\Container\ContainerInterface;

class AuthenticationResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $authManager = $services->get(AuthManager::class);

        return new AuthenticationResource($authManager);
    }
}
