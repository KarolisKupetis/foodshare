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
     * @param string $fullName
     * @param string $number
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createUser(string $email, string $password, string $fullName, string $number): User
    {
        $crypt = new Bcrypt();
        $password = $crypt->create($password);

        $user = $this->createUserEntity($email, $password, $fullName, $number);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param $email
     * @param $password
     * @param string $fullName
     * @param string $number
     * @return User
     */
    private function createUserEntity(string $email, string $password, string $fullName, string $number): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setFullName($fullName);
        $user->setNumber($number);


        return $user;
    }
}