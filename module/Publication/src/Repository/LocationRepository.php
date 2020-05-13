<?php

namespace Publication\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class LocationRepository  extends EntityRepository
{
    /**
     * @param int $publicationId
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByPublicationId(int $publicationId)
    {
        return $this->createQueryBuilder('i')
            ->select()
            ->where('i.publication = :publicationId')
            ->setParameter('publicationId', $publicationId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findById(int $id)
    {
        return $this->createQueryBuilder('i')
            ->select()
            ->where('i.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
    }
}