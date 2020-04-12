<?php

namespace User\Creator;

use Doctrine\ORM\EntityManager;
use User\Entity\User;

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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUser(string $email, string $password): User
    {
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