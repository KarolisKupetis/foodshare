<?php
namespace User\V1\Rest\UserAuth;

use Mytest\Controller\MoneyController;
use Psr\Container\ContainerInterface;


class UserAuthResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
       $class = $services->get(MoneyController::class);

        return new UserAuthResource($class);
    }
}