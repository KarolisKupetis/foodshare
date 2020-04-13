<?php
namespace FsUiApi\V1\Rest\UserProfile;

use Psr\Container\ContainerInterface;
use User\Service\AuthManager;
use User\Service\UserService;

class UserProfileResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $authManager = $services->get(AuthManager::class);
        $userService = $services->get(UserService::class);

        return new UserProfileResource($authManager, $userService);
    }
}
