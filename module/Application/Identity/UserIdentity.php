<?php

use Laminas\ApiTools\MvcAuth\Identity\IdentityInterface;
use Laminas\Permissions\Rbac\Role as AbstractRole;

final class UserIdentity extends AbstractRole implements IdentityInterface
{
    private $user;
    private $name;

    public function __construct(array $user)
    {
        $this->user = $user;
    }

    public function getAuthenticationIdentity()
    {
        return $this->user;
    }

    public function getId()
    {
        return $this->user['id'];
    }

    public function getUser()
    {
        return $this->getAuthenticationIdentity();
    }

    public function getRoleId()
    {
        return $this->name;
    }

    // Alias for roleId
    public function setName($name)
    {
        $this->name = $name;
    }
}