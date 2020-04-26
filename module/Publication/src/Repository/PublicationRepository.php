<?php

namespace Publication\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Publication\Shared\HierarchyArrayHydrator;

class PublicationRepository extends EntityRepository
{
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

    public function findAllAsArray()
    {
        return $this->createQueryBuilder('p')
            ->select()
            ->addSelect('im')
            ->leftJoin('p.images', 'im')
            ->getQuery()
            ->getResult(HierarchyArrayHydrator::class);
    }
}