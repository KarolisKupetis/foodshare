<?php

namespace Publication\Repository;

use Doctrine\ORM\EntityRepository;

class ImageRepository  extends EntityRepository
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
}