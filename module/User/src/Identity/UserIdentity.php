<?php

namespace User\Identity;

use Laminas\ApiTools\MvcAuth\Identity\IdentityInterface;
use Laminas\Permissions\Rbac\Role as AbstractRbacRole;

final class UserIdentity extends AbstractRbacRole implements IdentityInterface
{
    private $user;
    protected $id;

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