<?php

namespace User\Creator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use User\Entity\User;
use Laminas\Crypt\Password\Bcrypt;

class UserCreator
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createUser(string $email, string $password): User
    {
        $crypt = new Bcrypt();
        $password = $crypt->create($password);

        $user = $this->createUserEntity($email, $password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param $email
     * @param $password
     * @return User
     */
    private function createUserEntity($email, $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);

        return $user;
    }
}