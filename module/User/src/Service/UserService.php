<?php

namespace User\Service;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use User\Creator\UserCreator;
use User\Entity\User;
use User\Exceptions\AlreadyExistsException;
use User\Repository\UserRepository;

class UserService
{
    /** @var UserRepository */
    private $repository;

    /**
     * @var UserCreator
     */
    private $userCreator;

    public function __construct(
        UserRepository $repository,
        UserCreator $userCreator
    ) {
        $this->userCreator = $userCreator;
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

    /**
     * @param int $id
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findById(int $id): ?User
    {
        return $this->repository->findById($id);
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws AlreadyExistsException
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createUser(string $email, string $password, string $fullName, string $number): User
    {
        if ($this->findByEmailAsArray($email)) {
            throw new AlreadyExistsException('Email already in use');
        }

        return $this->userCreator->createUser($email, $password, $fullName, $number);
    }
}