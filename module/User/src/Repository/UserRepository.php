<?php

namespace User\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use User\Entity\User;

class UserRepository extends EntityRepository
{
    /**
     * @param $userId
     *
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function getById(int $userId) :User
    {
        return $this->createQueryBuilder('u')
            ->select()
            ->where('u.id = :name')
            ->setParameter('name', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $userId
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findById(int $userId): ?User
    {
        return $this->createQueryBuilder('u')
            ->select()
            ->where('u.id = :name')
            ->setParameter('name', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $email
     * @param string $password
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findByUsernameAndPassword(string $email, string $password)
    {
        return $this->createQueryBuilder('u')
            ->select()
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->andWhere('u.password = :password')
            ->setParameter('password', $password)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $email
     * @return array[]
     * @throws NonUniqueResultException
     */
    public function findByEmailAsArray(string $email): ?array
    {
        return $this->createQueryBuilder('u')
            ->select()
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
    }
}