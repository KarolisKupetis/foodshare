<?php

namespace Publication\Creator;

use Doctrine\ORM\EntityManager;
use Publication\Entity\Location;

class LocationCreator
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $data
     * @return Location
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createImage($data): ?Location
    {
        $location = $this->createLocationEntity($data);

        return $location;
    }

    private function createLocationEntity($data)
    {
        $location = new Location();

        $location->setLongitude($data['longitude'] ?? null);
        $location->setLatitude($data['latitude'] ?? null);

        return $location;
    }
}