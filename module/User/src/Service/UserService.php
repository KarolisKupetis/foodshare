<?php

namespace User\Service;

use Doctrine\ORM\NonUniqueResultException;
use User\Entity\User;
use User\Repository\UserRepository;

class UserService
{

    /** @var UserRepository */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws NonUniqueResultException
     */
    public function findByEmailAndPassword(string $email, string $password): User
    {
        return $this->repository->findByUsernameAndPassword($email, $password);
    }

    /**
     * @param string $email
     * @return array[]
     * @throws NonUniqueResultException
     */
    public function findByEmailAsArray(string $email): ?array
    {
        return $this->repository->findByEmailAsArray($email);
    }
}