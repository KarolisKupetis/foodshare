<?php

namespace Publication\Service;

use Publication\Creator\PublicationCreator;
use Publication\Repository\PublicationRepository;

class PublicationsService
{
    /** @var PublicationRepository */
    private $repository;

    /** @var PublicationCreator */
    private $creator;

    public function __construct(PublicationRepository $repository, PublicationCreator $creator)
    {
        $this->repository = $repository;
        $this->creator = $creator;

    }

    /**
     * @return array
     */
    public function findAllAsArray()
    {
       return $this->repository->findAllAsArray();
    }

    /**
     * @param $data
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createPublication($data): void
    {
        $this->creator->createPublication($data);
    }
}