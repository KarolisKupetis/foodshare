<?php

namespace Publication\Repository;

use Doctrine\ORM\EntityRepository;
use Publication\Entity\Publication;

class CategoryRepository extends EntityRepository
{
    /**
     * @param $name
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByName($name)
    {
        $name = Publication::shortToFull[$name];
        return $this->createQueryBuilder('c')
            ->select()
            ->where('c.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }
}