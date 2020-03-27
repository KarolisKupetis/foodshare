<?php

namespace Mytest\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Mytest\Entity\User;

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
}